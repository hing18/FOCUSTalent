<?php

namespace App\Models\re;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usr_part_cursos_seminarios extends Model
{
    protected $table = 'usr_part_cursos_seminarios';
    public $timestamps = false;

    protected $fillable = [
        'id_curri',
        'entidad',
        'nombre',
        'ano',
        'docum'
    ];
}
