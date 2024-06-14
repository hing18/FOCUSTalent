<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class dir_distritos extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dir_distritos')->delete();
        DB::table('dir_distritos')->insert(array (
            0 => 
            array (
                'id' => 1,
                'distrito' => 'AGUADULCE',
                'id_provincia' => '3',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            1 => 
            array (
                'id' => 2,
                'distrito' => 'ALANJE',
                'id_provincia' => '2',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            2 => 
            array (
                'id' => 3,
                'distrito' => 'ALMIRANTE',
                'id_provincia' => '1',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            3 => 
            array (
                'id' => 4,
                'distrito' => 'ANTÓN',
                'id_provincia' => '3',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            4 => 
            array (
                'id' => 5,
                'distrito' => 'ARRAIJÁN',
                'id_provincia' => '14',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            5 => 
            array (
                'id' => 6,
                'distrito' => 'ATALAYA',
                'id_provincia' => '15',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            6 => 
            array (
                'id' => 7,
                'distrito' => 'BALBOA',
                'id_provincia' => '13',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            7 => 
            array (
                'id' => 8,
                'distrito' => 'BARÚ',
                'id_provincia' => '2',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            8 => 
            array (
                'id' => 9,
                'distrito' => 'BESIKO',
                'id_provincia' => '9',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            9 => 
            array (
                'id' => 10,
                'distrito' => 'BOCAS DEL TORO',
                'id_provincia' => '1',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            10 => 
            array (
                'id' => 11,
                'distrito' => 'BOQUERÓN',
                'id_provincia' => '2',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            11 => 
            array (
                'id' => 12,
                'distrito' => 'BOQUETE',
                'id_provincia' => '2',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            12 => 
            array (
                'id' => 13,
                'distrito' => 'BUGABA',
                'id_provincia' => '2',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            13 => 
            array (
                'id' => 14,
                'distrito' => 'CALOBRE',
                'id_provincia' => '15',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            14 => 
            array (
                'id' => 15,
                'distrito' => 'CAÑAZAS',
                'id_provincia' => '15',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            15 => 
            array (
                'id' => 16,
                'distrito' => 'CAPIRA',
                'id_provincia' => '14',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            16 => 
            array (
                'id' => 17,
                'distrito' => 'CÉMACO',
                'id_provincia' => '5',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            17 => 
            array (
                'id' => 18,
                'distrito' => 'CHAGRES',
                'id_provincia' => '4',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            18 => 
            array (
                'id' => 19,
                'distrito' => 'CHAME',
                'id_provincia' => '14',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            19 => 
            array (
                'id' => 20,
                'distrito' => 'CHANGUINOLA',
                'id_provincia' => '1',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            20 => 
            array (
                'id' => 21,
                'distrito' => 'CHEPIGANA',
                'id_provincia' => '10',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            21 => 
            array (
                'id' => 22,
                'distrito' => 'CHEPO',
                'id_provincia' => '13',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            22 => 
            array (
                'id' => 23,
                'distrito' => 'CHIMÁN',
                'id_provincia' => '13',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            23 => 
            array (
                'id' => 24,
                'distrito' => 'CHIRIQUÍ GRANDE',
                'id_provincia' => '1',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            24 => 
            array (
                'id' => 25,
                'distrito' => 'CHITRÉ',
                'id_provincia' => '11',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            25 => 
            array (
                'id' => 26,
                'distrito' => 'COCLESITO',
                'id_provincia' => '4',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            26 => 
            array (
                'id' => 27,
                'distrito' => 'COLÓN',
                'id_provincia' => '4',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            27 => 
            array (
                'id' => 28,
                'distrito' => 'DAVID',
                'id_provincia' => '2',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            28 => 
            array (
                'id' => 29,
                'distrito' => 'DOLEGA',
                'id_provincia' => '2',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            29 => 
            array (
                'id' => 30,
                'distrito' => 'DONOSO',
                'id_provincia' => '4',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            30 => 
            array (
                'id' => 31,
                'distrito' => 'GUALACA',
                'id_provincia' => '2',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            31 => 
            array (
                'id' => 32,
                'distrito' => 'GUARARÉ',
                'id_provincia' => '12',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            32 => 
            array (
                'id' => 33,
                'distrito' => 'JIRONDAI',
                'id_provincia' => '9',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            33 => 
            array (
                'id' => 34,
                'distrito' => 'KANKINTÚ',
                'id_provincia' => '9',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            34 => 
            array (
                'id' => 35,
                'distrito' => 'KUSAPÍN',
                'id_provincia' => '9',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            35 => 
            array (
                'id' => 36,
                'distrito' => 'LA CHORRERA',
                'id_provincia' => '14',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            36 => 
            array (
                'id' => 37,
                'distrito' => 'LA MESA',
                'id_provincia' => '15',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            37 => 
            array (
                'id' => 38,
                'distrito' => 'LA PINTADA',
                'id_provincia' => '3',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            38 => 
            array (
                'id' => 39,
                'distrito' => 'LAS MINAS',
                'id_provincia' => '11',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            39 => 
            array (
                'id' => 40,
                'distrito' => 'LAS PALMAS',
                'id_provincia' => '15',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            40 => 
            array (
                'id' => 41,
                'distrito' => 'LAS TABLAS',
                'id_provincia' => '12',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            41 => 
            array (
                'id' => 42,
                'distrito' => 'LOS POZOS',
                'id_provincia' => '11',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            42 => 
            array (
                'id' => 43,
                'distrito' => 'LOS SANTOS',
                'id_provincia' => '12',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            43 => 
            array (
                'id' => 44,
                'distrito' => 'MACARACAS',
                'id_provincia' => '12',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            44 => 
            array (
                'id' => 45,
                'distrito' => 'MARIATO',
                'id_provincia' => '15',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            45 => 
            array (
                'id' => 46,
                'distrito' => 'MIRONÓ',
                'id_provincia' => '9',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            46 => 
            array (
                'id' => 47,
                'distrito' => 'MONTIJO',
                'id_provincia' => '15',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            47 => 
            array (
                'id' => 48,
                'distrito' => 'MUNÁ',
                'id_provincia' => '9',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            48 => 
            array (
                'id' => 49,
                'distrito' => 'N.A',
                'id_provincia' => '6',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            49 => 
            array (
                'id' => 50,
                'distrito' => 'N.A',
                'id_provincia' => '7',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            50 => 
            array (
                'id' => 51,
                'distrito' => 'N.A',
                'id_provincia' => '8',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            51 => 
            array (
                'id' => 52,
                'distrito' => 'NATÁ',
                'id_provincia' => '3',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            52 => 
            array (
                'id' => 53,
                'distrito' => 'NOLE DUIMA',
                'id_provincia' => '9',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            53 => 
            array (
                'id' => 54,
                'distrito' => 'ÑURÚN',
                'id_provincia' => '9',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            54 => 
            array (
                'id' => 55,
                'distrito' => 'OCÚ',
                'id_provincia' => '11',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            55 => 
            array (
                'id' => 56,
                'distrito' => 'OLA',
                'id_provincia' => '3',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            56 => 
            array (
                'id' => 57,
                'distrito' => 'OMAR TORRIJOS HERRERA',
                'id_provincia' => '4',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            57 => 
            array (
                'id' => 58,
                'distrito' => 'PANAMÁ',
                'id_provincia' => '13',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            58 => 
            array (
                'id' => 59,
                'distrito' => 'PARITA',
                'id_provincia' => '11',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            59 => 
            array (
                'id' => 60,
                'distrito' => 'PEDASÍ',
                'id_provincia' => '12',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            60 => 
            array (
                'id' => 61,
                'distrito' => 'PENONOMÉ',
                'id_provincia' => '3',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            61 => 
            array (
                'id' => 62,
                'distrito' => 'PESÉ',
                'id_provincia' => '11',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            62 => 
            array (
                'id' => 63,
                'distrito' => 'PINOGANA',
                'id_provincia' => '10',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            63 => 
            array (
                'id' => 64,
                'distrito' => 'POCRÍ',
                'id_provincia' => '12',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            64 => 
            array (
                'id' => 65,
                'distrito' => 'PORTOBELO',
                'id_provincia' => '4',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            65 => 
            array (
                'id' => 66,
                'distrito' => 'REMEDIOS',
                'id_provincia' => '2',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            66 => 
            array (
                'id' => 67,
                'distrito' => 'RENACIMIENTO',
                'id_provincia' => '2',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            67 => 
            array (
                'id' => 68,
                'distrito' => 'RÍO DE JESÚS',
                'id_provincia' => '15',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            68 => 
            array (
                'id' => 69,
                'distrito' => 'SAMBÚ',
                'id_provincia' => '5',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            69 => 
            array (
                'id' => 70,
                'distrito' => 'SAN CARLOS',
                'id_provincia' => '14',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            70 => 
            array (
                'id' => 71,
                'distrito' => 'SAN FÉLIX',
                'id_provincia' => '2',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            71 => 
            array (
                'id' => 72,
                'distrito' => 'SAN FRANCISCO',
                'id_provincia' => '15',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            72 => 
            array (
                'id' => 73,
                'distrito' => 'SAN LORENZO',
                'id_provincia' => '2',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            73 => 
            array (
                'id' => 74,
                'distrito' => 'SAN MIGUELITO',
                'id_provincia' => '13',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            74 => 
            array (
                'id' => 75,
                'distrito' => 'SANTA CATALINA O CALOVÉBORA',
                'id_provincia' => '9',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            75 => 
            array (
                'id' => 76,
                'distrito' => 'SANTA FE',
                'id_provincia' => '10',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            76 => 
            array (
                'id' => 77,
                'distrito' => 'SANTA FÉ',
                'id_provincia' => '15',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            77 => 
            array (
                'id' => 78,
                'distrito' => 'SANTA ISABEL',
                'id_provincia' => '4',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            78 => 
            array (
                'id' => 79,
                'distrito' => 'SANTA MARÍA',
                'id_provincia' => '11',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            79 => 
            array (
                'id' => 80,
                'distrito' => 'SANTIAGO',
                'id_provincia' => '15',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            80 => 
            array (
                'id' => 81,
                'distrito' => 'SONÁ',
                'id_provincia' => '15',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            81 => 
            array (
                'id' => 82,
                'distrito' => 'TABOGA',
                'id_provincia' => '13',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            82 => 
            array (
                'id' => 83,
                'distrito' => 'TIERRAS ALTAS',
                'id_provincia' => '2',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            83 => 
            array (
                'id' => 84,
                'distrito' => 'TOLÉ',
                'id_provincia' => '2',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            84 => 
            array (
                'id' => 85,
                'distrito' => 'TONOSÍ',
                'id_provincia' => '12',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
        ));
    }
}
