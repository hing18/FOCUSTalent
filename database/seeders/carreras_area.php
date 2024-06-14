<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class carreras_area extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   DB::table('carreras_area')->delete();
        DB::table('carreras_area')->insert(array (
        0 => 
        array (
            'id' => 1,
            'area' => 'Administración',                
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        1 => 
        array (
            'id' => 2,
            'area' => 'Finanzas',                
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        2 => 
        array (
            'id' => 3,
            'area' => 'Legal y Cumplimiento',                
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        3 => 
        array (
            'id' => 4,
            'area' => 'Limpieza y Mantenimiento',                
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        4 => 
        array (
            'id' => 5,
            'area' => 'Operaciones y Logística',                
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        5 => 
        array (
            'id' => 6,
            'area' => 'Recursos Humanos',                
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        6 => 
        array (
            'id' => 7,
            'area' => 'Servicio al Cliente',                
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        7 => 
        array (
            'id' => 8,
            'area' => 'Suministros y Almacén',                
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        8 => 
        array (
            'id' => 9,
            'area' => 'Tecnología de la Información',                
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        9 => 
        array (
            'id' => 10,
            'area' => 'Ventas y Marketing',                
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
    ));
    }
}
