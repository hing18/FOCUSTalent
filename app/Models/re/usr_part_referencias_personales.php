<?php

namespace App\Models\re;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class usr_part_referencias_personales extends Model
{
    protected $table = 'usr_part_referencias_personales';
    public $timestamps = false;

    protected $fillable = [
        'id_curri',
        'nombre',
        'direccion',
        'telefono',
        'vinculo',
        'forma_de_ser',
        'rel_sociales_sanas',
        'responsable',
        'cortes',
        'cooperador',
        'probl_honestidad',
        'lo_contrataria',
        'porq',
        'validado_por',
        'f_validacion'
    ];
}
