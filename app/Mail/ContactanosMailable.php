<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class ContactanosMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->data['subject'] ?? 'FOCUSTalent Notification'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contactanos',
            with: [
                'body' => $this->data['body'] ?? '',
                'html' => $this->data['html'] ?? ''
            ]
        );
    }

    public function attachments(): array
    {
        return []; // No adjuntos en este caso
    }
}
