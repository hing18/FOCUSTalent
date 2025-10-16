<?php

namespace App\Models\re;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usr_participantes extends Model
{
    use HasFactory;

    protected $table = 'usr_participantes';

    protected $primaryKey = 'id'; // explícito aunque es por defecto

    public $timestamps = true; // asegura que created_at y updated_at se manejen automáticamente

    protected $fillable = [
        'id_part_curriculum',
        'id_part_curriculum_alt',
        'id_ofl',
        'id_jer',
        'id_puesto',
        'id_etapa',
        'valida_sipe',
        'marcacion',
        'aspiracion_sal',
        'motivo_descarte',
        'detalle_descarte'
    ];
}
