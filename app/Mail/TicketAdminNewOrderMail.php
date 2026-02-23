<?php

namespace App\Mail;

use App\Models\OrderTicket;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketAdminNewOrderMail extends Mailable {
    use Queueable, SerializesModels;

    public function __construct(
        public OrderTicket $orderTicket,
        public Payment $payment
    ) {}

    public function build() {
        return $this->subject('Nouvelle commande de billets — '.$this->orderTicket->reference)
            ->view('emails.tickets.admin_new_order')
            ->with([
                'order'   => $this->orderTicket,
                'payment' => $this->payment,
            ]);
    }
}
