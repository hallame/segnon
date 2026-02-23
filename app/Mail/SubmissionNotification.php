<?php

namespace App\Mail;

use App\Models\ContentSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubmissionNotification extends Mailable {
    use Queueable, SerializesModels;

    public $submission;
    public $modelName;
    public $userName;

    public function __construct(ContentSubmission $submission) {
        $this->submission = $submission;
        $this->modelName = class_basename($submission->model_type);
        $this->userName = $submission->user->full_name ?? 'Utilisateur inconnu';
    }

    public function envelope(): Envelope {
        return new Envelope(
            subject: 'Nouvelle soumission à modérer - ' . $this->modelName,
        );
    }

    public function content(): Content {
        return new Content(
            view: 'emails.submissions.products.admin',
        );
    }

    public function attachments(): array {
        return [];
    }
}
