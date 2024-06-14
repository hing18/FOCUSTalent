<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class dir_provincias extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   DB::table('dir_provincias')->delete();
        DB::table('dir_provincias')->insert(array (
            0 => 
            array (
                'id' => 1,
                'provincia' => 'BOCAS DEL TORO',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            1 => 
            array (
                'id' => 2,
                'provincia' => 'CHIRIQUÍ',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            2 => 
            array (
                'id' => 3,
                'provincia' => 'COCLÉ',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            3 => 
            array (
                'id' => 4,
                'provincia' => 'COLÓN',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            4 => 
            array (
                'id' => 5,
                'provincia' => 'COMARCA EMBERÁ WOUNAAN',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            5 => 
            array (
                'id' => 6,
                'provincia' => 'COMARCA GUNA DE MADUGANDI',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            6 => 
            array (
                'id' => 7,
                'provincia' => 'COMARCA GUNA DE WARGANDI',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            7 => 
            array (
                'id' => 8,
                'provincia' => 'COMARCA GUNA YALA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            8 => 
            array (
                'id' => 9,
                'provincia' => 'COMARCA NGÄBE BUGLÉ',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            9 => 
            array (
                'id' => 10,
                'provincia' => 'DARIÉN',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            10 => 
            array (
                'id' => 11,
                'provincia' => 'HERRERA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            11 => 
            array (
                'id' => 12,
                'provincia' => 'LOS SANTOS',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            12 => 
            array (
                'id' => 13,
                'provincia' => 'PANAMÁ',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            13 => 
            array (
                'id' => 14,
                'provincia' => 'PANAMA OESTE',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            14 => 
            array (
                'id' => 15,
                'provincia' => 'VERAGUAS',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),

        ));
    }
}
