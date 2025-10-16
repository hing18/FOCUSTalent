<?php

namespace App\Models\re;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usr_part_curri_pru_psico extends Model
{
    use HasFactory;

    protected $table = 'usr_part_curri_pru_psico';

    protected $fillable = [
        'id_curri',
        'prueba',
        'f_prueba',
        'resultado',
        'id_participante',
    ];

    protected $casts = [
        'f_prueba' => 'date',
    ];

    public $timestamps = true;
}
