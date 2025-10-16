<?php

namespace App\Models\Re;

use Illuminate\Database\Eloquent\Model;

class PruebaDisc extends Model
{
    protected $table = 'pruebas_disc';
    protected $fillable = [
        'curriculum_id',
        'fecha_realizada',
        'informe',
        'observaciones',
        'puntaje_d',
        'puntaje_i',
        'puntaje_s',
        'puntaje_c'
    ];
}
