<?php

namespace App\Models\re;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PruebasResultadosApl extends Model
{
    use HasFactory;

    protected $table = 'pruebas_resultados_apl';

    protected $fillable = [
        'prueba_id',
        'competencia_id',
        'puntaje',
    ];

    // Relaciones
    public function prueba()
    {
        return $this->belongsTo(\App\Models\re\PruebasPsicometrica::class, 'prueba_id');
    }

    public function competencia()
    {
        return $this->belongsTo(\App\Models\go\Competencias::class, 'competencia_id');
    }
}
