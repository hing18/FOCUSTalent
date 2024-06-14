<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class pruebaspsicoresp extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pruebaspsicoresp')->delete();
        DB::table('pruebaspsicoresp')->insert(array (
            0 => 
            array (
                'id' => 1,
                'respuesta' => 'Elegible',
                'id_prueba' => 1,
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            1 => 
            array (
                'id' => 2,
                'respuesta' => 'Elegible / Revisar',
                'id_prueba' => 1,
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            2 => 
            array (
                'id' => 3,
                'respuesta' => 'Desartado',
                'id_prueba' => 1,
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            3 => 
            array (
                'id' => 4,
                'respuesta' => 'Deficiente',
                'id_prueba' => 2,
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            4 => 
            array (
                'id' => 5,
                'respuesta' => 'Inferior al Término',
                'id_prueba' => 2,
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            5 => 
            array (
                'id' => 6,
                'respuesta' => 'Término Medio',
                'id_prueba' => 2,
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            6 => 
            array (
                'id' => 7,
                'respuesta' => 'Superior al Término Medio',
                'id_prueba' => 2,
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            7 => 
            array (
                'id' => 8,
                'respuesta' => 'Superior',
                'id_prueba' => 2,
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            8 => 
            array (
                'id' => 9,
                'respuesta' => 'Muy Superior',
                'id_prueba' => 2,
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
        ));
    }
}
