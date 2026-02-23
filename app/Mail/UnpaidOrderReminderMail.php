<?php

namespace App\Mail;

use App\Models\OrderTicket;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketPaymentRejectedMail extends Mailable {
    use Queueable, SerializesModels;

    public function __construct(
        public OrderTicket $orderTicket,
        public Payment $payment
    ) {}

    public function build()
    {
        return $this->subject('Paiement non validé — '.$this->orderTicket->reference)
            ->view('emails.tickets.payment_rejected')
            ->with([
                'order'   => $this->orderTicket,
                'payment' => $this->payment,
            ]);
    }
}
