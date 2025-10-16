<?php

namespace App\Models\re;

use Illuminate\Database\Eloquent\Model;
use App\Models\re\UsrPartCurriEntrevistaini;

class UsrPartCurriEntrevistaPreguntas extends Model
{
    protected $table = 'usr_part_curri_entrevista_preguntas';

    protected $fillable = [
        'id_proceso',
        'pregunta',
        'respuesta',
    ];

    public function entrevista()
    {
        return $this->belongsTo(UsrPartCurriEntrevistaini::class, 'id_proceso', 'id');
    }
}
