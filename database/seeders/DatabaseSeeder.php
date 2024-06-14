<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(TipoestructuraSeeder::class);
        $this->call(TipocompetenciaSeeder::class);
        $this->call(TipojerarquiaSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(RolmenuSeeder::class);
        $this->call(UsrrolSeeder::class);
        $this->call(Vacantesmotivo::class);
        $this->call(Vacantesgenero::class);
        $this->call(Vacantesedades::class);
        $this->call(Vacantesetapas::class);
        $this->call(Vacantesestatus::class);
        $this->call(dir_provincias::class);
        $this->call(dir_distritos::class);
        $this->call(dir_corregimientos::class);
        $this->call(usr_tipo_documento::class);
        $this->call(usr_estatus_educ::class);
        $this->call(usr_listdiscapacidad::class);
        $this->call(usr_tipo_rela_referencia::class);
        $this->call(usr_nacionalidad::class);


        $this->call(usr_partici_etapas_proceso::class);
    }
}
