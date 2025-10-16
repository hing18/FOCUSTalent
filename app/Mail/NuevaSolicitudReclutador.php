<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NuevaSolicitudReclutador extends Mailable
{
    use Queueable, SerializesModels;

    public $solicitud;
    

    public function __construct($solicitud)
    {
        $this->solicitud = $solicitud; // Datos de la solicitud
        
    }

    public function build()
    {
        return $this->subject('Nueva Solicitud de Contratación')
                    ->markdown('emails.nueva_solicitud_reclutador');
    }
}

