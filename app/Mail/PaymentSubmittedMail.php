<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;
use App\Models\Payment;

class PaymentSubmittedMail extends Mailable implements ShouldQueue {
    use Queueable, SerializesModels;

    public $payment, $order;


    public function __construct(Order $order, Payment $payment) {
            $this->order = $order;
            $this->payment = $payment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope {
        return new Envelope(
            subject: 'Paiement soumis',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content{
        return new Content(
            view: 'emails.shop.payment_submitted',
            with: [
                'payment' => $this->payment,
                'order' => $this->order,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
