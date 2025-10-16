<?php

namespace App\Models\me;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_empleados extends Model
{
    // Definir el nombre de la tabla, porque el nombre no es plural ni estándar
    protected $table = 'm_empleados';

    // Definir la clave primaria
    protected $primaryKey = 'id';

    // Si la clave primaria es bigint y autoincrement, no hay que cambiar nada más.
    // Si no usas timestamps automáticos, puedes modificar $timestamps.

    // Indicar que sí usa timestamps, porque la tabla tiene created_at y updated_at
    public $timestamps = true;

    // Los campos asignables (por seguridad para asignación masiva)
    protected $fillable = [
        'id',
        'prinombre',
        'segnombre',
        'priapellido',
        'segapellido',
        'foto',
        'color_text',
        'color_bg',
        'genero',
        'nacio_extran',
        'f_nacimiento',
        'id_nacionalidad',
        'id_tipo_doc_letra',
        'num_doc',
        'num_ss',
        'estadocivil',
        'f_vencimiento',
        'tel',
        'email',
        'id_provincia',
        'id_distrito',
        'id_corregimiento',
        'direccion',
        'discapacidad',
        'detalle_descapacidad',
        'cv_doc',
        'permiso_trab',
        'f_vence_permiso_trab',
        'permiso_doc',
        'id_posicion',
        'id_cia',
        'id_ceco',
        'id_estatus',
        'salario',
        'finicio',
        'fterminacion',
        'tipo_contrato',
        'tipo_salario',
        'coef_intelectual',
        'niv_academico'
    ];

    // Si quieres que Laravel trate los campos date o datetime como Carbon, puedes usar $dates:
    protected $dates = [
        'f_nacimiento',
        'f_vencimiento',
        'f_vence_permiso_trab',
        'finicio',
        'fterminacion',
        'created_at',
        'updated_at',
    ];

    // Si quieres puedes agregar casts para campos específicos
    protected $casts = [
        'salario' => 'decimal:2',
        'coef_intelectual' => 'decimal:7',
        'niv_academico' => 'decimal:7',
    ];
}
