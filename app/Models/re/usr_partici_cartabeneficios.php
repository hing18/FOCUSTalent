<?php

namespace App\Models\re;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usr_partici_cartabeneficios extends Model
{
    use HasFactory;

    protected $table = 'usr_partici_cartabeneficios';

    protected $fillable = [
        'id_beneficio',
        'id_carta_ofl',
        'beneficio',
        'monto',
        'tipo'
    ];

    public $timestamps = true;

    /**
     * Relación con la carta de oferta.
     */
    public function cartaOferta()
    {
        return $this->belongsTo(Usr_partici_cartaofl::class, 'id_carta_ofl');
    }
}