<?php


namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EntrevistaFuncionalMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $icalContent = $this->generateICS();

        return $this->markdown('emails.entrevista_funcional')
            ->subject('Entrevista Programada: ' . $this->data['nom_candidato'])
            ->attachData($icalContent, 'entrevista.ics', [
                'mime' => 'text/calendar',
            ])
            ->with($this->data);
    }
    

 
    protected function generateICS()
    {
        $start = date('Ymd\THis', strtotime("{$this->data['fecha']} {$this->data['hora']}"));
        $end = date('Ymd\THis', strtotime("{$this->data['fecha']} {$this->data['hora']} +30 minutes"));

        return <<<ICS
            BEGIN:VCALENDAR
            VERSION:2.0
            PRODID:-//Gente y Organización//FOCUSTalent//EN
            CALSCALE:GREGORIAN
            METHOD:REQUEST
            BEGIN:VEVENT
            DTSTART:{$start}
            DTEND:{$end}
            SUMMARY:Entrevista Funcional con {$this->data['nom_candidato']}
            LOCATION:{$this->data['lugar']}
            DESCRIPTION:{$this->data['comentarios']}
            END:VEVENT
            END:VCALENDAR
            ICS;
    }
}
