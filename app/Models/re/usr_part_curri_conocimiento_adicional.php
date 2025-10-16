<?php

namespace App\Models\re;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usr_part_curri_conocimiento_adicional extends Model
{
    protected $table = 'usr_part_curri_conocimiento_adicional';
    public $timestamps = false;

    protected $fillable = [
        'id_curri',
        'espanol',
        'ingles',
        'computadora',
        'word',
        'excel',
        'powerpoint',
        'otros',
        'sedan',
        'camion',
        'trailer',
        'moto',
        'montacarga'
    ];
}
