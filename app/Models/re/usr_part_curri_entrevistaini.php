<?php

namespace App\Models\re;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usr_part_curri_entrevistaini extends Model
{
    use HasFactory;

    protected $table = 'usr_part_curri_entrevistaini';

    protected $fillable = [
        'id_curri',
        'id_ofl',
        'esta_laborando',
        'empresa_actual',
        'posicion_actual',
        'salario_actual',
        'beneficios_adicionales',
        'aspiracion_salarial',
        'comentarios_adicionales',
        'por',
    ];

    protected $casts = [
        'salario_actual' => 'float',
        'aspiracion_salarial' => 'float',
        'esta_laborando' => 'string', // enum: 's', 'n'
    ];
}
