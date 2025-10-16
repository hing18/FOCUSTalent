<?php

namespace App\Models\re;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class entrevistas_fun_preguntas extends Model
{
     use HasFactory;

    // Nombre de la tabla
    protected $table = 'entrevistas_fun_preguntas';

    // Clave primaria
    protected $primaryKey = 'id';

    // Laravel ya maneja automáticamente created_at y updated_at
    public $timestamps = true;

    // Campos asignables en masa
    protected $fillable = [
        'id_df',
        'pregunta',
    ];

    // Si pregunta debería ser texto, aquí lo casteamos
    protected $casts = [
        'pregunta' => 'string',
    ];
}
