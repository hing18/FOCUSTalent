<?php

namespace App\Models\re;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usr_part_contactos extends Model
{
    use HasFactory;
    protected $table='usr_part_contactos';

    protected $fillable = [
        'id_part_curriculum',
        'nombre',
        'tipo_contacto',
        'contacto'
    ];
    /*** Las columnas de timestamps ya existen en la tabla.*/
    public $timestamps = true;
    /*** Relación con el modelo Curriculum.*/
    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class, 'id_part_curriculum');   
    }
}