<?php

namespace App\Models\re;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usr_part_obs_terna extends Model
{
    use HasFactory;

    protected $table = 'usr_part_obs_terna';

    protected $primaryKey = 'id'; // explícito aunque es por defecto

    public $timestamps = true; // asegura que created_at y updated_at se manejen automáticamente

    protected $fillable = [
        'id_part',
        'id_curri',
        'id_ofl',
        'obs'
    ];
}
