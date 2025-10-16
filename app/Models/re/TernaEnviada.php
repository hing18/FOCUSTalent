<?php

namespace App\Models\re;

use App\Models\re\VacanteSolicitud;
use Illuminate\Database\Eloquent\Model;

class TernaEnviada extends Model
{
    protected $table = 'ternas_enviadas';

    protected $fillable = [
        'oferta_id',
        'candidatos',
        'email_destino',
        'asunto',
        'mensaje',
        'email_reclutador'
    ];

    protected $casts = [
        'candidatos' => 'array',
    ];

    public $timestamps = true;

    public function oferta()
    {
        return $this->belongsTo(VacanteSolicitud::class, 'oferta_id');
    }
}
