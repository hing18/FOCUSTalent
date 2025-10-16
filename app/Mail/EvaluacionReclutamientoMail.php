<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EvaluacionReclutamientoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $empleados;
    public $url;
    public $puesto;

    public function __construct($empleados, $puesto, $url)
    {
        $this->empleados = $empleados;
        $this->puesto = $puesto;
        $this->url = $url;
    }

    public function build()
    {
        return $this->subject('Evaluación del proceso de reclutamiento')
                    ->view('emails.evaluacion_reclutamiento');
    }
}
