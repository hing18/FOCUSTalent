<?php

namespace App\Models\re;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usr_part_curri_docattach extends Model
{
    use HasFactory;
    protected $table = 'usr_part_curri_docattach';
    protected $fillable = [
        'id_curri',
        'iddoc',
        'informe',
        'nomdoc',
        'downdoc'
    ];
}
