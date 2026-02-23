<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable {
    use Queueable, SerializesModels;

    public string $firstname;
    public string $lastname;
    public string $email;
    public ?string $phone;
    public string $subjectLine;
    public string $messageContent;

    public function __construct(
        string $firstname,
        string $lastname,
        string $email,
        ?string $phone,
        string $subject,
        string $messageContent
    ) {
        $this->firstname      = $firstname;
        $this->lastname       = $lastname;
        $this->email          = $email;
        $this->phone          = $phone;
        $this->subjectLine    = $subject;
        $this->messageContent = $messageContent;
    }

    public function envelope(): Envelope {
        return new Envelope(
            subject: 'Formulaire de contact : '.$this->subjectLine,
        );
    }

    public function content(): Content {
        return new Content(
            view: 'emails.contact',
            with: [
                'firstname'      => $this->firstname,
                'lastname'       => $this->lastname,
                'email'          => $this->email,
                'phone'          => $this->phone,
                'subject'        => $this->subjectLine,
                'messageContent' => $this->messageContent,
            ]
        );
    }

    public function attachments(): array {
        return [];
    }
}
