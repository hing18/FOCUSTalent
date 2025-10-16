<?php

namespace App\Models\re;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usr_parti_dependientes extends Model
{
    protected $table='usr_part_dependientes';
    public $timestamps = false;
    protected $fillable = [
        'id_curri',
        'nombre',
        'parentesco',
        'f_nacimiento'
    ];
}
    