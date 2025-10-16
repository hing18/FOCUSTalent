<?php

namespace App\Models\re;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usr_partici_cartaofl extends Model
{
    use HasFactory;

    protected $table = 'usr_partici_cartaofl';

    protected $fillable = [
        'id_ofl',
        'id_participante',
        'salario',
        'finicio',
        'fterminacion',
        'url_carta_oferta',
        'sel_tipo_contrato',
        'sel_tipo_salario',
        'descargada_por',
        'estado',
        'aprobacion_ofl',
        'aceptacion_ofl',
        'faceptacion',
        'contworkfirmado',
        'f_contworkfirmado',
        'generada_por',
        'cod_cia',
        'cod_ceco',
        'id_user_firmante',
        'plazo_nombramiento',
    ];

    public $timestamps = true;

    /**
     * Relación con beneficios adicionales
     */
    public function beneficios()
    {
        return $this->hasMany(usr_partici_cartabeneficios::class, 'id_carta_ofl');
    }

    /**
     * Opcional: Relación con participante
     */
    public function participante()
    {
        return $this->belongsTo(Usr_participantes::class, 'id_participante');
    }
}