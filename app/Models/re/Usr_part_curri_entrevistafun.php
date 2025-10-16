<?php

namespace App\Models\re;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usr_part_curri_entrevistafun extends Model
{
    use HasFactory;

    protected $table = 'usr_part_curri_entrevistafun';

    protected $fillable = [
        'id_curri',
        'id_part',
        'id_ofl',
        'id_terna',
        'email_entrevistador',
        'fecha',
        'hora',
        'lugar_entrevista',
        'observaciones',
        'notificado',
        'entrevista_realizada',
        'comentarios_entrevistador', // --- comentarios
        'valoracion', // --- valoracion  1-en espera 2-declinado 3-contratar
        'notifica_contratar', // --- opt_candidato
        'f_realEntrevista',
        'preguntas_entrevistas'
    ];

    public $timestamps = true;

    protected $casts = [
        'fecha' => 'date',
    ];

    /**
     * Relación con curriculum
     */
    public function curri()
    {
        return $this->belongsTo(Curriculum::class, 'id_curri');
    }

    public function participante()
    {
        return $this->belongsTo(Usr_participantes::class, 'id_part');
    }

    // Relación a solicitud/oferta de vacante
    public function ofl()
    {
        return $this->belongsTo(VacanteSolicitud::class, 'id_ofl');
    }

    
}

