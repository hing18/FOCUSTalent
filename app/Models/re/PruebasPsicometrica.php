<?php

namespace App\Models\re;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PruebasPsicometrica extends Model
{
    use HasFactory;

    protected $table = 'pruebas_psicometrica'; // Nombre real de la tabla

    protected $fillable = [
        'curriculum_id',
        'fecha_realizada',
        'observaciones',
    ];

    protected $casts = [
        'fecha_realizada' => 'date',
    ];

    // Relaciones
    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }

    public function resultados()
    {
        return $this->hasMany(PruebasResultadosApl::class, 'prueba_id');
    }
}