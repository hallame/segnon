<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ClientWelcomeMail extends Mailable {
    use Queueable, SerializesModels;

    public $client, $password;



    public function __construct(User $client, $password) {

        $this->client = $client;
        $this->password = $password;

    }

    public function envelope(): Envelope {
        return new Envelope(
            subject: 'Bienvenue sur Zaly Merveille',
        );
    }

    public function content(): Content {
        return new Content(
            view: 'emails.client.welcome',
            with: [
                'password' => $this->password,
                'client' => $this->client,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array {
        return [];
    }
}
