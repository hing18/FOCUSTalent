<?php

namespace App\Models\Re;

use Illuminate\Database\Eloquent\Model;

class PruebaRazi extends Model
{
    protected $table = 'pruebas_razi';
    protected $fillable = [
        'curriculum_id',
        'fecha_realizada',
        'informe',
        'observaciones',
        'puntaje_v',
        'puntaje_n',
        'puntaje_a',
        'general',
        'preg_acertadas'
    ];
}
