<?php

namespace App\Mail;

use App\Models\OrderTicket;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketPaymentVerifiedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public OrderTicket $orderTicket,
        public Payment $payment
    ) {}

    public function build()
    {
        return $this->subject('Paiement validé — '.$this->orderTicket->reference)
            ->view('emails.tickets.payment_verified')
            ->with([
                'order'   => $this->orderTicket,
                'payment' => $this->payment,
            ]);
    }
}
