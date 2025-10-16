<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SolicitudRecibidaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $solicitud;
    public $usuario;

    public function __construct($solicitud, $usuario)
    {
        $this->solicitud = $solicitud;
        $this->usuario = $usuario;
    }

    public function build()
    {
        return $this->subject('Confirmación de Solicitud de Contratación')->markdown('emails.solicitud_recibida');
    }
}
