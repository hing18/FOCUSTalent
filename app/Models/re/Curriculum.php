<?php

namespace App\Models\re;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;

    protected $table = 'usr_part_curriculum';

    protected $fillable = [
        'prinombre',
        'priapellido',
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
        'foto',
        'color_text',
        'color_bg'
    ];

    protected $casts = [
        'f_vence_permiso_trab' => 'date',
        'photo' => 'binary',
    ];

    public $timestamps = true;

    /**
     * Relación con nacionalidad
     */
    public function nacionalidad()
    {
        return $this->belongsTo(Usr_nacionalidad::class, 'id_nacionalidad');
    }

    /**
     * Nombre completo formateado
     */
    public function getNombreCompletoAttribute()
    {
        return ucfirst(strtolower($this->prinombre)) . ' ' . ucfirst(strtolower($this->priapellido));
    }
    public function usrpartbitacora()
    {
        return $this->hasMany(usr_part_bitacora::class, 'id_curri');
    }
    public function conocimientosAdicionales()
    {
        return $this->hasMany(usr_part_curri_conocimiento_adicional::class, 'id_curri');
    }
    public function usrpartcurridocattach()
    {
        return $this->hasMany(usr_part_curri_docattach::class, 'id_curri');
    }
    public function usrpartcurrientrevistafun()
    {
        return $this->hasMany(usr_part_curri_entrevistafun::class, 'id_curri');
    }
    public function usrpartcurrientrevistaini()
    {
        return $this->hasMany(usr_part_curri_entrevistaini::class, 'id_curri');
    }
    public function usrpartcurriprupsico()
    {
        return $this->hasMany(usr_part_curri_pru_psico::class, 'id_curri');
    } 
    public function usrpartcurrivalidacionref()
    {
        return $this->hasMany(usr_part_curri_validacionref::class, 'id_curri');
    }
    public function usrpartcursosseminarios()
    {
        return $this->hasMany(usr_part_cursos_seminarios::class, 'id_curri');
    }
    public function usrpartdependientes()
    {
        return $this->hasMany(Usr_parti_dependientes::class, 'id_curri');
    }
    public function usrparteducacion()
    {
        return $this->hasMany(Usr_part_educacion::class, 'id_curri');
    }
    public function usrpartexperiencialaboral()
    {
        return $this->hasMany(Usr_part_experiencia_laboral::class, 'id_curri');
    }
    public function usrpartfamiliaresempresa()
    {
        return $this->hasMany(Usr_part_familiares_empresa::class, 'id_curri');
    }
    public function usrparticipantes()
    {
        return $this->hasMany(Usr_participantes::class, 'id_part_curriculum');
    }
    public function usrpartreferenciaspersonales()
    {
        return $this->hasMany(Usr_part_referencias_personales::class, 'id_curri');
    }
    public function usrpartobsterna()
    {
        return $this->hasMany(Usr_part_obs_terna::class, 'id_curri');
    }
    public function pruebasapl()
    {
        return $this->hasMany(PruebaApl::class, 'id_curri');
    }
    public function pruebadisc()
    {
        return $this->hasMany(PruebaDisc::class, 'id_curri');
    }
    public function pruebasrazi()
    {
        return $this->hasMany(PruebaRazi::class, 'id_curri');
    }
    public function pruebasveritas()
    {
        return $this->hasMany(PruebaVeritas::class, 'id_curri');
    }

    public function usrpartcontactos()
    {
        return $this->hasMany(Usr_part_contactos::class, 'id_part_curriculum');
    }  
}