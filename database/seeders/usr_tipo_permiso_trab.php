<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class usr_tipo_permiso_trab extends Seeder
{
    /**
     * Run the database seeds.
     */    
    public function run(): void
    {
        DB::table('usr_tipo_permiso_trab')->delete();
        DB::table('usr_tipo_permiso_trab')->insert(array (
            0 => 
            array (
                'id' => 1,
                'tipopermiso' => 'PERMISO 1A',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            1 => 
            array (
                'id' => 2,
                'tipopermiso' => 'PERMISO 1B',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            2 => 
            array (
                'id' => 3,
                'tipopermiso' => 'PERMISO 1B-1',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            3 => 
            array (
                'id' => 4,
                'tipopermiso' => 'PERMISO 1B-2',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            4 => 
            array (
                'id' => 5,
                'tipopermiso' => 'PERMISO 1B-3',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            5 => 
            array (
                'id' => 6,
                'tipopermiso' => 'PERMISO 1C',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            6 => 
            array (
                'id' => 7,
                'tipopermiso' => 'PERMISO 1D',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            7 => 
            array (
                'id' => 8,
                'tipopermiso' => 'PERMISO 1E',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            8 => 
            array (
                'id' => 9,
                'tipopermiso' => 'PERMISO 1F',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            9 => 
            array (
                'id' => 10,
                'tipopermiso' => 'PERMISO 2A',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            10 => 
            array (
                'id' => 11,
                'tipopermiso' => 'PERMISO 2B',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            11 => 
            array (
                'id' => 12,
                'tipopermiso' => 'PERMISO 2C',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            12 => 
            array (
                'id' => 13,
                'tipopermiso' => 'PERMISO 2D',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            13 => 
            array (
                'id' => 14,
                'tipopermiso' => 'PERMISO 2E',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            14 => 
            array (
                'id' => 15,
                'tipopermiso' => 'PERMISO 3A',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            15 => 
            array (
                'id' => 16,
                'tipopermiso' => 'PERMISO 3B',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            16 => 
            array (
                'id' => 17,
                'tipopermiso' => 'PERMISO 3C',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            17 => 
            array (
                'id' => 18,
                'tipopermiso' => 'PERMISO 3C-1',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            18 => 
            array (
                'id' => 19,
                'tipopermiso' => 'PERMISO 3C-2',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            19 => 
            array (
                'id' => 20,
                'tipopermiso' => 'PERMISO 3C-3',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            20 => 
            array (
                'id' => 21,
                'tipopermiso' => 'PERMISO 3C-4',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            21 => 
            array (
                'id' => 22,
                'tipopermiso' => 'PERMISO 3C-5',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            22 => 
            array (
                'id' => 23,
                'tipopermiso' => 'PERMISO 3D',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            23 => 
            array (
                'id' => 24,
                'tipopermiso' => 'PERMISO 3D-1',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            24 => 
            array (
                'id' => 25,
                'tipopermiso' => 'PERMISO 3D-2',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            25 => 
            array (
                'id' => 26,
                'tipopermiso' => 'PERMISO 3D-3',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            26 => 
            array (
                'id' => 27,
                'tipopermiso' => 'PERMISO 3E',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            27 => 
            array (
                'id' => 28,
                'tipopermiso' => 'PERMISO 3F',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            28 => 
            array (
                'id' => 29,
                'tipopermiso' => 'PERMISO 4A',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            29 => 
            array (
                'id' => 30,
                'tipopermiso' => 'PERMISO 4B',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            30 => 
            array (
                'id' => 31,
                'tipopermiso' => 'PERMISO 4C',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            31 => 
            array (
                'id' => 32,
                'tipopermiso' => 'PERMISO 4D',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            32 => 
            array (
                'id' => 33,
                'tipopermiso' => 'PERMISO 5A-1',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            33 => 
            array (
                'id' => 34,
                'tipopermiso' => 'PERMISO 5A-2',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            34 => 
            array (
                'id' => 35,
                'tipopermiso' => 'PERMISO 5A-3',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            35 => 
            array (
                'id' => 36,
                'tipopermiso' => 'PERMISO 5B',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            36 => 
            array (
                'id' => 37,
                'tipopermiso' => 'PERMISO 5C',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            37 => 
            array (
                'id' => 38,
                'tipopermiso' => 'PERMISO 5D',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            38 => 
            array (
                'id' => 39,
                'tipopermiso' => 'PERMISO 5E',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            39 => 
            array (
                'id' => 40,
                'tipopermiso' => 'PERMISO 6A',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            40 => 
            array (
                'id' => 41,
                'tipopermiso' => 'PERMISO 6A-1',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            41 => 
            array (
                'id' => 42,
                'tipopermiso' => 'PERMISO 6A-2',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            42 => 
            array (
                'id' => 43,
                'tipopermiso' => 'PERMISO 6B',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            43 => 
            array (
                'id' => 44,
                'tipopermiso' => 'PERMISO 6B-1',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            44 => 
            array (
                'id' => 45,
                'tipopermiso' => 'PERMISO 6B-2',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            45 => 
            array (
                'id' => 46,
                'tipopermiso' => 'PERMISO 7A',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            46 => 
            array (
                'id' => 47,
                'tipopermiso' => 'PERMISO 7B',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            47 => 
            array (
                'id' => 48,
                'tipopermiso' => 'PERMISO 7C',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            48 => 
            array (
                'id' => 49,
                'tipopermiso' => 'PERMISO 7D',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
        ));
    }
}