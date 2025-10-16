<?php

namespace App\Models\re;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntrevistaFunPregunta extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'entrevistas_fun_preguntas';

    // Clave primaria
    protected $primaryKey = 'id';

    // Campos asignables
    protected $fillable = [
        'id_df',
        'pregunta',
    ];

    // Timestamps automáticos
    public $timestamps = true;
}