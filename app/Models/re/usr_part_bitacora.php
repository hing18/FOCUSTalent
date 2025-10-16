<?php

namespace App\Models\re;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usr_part_bitacora extends Model
{
    use HasFactory;

    protected $table = 'usr_part_bitacora';

    protected $fillable = [
        'id_part',
        'id_curri',
        'id_ofl',
        'id_etapa',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

}

