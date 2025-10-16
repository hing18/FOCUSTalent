<?php

namespace App\Models\re;

use App\Models\go\Posicion;
use Illuminate\Database\Eloquent\Model;

class VacanteSolicitud extends Model
{
    protected $table = 'vacantes_solicitudes';
    protected $primaryKey = 'id'; 
    public $timestamps = true; 
   

    public function ternasEnviadas()
    {
        return $this->hasMany(TernaEnviada::class, 'oferta_id');
    }
        public function puesto()
    {
        return $this->belongsTo(Posicion::class, 'id_puesto');
    }
}
