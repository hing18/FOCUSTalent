<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactanosMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->data=$data;         
    }

    public function envelope(): Envelope
    {
        return new Envelope(
           // from:new Address('FOCUSTalent@plazareg.com','FOCUS Talen'),
            subject: 'Programación de Entrevista Funcional (PRUEBA)',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contactanos',
        );
    }

    
    public function attachments(): array
    {    $fileext=explode(".", $this->data['cv_doc']);
        $file=$this->data['cv_doc'];
        return [        
            Attachment::fromPath($file)
            ->as('CV-'.$this->data['nombre'].".".$fileext[1])
            ->withMime('application/'.$fileext[1]),
        ];
    }
}
