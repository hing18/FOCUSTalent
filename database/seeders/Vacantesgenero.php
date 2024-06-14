<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Vacantesgenero extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vacantes_genero')->delete();
        DB::table('vacantes_genero')->insert(array (
            0 => 
            array (
                'id' => 1,
                'letra' => 'N',
                'genero' => 'No importa género',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            1 => 
            array (
                'id' => 2,
                'letra' => 'M',
                'genero' => 'Masculino',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            2 => 
            array (
                'id' => 3,
                'letra' => 'F',
                'genero' => 'Femenino',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
        ));
    }
}
