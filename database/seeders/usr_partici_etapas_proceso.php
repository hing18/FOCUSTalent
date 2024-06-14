<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class usr_partici_etapas_proceso extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('usr_partici_etapas_proceso')->delete();
        DB::table('usr_partici_etapas_proceso')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nometapa' => 'Nuevo',
                'orden' => 1,
                'banges' => '<span class="badge bg-warning text-dark"><i class="fas fa-exclamation-triangle"></i> Nuevo</span>',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            1 => 
            array (
                'id' => 2,
                'nometapa' => 'Entrevista inicial',
                'orden' => 2,
                'banges' => '<span class="badge bg-secondary"><i class="fas fa-street-view"></i> Entrevista inicial</span>',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            2 => 
            array (
                'id' => 3,
                'nometapa' => 'Entrevista funcional',
                'orden' => 3,
                'banges' => '<span class="badge bg-info"><i class="fas fa-user-tie"></i> Entrevista funcional</span>',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            3 => 
            array (
                'id' => 4,
                'nometapa' => 'Presentación de oferta',
                'orden' => 4,
                'banges' => '<span class="badge bg-primary"><i class="fas fa-user-clock"></i> Presentación de oferta</span>',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            4 => 
            array (
                'id' => 5,
                'nometapa' => 'Documentación',
                'orden' => 5,
                'banges' => '<span class="badge bg-light text-dark"><i class="far fa-address-book"></i> Documentación</span>',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            5 => 
            array (
                'id' => 6,
                'nometapa' => 'Contratar',
                'orden' => 6,
                'banges' => '<span class="badge bg-success"><i class="fas fa-user-check"></i> Contratar</span>',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            6 => 
            array (
                'id' => 7,
                'nometapa' => 'No procede',
                'orden' => 7,
                'banges' => '<span class="badge bg-danger"><i class="fas fa-user-times"></i> No procede</span>',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),            
        ));
    }
}
