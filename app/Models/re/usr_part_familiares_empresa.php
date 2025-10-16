<?php

namespace App\Models\re;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usr_part_familiares_empresa extends Model
{
    protected $table = 'usr_part_familiares_empresa';
    public $timestamps = false;

    protected $fillable = [
        'id_curri',
        'nombre',
        'parentesco',
        'unidad'
    ];
}
