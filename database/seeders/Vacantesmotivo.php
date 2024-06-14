<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Vacantesmotivo extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vacantes_motivo')->delete();
        DB::table('vacantes_motivo')->insert(array (
            0 => 
            array (
                'id' => 1,
                'motivo' => 'Por reemplazo de un colaborador existente',
                'necesita_autorizacion' => 'false',
                'status' => 'true',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            1 => 
            array (
                'id' => 2,
                'motivo' => 'Por vencimiento de contrato de otro colaborador',
                'necesita_autorizacion' => 'false',
                'status' => 'true',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            2 => 
            array (
                'id' => 3,
                'motivo' => 'Por aumento del Head Count aprobado',
                'necesita_autorizacion' => 'true',
                'status' => 'true',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            3 => 
            array (
                'id' => 4,
                'motivo' => 'Por temporada alta',
                'necesita_autorizacion' => 'true',
                'status' => 'true',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            4 => 
            array (
                'id' => 5,
                'motivo' => 'Por otra causa (Explique en los comentarios)',
                'necesita_autorizacion' => 'false',
                'status' => 'true',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
        ));
    }
}
