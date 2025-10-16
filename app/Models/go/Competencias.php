<?php

namespace App\Models\go;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competencias extends Model
{
    use HasFactory;

    protected $table = 'competencias'; // Nombre real de la tabla

    protected $fillable = [
        'nombre',
        'definicion',
        'definicion_resumen',
        'nivel_alto',
        'nivel_bajo',
        'status',
        'orden',
    ];

    protected $casts = [
        'orden' => 'integer',
    ];
}