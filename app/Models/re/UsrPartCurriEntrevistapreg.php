<?php

namespace App\Models\re;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsrPartCurriEntrevistapreg extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'usr_part_curri_entrevistapreg';

    // Clave primaria
    protected $primaryKey = 'id';

    public $timestamps = true;

    
    protected $fillable = [
        'id_entrevistafun',
        'id_pregunta',
        'pregunta',
        'respuesta',
    ];
}
