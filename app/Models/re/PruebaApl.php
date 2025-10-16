<?php

namespace App\Models\Re;

use Illuminate\Database\Eloquent\Model;

class PruebaApl extends Model
{
    protected $table = 'pruebas_apl';
    protected $fillable = [
        'curriculum_id',
        'fecha_realizada',
        'informe',
        'observaciones'
    ];

    public function resultados()
    {
        return $this->hasMany(PruebaResultadoApl::class, 'prueba_id');
    }
}
