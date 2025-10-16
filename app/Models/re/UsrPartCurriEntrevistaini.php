<?php

namespace App\Models\re;

use Illuminate\Database\Eloquent\Model;
use App\Models\re\UsrPartCurriEntrevistaPreguntas;

class UsrPartCurriEntrevistaini extends Model
{
    protected $table = 'usr_part_curri_entrevistaini';

    protected $fillable = [
        'id_curri',
        'esta_laborando',
        'empresa_actual',
        'posicion_actual',
        'salario_actual',
        'beneficios_adicionales',
        'aspiracion_salarial',
        'comentarios_adicionales',
        'por',
    ];

    /**
     * Relación con las preguntas adicionales de la entrevista
     */
    public function preguntas()
    {
        return $this->hasMany(UsrPartCurriEntrevistaPreguntas::class, 'id_proceso', 'id');
    }
}
