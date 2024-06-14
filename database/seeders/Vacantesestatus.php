<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Vacantesestatus extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vacantes_estatus')->delete();
        DB::table('vacantes_estatus')->insert(array (
            0 => 
            array (
                'id' => 1,
                'estatus' => 'Validación',
                'icono' => '<i class="fas fa-exclamation-triangle text-warning fa-lg activar" title="Validar"></i>',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            1 => 
            array (
                'id' => 2,
                'estatus' => 'Búsqueda',
                'icono' => '<i class="fab fa-searchengin text-primary fa-lg activar" title="En Búsqueda"></i>',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            2 => 
            array (
                'id' => 3,
                'estatus' => 'Suspendida',
                'icono' => '<i class="far fa-hand-paper text-secondary fa-lg activar" title="Suspendida"></i>',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            3 => 
            array (
                'id' => 4,
                'estatus' => 'Rechazada',
                'icono' => '<i class="fas fa-ban text-danger fa-lg activar" title="Rechazada"></i>',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            4 => 
            array (
                'id' => 5,
                'estatus' => 'Finalizada',
                'icono' => '<i class="fas fa-check-circle text-success fa-lg activar" title="Finalizada"></i>',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
        ));
    }
}
