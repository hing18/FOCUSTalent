<?php

namespace App\Models\re;

use Illuminate\Database\Eloquent\Model;

class TernaCandidatos extends Model
{
    protected $table = 'terna_candidatos';

    protected $fillable = [
        'id_ofl',
        'id_curri',
        'email_entrevistador'
    ];

}
