<?php

namespace App\Models\re;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usr_part_curri_validacionref extends Model
{
    use HasFactory;

    protected $table = 'usr_part_curri_validacionref';

    protected $fillable = [
        'id_curri',
        'entidad',
        'nombre',
        'puesto',
        'contacto',
        'comentarios',
        'id_participante',
    ];

    public $timestamps = true;
}
