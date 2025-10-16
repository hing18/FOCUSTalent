<?php

namespace App\Models\Re;

use Illuminate\Database\Eloquent\Model; 


class PruebaResultadoApl extends Model 
{
    protected $table = 'pruebas_resultados_apl';
    protected $fillable = [
        'prueba_id',
        'competencia_id',
        'puntaje'
    ];

    public function apl()
    {
        return $this->belongsTo(PruebaApl::class, 'prueba_id');
    }
}