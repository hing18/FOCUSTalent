<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Vacantesetapas extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vacantes_etapas')->delete();
        DB::table('vacantes_etapas')->insert(array (
            0 => 
            array (
                'id' => 1,
                'etapa' => 'Validación de solicitud',
                'res_etapa' => 'Validación',
                'avance' => '0',
                'status' => 'true',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            1 => 
            array (
                'id' => 2,
                'etapa' => 'Búsqueda / Entrevista inicial (telefónica o virtual)',
                'res_etapa' => 'Búsqueda',
                'avance' => '15',
                'status' => 'true',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            2 => 
            array (
                'id' => 3,
                'etapa' => 'Entrevista presencial',
                'res_etapa' => 'Entrevista',
                'avance' => '60',
                'status' => 'true',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            3 => 
            array (
                'id' => 4,
                'etapa' => 'Presentación de oferta laboral (negociación)',
                'res_etapa' => 'Negociación',
                'avance' => '85',
                'status' => 'true',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            4 => 
            array (
                'id' => 5,
                'etapa' => 'Firma de contrato',
                'res_etapa' => 'Firma de contrato',
                'avance' => '100',
                'status' => 'true',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            5 => 
            array (
                'id' => 6,
                'etapa' => 'Contratado',
                'res_etapa' => 'Contratado',
                'avance' => '100',
                'status' => 'true',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
        ));
    }
}
