<?php

namespace App\Models\re;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usr_nacionalidad extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla.
     */
    protected $table = 'usr_nacionalidad';

    /**
     * Campos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'pais',
        'nacionalidad',
    ];

    /**
     * Las columnas de timestamps ya existen en la tabla.
     */
    public $timestamps = true;

    /**
     * Relaciones
     */

    // Opcional: si quieres ver desde la nacionalidad todos los currículums asociados
    public function curriculums()
    {
        return $this->hasMany(Usr_part_curriculum::class, 'id_nacionalidad'); 
    }
}
