<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class pruebaspsicometricas extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pruebaspsicometricas')->delete();
        DB::table('pruebaspsicometricas')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nom_prueba' => 'Veritas - Integridad',
                'resp_pruebas' => 's',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            1 => 
            array (
                'id' => 2,
                'nom_prueba' => 'Raven - Inteligencia',
                'resp_pruebas' => 's',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            2 => 
            array (
                'id' => 3,
                'nom_prueba' => '16pf - Personalidad',
                'resp_pruebas' => 'n',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            3 => 
            array (
                'id' => 4,
                'nom_prueba' => 'RAZI',
                'resp_pruebas' => 'n',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            4 => 
            array (
                'id' => 5,
                'nom_prueba' => 'APL - Competencias',
                'resp_pruebas' => 'n',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            5 => 
            array (
                'id' => 10,
                'nom_prueba' => 'N/A',
                'resp_pruebas' => 'n',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
        ));
    }
}
