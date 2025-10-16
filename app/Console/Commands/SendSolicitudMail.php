<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\SolicitudRecibidaMail;
use Carbon\Carbon;

class SendMailSolicitud extends Command
{
    protected $signature = 'mail:solicitud {email} {nombre} {puesto}';
    protected $description = 'Envía un correo de confirmación de solicitud de contratación';

    public function handle()
    { 
        $email = $this->argument('email');
        $nombre = $this->argument('nombre');
        $puesto = $this->argument('puesto');

        $solicitudData = (object)[
            'jefe_nombre' => $nombre,
            'puesto' => $puesto,
            'fecha_envio' => Carbon::now(),
        ];

        // Crear objeto usuario
        $usuario = (object)[
            'email' => $email,
            'name' => $nombre,
        ];

        Mail::to($email)->send(new SolicitudRecibidaMail($solicitudData, $usuario));

        $this->info("Correo enviado a {$email}");
    }
}
