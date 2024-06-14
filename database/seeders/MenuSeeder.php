<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menu')->delete();
        DB::table('menu')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name_menu' => 'Dashboard',
                'id_sup' => null,
                'link' => 'dashboard',
                'icono' => '<i class="bi bi-grid"></i>',
                'orden' => 1,
                'tipo' => 'S',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            1 => 
            array (
                'id' => 2,
                'name_menu' => 'Reclutamiento',
                'id_sup' => null,
                'link' => null,
                'icono' => '<i class="bi bi-person"></i>',
                'orden' => 2,
                'tipo' => 'P',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            2 => 
            array (
                'id' => 3,
                'name_menu' => 'Solicitud de Vacantes',
                'id_sup' => 2,
                'link' => 'solvacantes',
                'icono' => '<i class="bi bi-circle"></i>',
                'orden' => 3,
                'tipo' => 'H',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            3 => 
            array (
                'id' => 4,
                'name_menu' => 'Gestión Organizativa',
                'id_sup' => null,
                'link' => null,
                'icono' => '<i class="bi bi-menu-button-wide"></i>',
                'orden' => 4,
                'tipo' => 'P',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            4 => 
            array (
                'id' => 5,
                'name_menu' => 'Maestro de Unidades',
                'id_sup' => 4,
                'link' => 'estructura.unidades',
                'icono' => '<i class="bi bi-circle"></i>',
                'orden' => 5,
                'tipo' => 'H',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            5 => 
            array (
                'id' => 6,
                'name_menu' => 'Maestro de Posiciones',
                'id_sup' => 4,
                'link' => 'posiciones',
                'icono' => '<i class="bi bi-circle"></i>',
                'orden' => 6,
                'tipo' => 'H',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            6 => 
            array (
                'id' => 7,
                'name_menu' => 'Maestro de DF',
                'id_sup' => 4,
                'link' => 'descriptivos',
                'icono' => '<i class="bi bi-circle"></i>',
                'orden' => 7,
                'tipo' => 'H',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            7 => 
            array (
                'id' => 8,
                'name_menu' => 'Maestro de Jerarquías',
                'id_sup' => 4,
                'link' => 'jerarquias',
                'icono' => '<i class="bi bi-circle"></i>',
                'orden' => 8,
                'tipo' => 'H',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            8 => 
            array (
                'id' => 9,
                'name_menu' => 'Maestro de Competencias',
                'id_sup' => 4,
                'link' => 'competencias',
                'icono' => '<i class="bi bi-circle"></i>',
                'orden' => 9,
                'tipo' => 'H',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            9 => 
            array (
                'id' => 10,
                'name_menu' => 'Estructuras',
                'id_sup' => 4,
                'link' => 'estructura',
                'icono' => '<i class="bi bi-circle"></i>',
                'orden' => 10,
                'tipo' => 'H',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            10 => 
            array (
                'id' => 11,
                'name_menu' => 'ADMINISTRACIÓN',
                'id_sup' => 0,
                'link' => null,
                'icono' => null,
                'orden' => 11,
                'tipo' => 'M',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            11 => 
            array (
                'id' => 12,
                'name_menu' => 'Configuración',
                'id_sup' => 11,
                'link' => null,
                'icono' => '<i class="bi bi-tools"></i>',
                'orden' => 12,
                'tipo' => 'P',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            12 => 
            array (
                'id' => 13,
                'name_menu' => 'Usuarios',
                'id_sup' => 12,
                'link' => 'users',
                'icono' => '<i class="bi bi-circle"></i>',
                'orden' => 13,
                'tipo' => 'H',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            13 => 
            array (
                'id' => 14,
                'name_menu' => 'Roles',
                'id_sup' => 12,
                'link' => 'roles',
                'icono' => '<i class="bi bi-circle"></i>',
                'orden' => 14,
                'tipo' => 'H',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            14 => 
            array (
                'id' => 15,
                'name_menu' => 'Ofertas Laborales',
                'id_sup' => 2,
                'link' => 'ofertas',
                'icono' => '<i class="bi bi-circle"></i>',
                'orden' => 4,
                'tipo' => 'H',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
        ));
    }
}
