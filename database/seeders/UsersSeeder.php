<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();
        DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Administrador',
                'codigo' => '1',
                'email' => 'admin@headcontrol.com',
                'password' => '$2y$12$F3.dZvpb2.SZ6EfoynN6JOkkn71Jd4meofwnKMa42myW6yzndO.RO',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
        ));
    }
}
