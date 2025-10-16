<?php

namespace App\Models\re;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usr_part_educacion extends Model
{
    protected $table = 'usr_part_educacion';
    public $timestamps = false;

    protected $fillable = [
        'id_curri',
        'nivel_educ',
        'entidad',
        'titulo',
        'ano',
        'estatuseduc',
        'docum'
    ];
}