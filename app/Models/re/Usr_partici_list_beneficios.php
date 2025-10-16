<?php

namespace App\Models\re;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usr_partici_list_beneficios extends Model
{
    protected $table = 'usr_partici_list_beneficios';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'beneficio',
        'tipo_dato',
        'tipo',
        'orden',
        'estatus',
    ];
}