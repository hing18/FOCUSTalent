<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\NuevaSolicitudReclutador;

class SendMailNuevaSolicitudReclutador extends Command
{
    protected $signature = 'mail:reclutador {email} {solicitudJson}';
    protected $description = 'Envía correo a los reclutadores con la nueva solicitud';

    public function handle()
    {
        $email = $this->argument('email');
        $solicitud = json_decode($this->argument('solicitudJson'));

        Mail::to($email)->send(new NuevaSolicitudReclutador($solicitud));
        $this->info("Correo enviado a {$email}");
    }
}
