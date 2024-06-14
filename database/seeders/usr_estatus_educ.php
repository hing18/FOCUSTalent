<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class usr_estatus_educ extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('usr_estatus_educ')->delete();
        DB::table('usr_estatus_educ')->insert(array (
            0 => 
            array (
                'id' => 1,
                'estatuseduc' => 'EGRESADO',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            1 => 
            array (
                'id' => 2,
                'estatuseduc' => 'RETIRADO',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            2 => 
            array (
                'id' => 3,
                'estatuseduc' => 'INCOMPLETO',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            3 => 
            array (
                'id' => 4,
                'estatuseduc' => 'ACTUALMENTE',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            
        ));
    }
}
