<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\OrderTicket;
use App\Models\Payment;

class TicketPaymentRejectedMail extends Mailable {
    use Queueable, SerializesModels;

    public function __construct(
        public OrderTicket $orderTicket,
        public Payment $payment
    ) {}

    public function build() {
        return $this->subject('Paiement ticket non validé — '.$this->orderTicket->reference)
            ->view('emails.tickets.payment_rejected')
            ->with([
                'order'   => $this->orderTicket,
                'payment' => $this->payment,
            ]);
    }
}
