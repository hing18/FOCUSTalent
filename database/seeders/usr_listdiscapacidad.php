<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class usr_listdiscapacidad extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('usr_listdiscapacidad')->delete();
        DB::table('usr_listdiscapacidad')->insert(array (
            0 => 
            array (
                'id' => 1,
                'discapacidad' => 'FÍSICA O MOVILIDAD REDUCIDA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            1 => 
            array (
                'id' => 2,
                'discapacidad' => 'INTELECTUAL',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            2 => 
            array (
                'id' => 3,
                'discapacidad' => 'SENSORIAL - AUDITIVA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            3 => 
            array (
                'id' => 4,
                'discapacidad' => 'SENSORIAL - VISUAL',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            4 => 
            array (
                'id' => 5,
                'discapacidad' => 'VISCERAL',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            5 => 
            array (
                'id' => 6,
                'discapacidad' => 'OTRA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
        ));
    }
}
