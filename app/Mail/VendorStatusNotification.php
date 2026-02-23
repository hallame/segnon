<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VendorStatusNotification extends Mailable {
    use Queueable, SerializesModels;

    public $data;

    public function __construct(array $data) {
        $this->data = $data;
    }

    public function build() {
        $subject = match($this->data['status']) {
            'approved' => '✅ Publié !',
            'rejected' => '⚠️ Action requise',
            default => 'Mise à jour de statut de votre produit',
        };

        return $this->subject($subject)
            ->markdown('emails.submissions.products.vendors')
            ->with('data', $this->data);
    }
}
