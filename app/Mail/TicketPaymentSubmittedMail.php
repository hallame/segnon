<?php

namespace App\Mail;

use App\Models\OrderTicket;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketPaymentSubmittedMail extends Mailable {
    use Queueable, SerializesModels;

    public function __construct(
        public OrderTicket $orderTicket,
        public Payment $payment
    ) {}

    public function build() {
        return $this->subject('Nous avons bien reçu votre paiement — '.$this->orderTicket->reference)
            ->view('emails.tickets.order_submitted')
            ->with([
                'order'   => $this->orderTicket,
                'payment' => $this->payment,
            ]);
    }
}
