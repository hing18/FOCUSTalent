<?php



namespace App\Models\go;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posicion extends Model
{
    use HasFactory;

    protected $table = 'posiciones';

    protected $fillable = [
        'codigo',
        'descpue',
        'aprobado',
        'idue',
        'iduni',
        'iddf',
        'idpuejefe',
        'status',
    ];

    public $timestamps = true;

}
