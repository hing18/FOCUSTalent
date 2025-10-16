<?php

namespace App\Models\re;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usr_part_experiencia_laboral extends Model
{
    protected $table = 'usr_part_experiencia_laboral';
    public $timestamps = false;

    protected $fillable = [
        'id_curri',
        'empresa',
        'puesto',
        'id_subarea',
        'subarea',
        'desde',
        'hasta',
        'motivo_salida',
        'telefono',
        'direccion',
        'salario',
        'jefe'
    ];
}
