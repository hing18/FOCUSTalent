<?php

namespace App\Models\Re;

use Illuminate\Database\Eloquent\Model;

class PruebaVeritas extends Model
{
    protected $table = 'pruebas_veritas';
    protected $fillable = [
        'curriculum_id',
        'fecha_realizada',
        'puntaje',
        'observaciones'
    ];
}
