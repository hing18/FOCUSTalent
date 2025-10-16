<?php

namespace App\Models\re;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usr_part_curriculum extends Model
{
    use HasFactory;
    protected $table = 'usr_part_curriculum';
    protected $primaryKey = 'id'; //
    public $timestamps = true; // asegura que created_at y updated_at se manejen automáticamente
    protected $fillable = [
        'id_part_curriculum_alt',
        'prinombre',
        'segnombre',
        'priapellido',
        'segapellido',
        'genero',
        'f_nacimiento',
        'estadocivil',
        'id_tipo_doc_letra',
        'nacio_extran',
        'num_doc',
        'f_vencimiento',
        'num_ss',
        'tel',
        'email',
        'id_provincia',
        'id_distrito',
        'id_corregimiento',
        'direccion',
        'id_nacionalidad',
        'permiso_trab',
        'f_vence_permiso_trab',
        'permiso_doc',
        'tipo_sangre',
        'medico',
        'hospital',
        'tel_medico',
        'sufre_alergia_medicamento',
        'medicamento',
        'sufre_lesion_laboral',
        'lesion_laboral',
        'contacto_urgencia',
        'parentesco_urgencia',
        'tel_urgencia',
        'discapacidad',
        'detalle_descapacidad',
        'cv_doc',
        'examen_psicometrico',
        'disponibilidad_viajar',
        'verificar_informacion',
        'informacion_verdadera',
        'estado_registro',
        'motivo_descarte',
        'detalle_descarte',
        'descartado_por',
        'photo',
        'foto'
    ];


}
