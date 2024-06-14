<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class dir_corregimientos extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dir_corregimientos')->delete();
        DB::table('dir_corregimientos')->insert(array (
            0 => 
            array (
                'id' => 11,
                'CORREGIMIENTO' => '24 DE DICIEMBRE',
                'id_distrito' => '58',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            1 => 
            array (
                'id' => 12,
                'CORREGIMIENTO' => 'ACHIOTE',
                'id_distrito' => '18',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            2 => 
            array (
                'id' => 13,
                'CORREGIMIENTO' => 'AGUA BUENA',
                'id_distrito' => '43',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            3 => 
            array (
                'id' => 14,
                'CORREGIMIENTO' => 'AGUA DE SALUD',
                'id_distrito' => '54',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            4 => 
            array (
                'id' => 15,
                'CORREGIMIENTO' => 'AGUA FRÍA',
                'id_distrito' => '76',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            5 => 
            array (
                'id' => 16,
                'CORREGIMIENTO' => 'AGUADULCE (CAB)',
                'id_distrito' => '1',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            6 => 
            array (
                'id' => 17,
                'CORREGIMIENTO' => 'AILIGANDÍ',
                'id_distrito' => '49',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            7 => 
            array (
                'id' => 18,
                'CORREGIMIENTO' => 'ALANJE (CAB)',
                'id_distrito' => '2',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            8 => 
            array (
                'id' => 19,
                'CORREGIMIENTO' => 'ALCALDE DÍAZ',
                'id_distrito' => '58',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            9 => 
            array (
                'id' => 20,
                'CORREGIMIENTO' => 'ALMIRANTE CABECERA',
                'id_distrito' => '3',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            10 => 
            array (
                'id' => 21,
                'CORREGIMIENTO' => 'ALTO BILINGUE',
                'id_distrito' => '75',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            11 => 
            array (
                'id' => 22,
                'CORREGIMIENTO' => 'ALTO BOQUETE',
                'id_distrito' => '12',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            12 => 
            array (
                'id' => 23,
                'CORREGIMIENTO' => 'ALTO CABALLERO',
                'id_distrito' => '48',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            13 => 
            array (
                'id' => 24,
                'CORREGIMIENTO' => 'ALTO DE JESÚS',
                'id_distrito' => '54',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            14 => 
            array (
                'id' => 25,
                'CORREGIMIENTO' => 'ALTOS DE GÜERA',
                'id_distrito' => '85',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            15 => 
            array (
                'id' => 26,
                'CORREGIMIENTO' => 'AMADOR',
                'id_distrito' => '36',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            16 => 
            array (
                'id' => 27,
                'CORREGIMIENTO' => 'AMELIA DENIS DE ICAZA',
                'id_distrito' => '74',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            17 => 
            array (
                'id' => 28,
                'CORREGIMIENTO' => 'ANCÓN',
                'id_distrito' => '58',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            18 => 
            array (
                'id' => 29,
                'CORREGIMIENTO' => 'ANTÓN (CAB)',
                'id_distrito' => '4',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            19 => 
            array (
                'id' => 30,
                'CORREGIMIENTO' => 'ARENA',
                'id_distrito' => '45',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            20 => 
            array (
                'id' => 31,
                'CORREGIMIENTO' => 'ARNULFO ARIAS',
                'id_distrito' => '74',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            21 => 
            array (
                'id' => 32,
                'CORREGIMIENTO' => 'AROSEMENA',
                'id_distrito' => '36',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            22 => 
            array (
                'id' => 33,
                'CORREGIMIENTO' => 'ARRAIJÁN (CAB)',
                'id_distrito' => '5',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            23 => 
            array (
                'id' => 34,
                'CORREGIMIENTO' => 'ASERRÍO DE GARICHÉ',
                'id_distrito' => '13',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            24 => 
            array (
                'id' => 35,
                'CORREGIMIENTO' => 'ATALAYA (CAB)',
                'id_distrito' => '6',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            25 => 
            array (
                'id' => 36,
                'CORREGIMIENTO' => 'BACO',
                'id_distrito' => '8',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            26 => 
            array (
                'id' => 37,
                'CORREGIMIENTO' => 'BÁGALA',
                'id_distrito' => '11',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            27 => 
            array (
                'id' => 38,
                'CORREGIMIENTO' => 'BAGAMA',
                'id_distrito' => '48',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            28 => 
            array (
                'id' => 39,
                'CORREGIMIENTO' => 'BAHÍA AZUL',
                'id_distrito' => '35',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            29 => 
            array (
                'id' => 40,
                'CORREGIMIENTO' => 'BAHÍA HONDA',
                'id_distrito' => '44',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            30 => 
            array (
                'id' => 41,
                'CORREGIMIENTO' => 'BAHÍA HONDA',
                'id_distrito' => '81',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            31 => 
            array (
                'id' => 42,
                'CORREGIMIENTO' => 'BAJO BOQUETE (CAB)',
                'id_distrito' => '12',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            32 => 
            array (
                'id' => 43,
                'CORREGIMIENTO' => 'BAJO CEDRO',
                'id_distrito' => '24',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            33 => 
            array (
                'id' => 44,
                'CORREGIMIENTO' => 'BAJO CORRAL',
                'id_distrito' => '41',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            34 => 
            array (
                'id' => 45,
                'CORREGIMIENTO' => 'BAJOS DE GÜERA',
                'id_distrito' => '44',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            35 => 
            array (
                'id' => 46,
                'CORREGIMIENTO' => 'BARNIZAL',
                'id_distrito' => '14',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            36 => 
            array (
                'id' => 47,
                'CORREGIMIENTO' => 'BARRIADA 4 DE ABRIL',
                'id_distrito' => '20',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            37 => 
            array (
                'id' => 48,
                'CORREGIMIENTO' => 'BARRIADA GUAYMÍ',
                'id_distrito' => '3',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            38 => 
            array (
                'id' => 49,
                'CORREGIMIENTO' => 'BARRIO BALBOA',
                'id_distrito' => '36',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            39 => 
            array (
                'id' => 50,
                'CORREGIMIENTO' => 'BARRIO COLÓN',
                'id_distrito' => '36',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            40 => 
            array (
                'id' => 51,
                'CORREGIMIENTO' => 'BARRIO FRANCÉS',
                'id_distrito' => '3',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            41 => 
            array (
                'id' => 52,
                'CORREGIMIENTO' => 'BARRIO NORTE',
                'id_distrito' => '27',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            42 => 
            array (
                'id' => 53,
                'CORREGIMIENTO' => 'BARRIO SUR',
                'id_distrito' => '27',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            43 => 
            array (
                'id' => 54,
                'CORREGIMIENTO' => 'BARRIOS UNIDOS',
                'id_distrito' => '1',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            44 => 
            array (
                'id' => 55,
                'CORREGIMIENTO' => 'BASTIMENTOS',
                'id_distrito' => '10',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            45 => 
            array (
                'id' => 56,
                'CORREGIMIENTO' => 'BAYANO',
                'id_distrito' => '41',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            46 => 
            array (
                'id' => 57,
                'CORREGIMIENTO' => 'BEJUCO',
                'id_distrito' => '19',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            47 => 
            array (
                'id' => 58,
                'CORREGIMIENTO' => 'BELISARIO FRÍAS',
                'id_distrito' => '74',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            48 => 
            array (
                'id' => 59,
                'CORREGIMIENTO' => 'BELISARIO PORRAS',
                'id_distrito' => '74',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            49 => 
            array (
                'id' => 60,
                'CORREGIMIENTO' => 'BELLA VISTA',
                'id_distrito' => '58',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            50 => 
            array (
                'id' => 61,
                'CORREGIMIENTO' => 'BELLA VISTA',
                'id_distrito' => '84',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            51 => 
            array (
                'id' => 62,
                'CORREGIMIENTO' => 'BETANIA',
                'id_distrito' => '58',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            52 => 
            array (
                'id' => 63,
                'CORREGIMIENTO' => 'BIJAGUAL',
                'id_distrito' => '28',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            53 => 
            array (
                'id' => 64,
                'CORREGIMIENTO' => 'BISIRA',
                'id_distrito' => '34',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            54 => 
            array (
                'id' => 65,
                'CORREGIMIENTO' => 'BISVALLES',
                'id_distrito' => '37',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            55 => 
            array (
                'id' => 66,
                'CORREGIMIENTO' => 'BOCA CHICA',
                'id_distrito' => '73',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            56 => 
            array (
                'id' => 67,
                'CORREGIMIENTO' => 'BOCA DE BALSA',
                'id_distrito' => '9',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            57 => 
            array (
                'id' => 68,
                'CORREGIMIENTO' => 'BOCA DE CUPE',
                'id_distrito' => '63',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            58 => 
            array (
                'id' => 69,
                'CORREGIMIENTO' => 'BOCA DEL MONTE',
                'id_distrito' => '73',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            59 => 
            array (
                'id' => 70,
                'CORREGIMIENTO' => 'BOCAS DEL TORO CABECERA',
                'id_distrito' => '10',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            60 => 
            array (
                'id' => 71,
                'CORREGIMIENTO' => 'BOQUERÓN (CAB)',
                'id_distrito' => '11',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            61 => 
            array (
                'id' => 72,
                'CORREGIMIENTO' => 'BORÓ',
                'id_distrito' => '37',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            62 => 
            array (
                'id' => 73,
                'CORREGIMIENTO' => 'BREÑÓN',
                'id_distrito' => '67',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            63 => 
            array (
                'id' => 74,
                'CORREGIMIENTO' => 'BRUJAS',
                'id_distrito' => '23',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            64 => 
            array (
                'id' => 75,
                'CORREGIMIENTO' => 'BUENA VISTA',
                'id_distrito' => '27',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            65 => 
            array (
                'id' => 76,
                'CORREGIMIENTO' => 'BUENOS AIRES',
                'id_distrito' => '19',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            66 => 
            array (
                'id' => 77,
                'CORREGIMIENTO' => 'BUENOS AIRES',
                'id_distrito' => '54',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            67 => 
            array (
                'id' => 78,
                'CORREGIMIENTO' => 'BUGABA',
                'id_distrito' => '13',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            68 => 
            array (
                'id' => 79,
                'CORREGIMIENTO' => 'BURI',
                'id_distrito' => '33',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            69 => 
            array (
                'id' => 80,
                'CORREGIMIENTO' => 'BURUNGA',
                'id_distrito' => '5',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            70 => 
            array (
                'id' => 81,
                'CORREGIMIENTO' => 'CABALLERO',
                'id_distrito' => '4',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            71 => 
            array (
                'id' => 82,
                'CORREGIMIENTO' => 'CABUYA',
                'id_distrito' => '4',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            72 => 
            array (
                'id' => 83,
                'CORREGIMIENTO' => 'CABUYA',
                'id_distrito' => '19',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            73 => 
            array (
                'id' => 84,
                'CORREGIMIENTO' => 'CABUYA',
                'id_distrito' => '59',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            74 => 
            array (
                'id' => 85,
                'CORREGIMIENTO' => 'CACIQUE',
                'id_distrito' => '65',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            75 => 
            array (
                'id' => 86,
                'CORREGIMIENTO' => 'CAIMITILLO',
                'id_distrito' => '58',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            76 => 
            array (
                'id' => 87,
                'CORREGIMIENTO' => 'CAIMITO',
                'id_distrito' => '16',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            77 => 
            array (
                'id' => 1,
                'CORREGIMIENTO' => 'CALANTE',
                'id_distrito' => '34',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            78 => 
            array (
                'id' => 88,
                'CORREGIMIENTO' => 'CALDERA',
                'id_distrito' => '12',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            79 => 
            array (
                'id' => 89,
                'CORREGIMIENTO' => 'CALIDONIA',
                'id_distrito' => '58',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            80 => 
            array (
                'id' => 90,
                'CORREGIMIENTO' => 'CALIDONIA',
                'id_distrito' => '81',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            81 => 
            array (
                'id' => 91,
                'CORREGIMIENTO' => 'CALOBRE (CAB)',
                'id_distrito' => '14',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            82 => 
            array (
                'id' => 92,
                'CORREGIMIENTO' => 'CALOVÉBORA',
                'id_distrito' => '77',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            83 => 
            array (
                'id' => 93,
                'CORREGIMIENTO' => 'CAMARÓN ARRIBA',
                'id_distrito' => '9',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            84 => 
            array (
                'id' => 94,
                'CORREGIMIENTO' => 'CAMBUTAL',
                'id_distrito' => '85',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            85 => 
            array (
                'id' => 95,
                'CORREGIMIENTO' => 'CAMOGANTÍ',
                'id_distrito' => '21',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            86 => 
            array (
                'id' => 96,
                'CORREGIMIENTO' => 'CAMPANA',
                'id_distrito' => '16',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            87 => 
            array (
                'id' => 97,
                'CORREGIMIENTO' => 'CANTA GALLO',
                'id_distrito' => '2',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            88 => 
            array (
                'id' => 98,
                'CORREGIMIENTO' => 'CANTO DEL LLANO',
                'id_distrito' => '80',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            89 => 
            array (
                'id' => 99,
                'CORREGIMIENTO' => 'CAÑAS',
                'id_distrito' => '85',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            90 => 
            array (
                'id' => 100,
                'CORREGIMIENTO' => 'CAÑAS GORDAS',
                'id_distrito' => '67',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            91 => 
            array (
                'id' => 101,
                'CORREGIMIENTO' => 'CAÑAVERAL',
                'id_distrito' => '35',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            92 => 
            array (
                'id' => 102,
                'CORREGIMIENTO' => 'CAÑAVERAL',
                'id_distrito' => '61',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            93 => 
            array (
                'id' => 103,
                'CORREGIMIENTO' => 'CAÑAZAS (CAB)',
                'id_distrito' => '15',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            94 => 
            array (
                'id' => 104,
                'CORREGIMIENTO' => 'CAÑITA',
                'id_distrito' => '22',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            95 => 
            array (
                'id' => 105,
                'CORREGIMIENTO' => 'CAPELLANÍA',
                'id_distrito' => '52',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            96 => 
            array (
                'id' => 106,
                'CORREGIMIENTO' => 'CAPIRA (CAB)',
                'id_distrito' => '16',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            97 => 
            array (
                'id' => 107,
                'CORREGIMIENTO' => 'CAPURÍ',
                'id_distrito' => '42',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            98 => 
            array (
                'id' => 108,
                'CORREGIMIENTO' => 'CARATE',
                'id_distrito' => '41',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            99 => 
            array (
                'id' => 109,
                'CORREGIMIENTO' => 'CARLOS SANTANA',
                'id_distrito' => '80',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            100 => 
            array (
                'id' => 110,
                'CORREGIMIENTO' => 'CASCABEL',
                'id_distrito' => '46',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            101 => 
            array (
                'id' => 111,
                'CORREGIMIENTO' => 'CATIVÁ',
                'id_distrito' => '27',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            102 => 
            array (
                'id' => 112,
                'CORREGIMIENTO' => 'CATIVÉ',
                'id_distrito' => '81',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            103 => 
            array (
                'id' => 113,
                'CORREGIMIENTO' => 'CATORCE DE NOVIEMBRE',
                'id_distrito' => '68',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            104 => 
            array (
                'id' => 114,
                'CORREGIMIENTO' => 'CAUCHERO',
                'id_distrito' => '10',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            105 => 
            array (
                'id' => 2,
                'CORREGIMIENTO' => 'CÉBACO',
                'id_distrito' => '47',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            106 => 
            array (
                'id' => 115,
                'CORREGIMIENTO' => 'CERMEÑO',
                'id_distrito' => '16',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            107 => 
            array (
                'id' => 116,
                'CORREGIMIENTO' => 'CERRO BANCO',
                'id_distrito' => '9',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            108 => 
            array (
                'id' => 254,
                'CORREGIMIENTO' => 'CERRO CAÑA',
                'id_distrito' => '48',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            109 => 
            array (
                'id' => 117,
                'CORREGIMIENTO' => 'CERRO DE CASA',
                'id_distrito' => '40',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            110 => 
            array (
                'id' => 118,
                'CORREGIMIENTO' => 'CERRO DE PATENA',
                'id_distrito' => '9',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            111 => 
            array (
                'id' => 119,
                'CORREGIMIENTO' => 'CERRO DE PLATA',
                'id_distrito' => '15',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            112 => 
            array (
                'id' => 120,
                'CORREGIMIENTO' => 'CERRO IGLESIAS',
                'id_distrito' => '53',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            113 => 
            array (
                'id' => 121,
                'CORREGIMIENTO' => 'CERRO LARGO',
                'id_distrito' => '55',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            114 => 
            array (
                'id' => 122,
                'CORREGIMIENTO' => 'CERRO PELADO',
                'id_distrito' => '54',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            115 => 
            array (
                'id' => 123,
                'CORREGIMIENTO' => 'CERRO PUERCO',
                'id_distrito' => '48',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            116 => 
            array (
                'id' => 124,
                'CORREGIMIENTO' => 'CERRO PUNTA',
                'id_distrito' => '83',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            117 => 
            array (
                'id' => 125,
                'CORREGIMIENTO' => 'CERRO SILVESTRE',
                'id_distrito' => '5',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            118 => 
            array (
                'id' => 126,
                'CORREGIMIENTO' => 'CERRO VIEJO',
                'id_distrito' => '84',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            119 => 
            array (
                'id' => 127,
                'CORREGIMIENTO' => 'CHAME (CAB)',
                'id_distrito' => '19',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            120 => 
            array (
                'id' => 128,
                'CORREGIMIENTO' => 'CHANGUINOLA CABECERA',
                'id_distrito' => '20',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            121 => 
            array (
                'id' => 129,
                'CORREGIMIENTO' => 'CHEPIGANA',
                'id_distrito' => '21',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            122 => 
            array (
                'id' => 130,
                'CORREGIMIENTO' => 'CHEPILLO',
                'id_distrito' => '22',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            123 => 
            array (
                'id' => 131,
                'CORREGIMIENTO' => 'CHEPO',
                'id_distrito' => '39',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            124 => 
            array (
                'id' => 132,
                'CORREGIMIENTO' => 'CHEPO (CAB)',
                'id_distrito' => '22',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            125 => 
            array (
                'id' => 133,
                'CORREGIMIENTO' => 'CHICÁ',
                'id_distrito' => '19',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            126 => 
            array (
                'id' => 134,
                'CORREGIMIENTO' => 'CHICHICA',
                'id_distrito' => '48',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            127 => 
            array (
                'id' => 135,
                'CORREGIMIENTO' => 'CHIGUIRÍ ARRIBA',
                'id_distrito' => '61',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            128 => 
            array (
                'id' => 136,
                'CORREGIMIENTO' => 'CHILIBRE',
                'id_distrito' => '58',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            129 => 
            array (
                'id' => 137,
                'CORREGIMIENTO' => 'CHIMÁN (CAB)',
                'id_distrito' => '23',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            130 => 
            array (
                'id' => 138,
                'CORREGIMIENTO' => 'CHIRIQUÍ',
                'id_distrito' => '28',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            131 => 
            array (
                'id' => 139,
                'CORREGIMIENTO' => 'CHIRIQUÍ GRANDE CABECERA',
                'id_distrito' => '24',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            132 => 
            array (
                'id' => 140,
                'CORREGIMIENTO' => 'CHITRA',
                'id_distrito' => '14',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            133 => 
            array (
                'id' => 141,
                'CORREGIMIENTO' => 'CHITRÉ (CAB)',
                'id_distrito' => '25',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            134 => 
            array (
                'id' => 142,
                'CORREGIMIENTO' => 'CHUMICAL',
                'id_distrito' => '39',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            135 => 
            array (
                'id' => 143,
                'CORREGIMIENTO' => 'CHUPÁ',
                'id_distrito' => '44',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            136 => 
            array (
                'id' => 144,
                'CORREGIMIENTO' => 'CHUPAMPA',
                'id_distrito' => '79',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            137 => 
            array (
                'id' => 145,
                'CORREGIMIENTO' => 'CIRÍ DE LOS SOTOS',
                'id_distrito' => '16',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            138 => 
            array (
                'id' => 146,
                'CORREGIMIENTO' => 'CIRÍ GRANDE',
                'id_distrito' => '16',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            139 => 
            array (
                'id' => 147,
                'CORREGIMIENTO' => 'CIRICITO',
                'id_distrito' => '27',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            140 => 
            array (
                'id' => 148,
                'CORREGIMIENTO' => 'CIRILO GUAYNORA',
                'id_distrito' => '17',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            141 => 
            array (
                'id' => 149,
                'CORREGIMIENTO' => 'COCHEA',
                'id_distrito' => '28',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            142 => 
            array (
                'id' => 150,
                'CORREGIMIENTO' => 'COCHIGRÓ',
                'id_distrito' => '20',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            143 => 
            array (
                'id' => 151,
                'CORREGIMIENTO' => 'COCLÉ',
                'id_distrito' => '61',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            144 => 
            array (
                'id' => 152,
                'CORREGIMIENTO' => 'COCLÉ DEL NORTE',
                'id_distrito' => '30',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            145 => 
            array (
                'id' => 153,
                'CORREGIMIENTO' => 'CORDILLERA',
                'id_distrito' => '11',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            146 => 
            array (
                'id' => 154,
                'CORREGIMIENTO' => 'COROZAL',
                'id_distrito' => '40',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            147 => 
            array (
                'id' => 155,
                'CORREGIMIENTO' => 'COROZAL',
                'id_distrito' => '44',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            148 => 
            array (
                'id' => 156,
                'CORREGIMIENTO' => 'CORRAL FALSO',
                'id_distrito' => '72',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            149 => 
            array (
                'id' => 157,
                'CORREGIMIENTO' => 'COSTA HERMOSA',
                'id_distrito' => '47',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            150 => 
            array (
                'id' => 158,
                'CORREGIMIENTO' => 'CRISTÓBAL',
                'id_distrito' => '27',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            151 => 
            array (
                'id' => 159,
                'CORREGIMIENTO' => 'CRISTÓBAL ESTE',
                'id_distrito' => '27',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            152 => 
            array (
                'id' => 160,
                'CORREGIMIENTO' => 'CUANGO',
                'id_distrito' => '78',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            153 => 
            array (
                'id' => 161,
                'CORREGIMIENTO' => 'CUCUNATÍ',
                'id_distrito' => '76',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            154 => 
            array (
                'id' => 162,
                'CORREGIMIENTO' => 'CUESTA DE PIEDRA',
                'id_distrito' => '83',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            155 => 
            array (
                'id' => 163,
                'CORREGIMIENTO' => 'CURUNDÚ',
                'id_distrito' => '58',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            156 => 
            array (
                'id' => 164,
                'CORREGIMIENTO' => 'DAVID (CAB)',
                'id_distrito' => '28',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            157 => 
            array (
                'id' => 165,
                'CORREGIMIENTO' => 'DAVID ESTE',
                'id_distrito' => '28',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            158 => 
            array (
                'id' => 166,
                'CORREGIMIENTO' => 'DAVID SUR',
                'id_distrito' => '28',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            159 => 
            array (
                'id' => 167,
                'CORREGIMIENTO' => 'DIKERI',
                'id_distrito' => '48',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            160 => 
            array (
                'id' => 168,
                'CORREGIMIENTO' => 'DIKO',
                'id_distrito' => '48',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            161 => 
            array (
                'id' => 169,
                'CORREGIMIENTO' => 'DIVALÁ',
                'id_distrito' => '2',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            162 => 
            array (
                'id' => 170,
                'CORREGIMIENTO' => 'DOLEGA (CAB)',
                'id_distrito' => '29',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            163 => 
            array (
                'id' => 171,
                'CORREGIMIENTO' => 'DOMINICAL',
                'id_distrito' => '67',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            164 => 
            array (
                'id' => 172,
                'CORREGIMIENTO' => 'DON BOSCO',
                'id_distrito' => '58',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            165 => 
            array (
                'id' => 173,
                'CORREGIMIENTO' => 'DOS RÍOS',
                'id_distrito' => '29',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            166 => 
            array (
                'id' => 174,
                'CORREGIMIENTO' => 'EDWIN FÁBREGA',
                'id_distrito' => '80',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            167 => 
            array (
                'id' => 175,
                'CORREGIMIENTO' => 'EL ALTO',
                'id_distrito' => '77',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            168 => 
            array (
                'id' => 176,
                'CORREGIMIENTO' => 'EL ARADO',
                'id_distrito' => '36',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            169 => 
            array (
                'id' => 177,
                'CORREGIMIENTO' => 'EL AROMILLO',
                'id_distrito' => '15',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            170 => 
            array (
                'id' => 178,
                'CORREGIMIENTO' => 'EL BALE',
                'id_distrito' => '54',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            171 => 
            array (
                'id' => 179,
                'CORREGIMIENTO' => 'EL BARRERO',
                'id_distrito' => '62',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            172 => 
            array (
                'id' => 180,
                'CORREGIMIENTO' => 'EL BARRITO',
                'id_distrito' => '6',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            173 => 
            array (
                'id' => 181,
                'CORREGIMIENTO' => 'EL BEBEDERO',
                'id_distrito' => '85',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            174 => 
            array (
                'id' => 182,
                'CORREGIMIENTO' => 'EL BONGO',
                'id_distrito' => '13',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            175 => 
            array (
                'id' => 183,
                'CORREGIMIENTO' => 'EL CACAO',
                'id_distrito' => '16',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            176 => 
            array (
                'id' => 184,
                'CORREGIMIENTO' => 'EL CACAO',
                'id_distrito' => '45',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            177 => 
            array (
                'id' => 185,
                'CORREGIMIENTO' => 'EL CACAO',
                'id_distrito' => '85',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            178 => 
            array (
                'id' => 186,
                'CORREGIMIENTO' => 'EL CALABACITO',
                'id_distrito' => '42',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            179 => 
            array (
                'id' => 187,
                'CORREGIMIENTO' => 'EL CAÑAFÍSTULO',
                'id_distrito' => '64',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            180 => 
            array (
                'id' => 188,
                'CORREGIMIENTO' => 'EL CAÑO',
                'id_distrito' => '52',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            181 => 
            array (
                'id' => 189,
                'CORREGIMIENTO' => 'EL CEDRO',
                'id_distrito' => '42',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            182 => 
            array (
                'id' => 190,
                'CORREGIMIENTO' => 'EL CEDRO',
                'id_distrito' => '44',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            183 => 
            array (
                'id' => 191,
                'CORREGIMIENTO' => 'EL CHIRÚ',
                'id_distrito' => '4',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            184 => 
            array (
                'id' => 192,
                'CORREGIMIENTO' => 'EL CHORRILLO',
                'id_distrito' => '58',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            185 => 
            array (
                'id' => 193,
                'CORREGIMIENTO' => 'EL CIPRIÁN',
                'id_distrito' => '39',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            186 => 
            array (
                'id' => 194,
                'CORREGIMIENTO' => 'EL CIRUELO',
                'id_distrito' => '62',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            187 => 
            array (
                'id' => 195,
                'CORREGIMIENTO' => 'EL COCAL',
                'id_distrito' => '41',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            188 => 
            array (
                'id' => 196,
                'CORREGIMIENTO' => 'EL COCLA',
                'id_distrito' => '14',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            189 => 
            array (
                'id' => 197,
                'CORREGIMIENTO' => 'EL COCO',
                'id_distrito' => '36',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            190 => 
            array (
                'id' => 198,
                'CORREGIMIENTO' => 'EL COCO',
                'id_distrito' => '61',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            191 => 
            array (
                'id' => 199,
                'CORREGIMIENTO' => 'EL COPÉ',
                'id_distrito' => '56',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            192 => 
            array (
                'id' => 200,
                'CORREGIMIENTO' => 'EL CORTEZO',
                'id_distrito' => '85',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            193 => 
            array (
                'id' => 201,
                'CORREGIMIENTO' => 'EL CRISTO',
                'id_distrito' => '1',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            194 => 
            array (
                'id' => 202,
                'CORREGIMIENTO' => 'EL CRISTO',
                'id_distrito' => '84',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            195 => 
            array (
                'id' => 203,
                'CORREGIMIENTO' => 'EL CUAY',
                'id_distrito' => '77',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            196 => 
            array (
                'id' => 204,
                'CORREGIMIENTO' => 'EL EJIDO',
                'id_distrito' => '43',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            197 => 
            array (
                'id' => 205,
                'CORREGIMIENTO' => 'EL EMPALME',
                'id_distrito' => '20',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            198 => 
            array (
                'id' => 206,
                'CORREGIMIENTO' => 'EL ESPINAL',
                'id_distrito' => '32',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            199 => 
            array (
                'id' => 207,
                'CORREGIMIENTO' => 'EL ESPINO',
                'id_distrito' => '70',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            200 => 
            array (
                'id' => 208,
                'CORREGIMIENTO' => 'EL GUÁSIMO',
                'id_distrito' => '30',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            201 => 
            array (
                'id' => 209,
                'CORREGIMIENTO' => 'EL GUÁSIMO',
                'id_distrito' => '43',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            202 => 
            array (
                'id' => 210,
                'CORREGIMIENTO' => 'EL HARINO',
                'id_distrito' => '38',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            203 => 
            array (
                'id' => 211,
                'CORREGIMIENTO' => 'EL HATO',
                'id_distrito' => '32',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            204 => 
            array (
                'id' => 212,
                'CORREGIMIENTO' => 'EL HATO DE SAN JUAN DE DIOS',
                'id_distrito' => '1',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            205 => 
            array (
                'id' => 213,
                'CORREGIMIENTO' => 'EL HIGO',
                'id_distrito' => '37',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            206 => 
            array (
                'id' => 214,
                'CORREGIMIENTO' => 'EL HIGO',
                'id_distrito' => '70',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            207 => 
            array (
                'id' => 215,
                'CORREGIMIENTO' => 'EL LÍBANO',
                'id_distrito' => '19',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            208 => 
            array (
                'id' => 216,
                'CORREGIMIENTO' => 'EL LIMÓN',
                'id_distrito' => '79',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            209 => 
            array (
                'id' => 217,
                'CORREGIMIENTO' => 'EL LLANO',
                'id_distrito' => '22',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            210 => 
            array (
                'id' => 218,
                'CORREGIMIENTO' => 'EL MACANO',
                'id_distrito' => '32',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            211 => 
            array (
                'id' => 219,
                'CORREGIMIENTO' => 'EL MANANTIAL',
                'id_distrito' => '41',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            212 => 
            array (
                'id' => 220,
                'CORREGIMIENTO' => 'EL MARAÑÓN',
                'id_distrito' => '81',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            213 => 
            array (
                'id' => 221,
                'CORREGIMIENTO' => 'EL MARÍA',
                'id_distrito' => '40',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            214 => 
            array (
                'id' => 222,
                'CORREGIMIENTO' => 'EL MUÑOZ',
                'id_distrito' => '41',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            215 => 
            array (
                'id' => 3,
                'CORREGIMIENTO' => 'EL NANCITO',
                'id_distrito' => '66',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            216 => 
            array (
                'id' => 223,
                'CORREGIMIENTO' => 'EL PÁJARO',
                'id_distrito' => '62',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            217 => 
            array (
                'id' => 224,
                'CORREGIMIENTO' => 'EL PALMAR',
                'id_distrito' => '56',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            218 => 
            array (
                'id' => 225,
                'CORREGIMIENTO' => 'EL PANTANO',
                'id_distrito' => '77',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            219 => 
            array (
                'id' => 226,
                'CORREGIMIENTO' => 'EL PAREDÓN',
                'id_distrito' => '54',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            220 => 
            array (
                'id' => 227,
                'CORREGIMIENTO' => 'EL PEDREGOSO',
                'id_distrito' => '41',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            221 => 
            array (
                'id' => 228,
                'CORREGIMIENTO' => 'EL PEDREGOSO',
                'id_distrito' => '62',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            222 => 
            array (
                'id' => 229,
                'CORREGIMIENTO' => 'EL PEÑÓN',
                'id_distrito' => '54',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            223 => 
            array (
                'id' => 230,
                'CORREGIMIENTO' => 'EL PICACHO',
                'id_distrito' => '56',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            224 => 
            array (
                'id' => 231,
                'CORREGIMIENTO' => 'EL PICADOR',
                'id_distrito' => '15',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            225 => 
            array (
                'id' => 232,
                'CORREGIMIENTO' => 'EL PIRO',
                'id_distrito' => '54',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            226 => 
            array (
                'id' => 233,
                'CORREGIMIENTO' => 'EL PIRO N° 2',
                'id_distrito' => '54',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            227 => 
            array (
                'id' => 234,
                'CORREGIMIENTO' => 'EL PORVENIR',
                'id_distrito' => '66',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            228 => 
            array (
                'id' => 235,
                'CORREGIMIENTO' => 'EL POTRERO',
                'id_distrito' => '14',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            229 => 
            array (
                'id' => 236,
                'CORREGIMIENTO' => 'EL POTRERO',
                'id_distrito' => '38',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            230 => 
            array (
                'id' => 237,
                'CORREGIMIENTO' => 'EL PRADO',
                'id_distrito' => '40',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            231 => 
            array (
                'id' => 238,
                'CORREGIMIENTO' => 'EL PUERTO',
                'id_distrito' => '66',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            232 => 
            array (
                'id' => 239,
                'CORREGIMIENTO' => 'EL REAL S.M. (CAB)',
                'id_distrito' => '63',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            233 => 
            array (
                'id' => 240,
                'CORREGIMIENTO' => 'EL RETIRO',
                'id_distrito' => '4',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            234 => 
            array (
                'id' => 241,
                'CORREGIMIENTO' => 'EL RINCÓN',
                'id_distrito' => '40',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            235 => 
            array (
                'id' => 242,
                'CORREGIMIENTO' => 'EL RINCÓN',
                'id_distrito' => '79',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            236 => 
            array (
                'id' => 243,
                'CORREGIMIENTO' => 'EL ROBLE',
                'id_distrito' => '1',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            237 => 
            array (
                'id' => 244,
                'CORREGIMIENTO' => 'EL SESTEADERO',
                'id_distrito' => '41',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            238 => 
            array (
                'id' => 245,
                'CORREGIMIENTO' => 'EL SILENCIO',
                'id_distrito' => '20',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            239 => 
            array (
                'id' => 246,
                'CORREGIMIENTO' => 'EL TEJAR',
                'id_distrito' => '2',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            240 => 
            array (
                'id' => 247,
                'CORREGIMIENTO' => 'EL TERIBE',
                'id_distrito' => '20',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            241 => 
            array (
                'id' => 248,
                'CORREGIMIENTO' => 'EL TIJERA',
                'id_distrito' => '55',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            242 => 
            array (
                'id' => 249,
                'CORREGIMIENTO' => 'EL TORO',
                'id_distrito' => '39',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            243 => 
            array (
                'id' => 250,
                'CORREGIMIENTO' => 'EL VALLE',
                'id_distrito' => '4',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            244 => 
            array (
                'id' => 251,
                'CORREGIMIENTO' => 'EMPLANADA DE CHORCHA',
                'id_distrito' => '9',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            245 => 
            array (
                'id' => 252,
                'CORREGIMIENTO' => 'ENTRADERO DEL CASTILLO',
                'id_distrito' => '55',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            246 => 
            array (
                'id' => 253,
                'CORREGIMIENTO' => 'ERNESTO CÓRDOBA CAMPOS',
                'id_distrito' => '58',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            247 => 
            array (
                'id' => 255,
                'CORREGIMIENTO' => 'ESCOBAL',
                'id_distrito' => '27',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            248 => 
            array (
                'id' => 256,
                'CORREGIMIENTO' => 'ESPINO AMARILLO',
                'id_distrito' => '44',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            249 => 
            array (
                'id' => 257,
                'CORREGIMIENTO' => 'FEUILLET',
                'id_distrito' => '36',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            250 => 
            array (
                'id' => 258,
                'CORREGIMIENTO' => 'FINCA 30',
                'id_distrito' => '20',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            251 => 
            array (
                'id' => 259,
                'CORREGIMIENTO' => 'FINCA 6',
                'id_distrito' => '20',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            252 => 
            array (
                'id' => 260,
                'CORREGIMIENTO' => 'FINCA 60',
                'id_distrito' => '20',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            253 => 
            array (
                'id' => 261,
                'CORREGIMIENTO' => 'FLORES',
                'id_distrito' => '85',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            254 => 
            array (
                'id' => 262,
                'CORREGIMIENTO' => 'GARACHINÉ',
                'id_distrito' => '21',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            255 => 
            array (
                'id' => 263,
                'CORREGIMIENTO' => 'GARROTE',
                'id_distrito' => '65',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            256 => 
            array (
                'id' => 264,
                'CORREGIMIENTO' => 'GATUNCITO',
                'id_distrito' => '77',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            257 => 
            array (
                'id' => 265,
                'CORREGIMIENTO' => 'GOBEA',
                'id_distrito' => '30',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            258 => 
            array (
                'id' => 266,
                'CORREGIMIENTO' => 'GOBERNADORA',
                'id_distrito' => '47',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            259 => 
            array (
                'id' => 267,
                'CORREGIMIENTO' => 'GÓMEZ',
                'id_distrito' => '13',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            260 => 
            array (
                'id' => 268,
                'CORREGIMIENTO' => 'GONZALO VÁSQUEZ',
                'id_distrito' => '23',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            261 => 
            array (
                'id' => 269,
                'CORREGIMIENTO' => 'GUABAL',
                'id_distrito' => '11',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            262 => 
            array (
                'id' => 270,
                'CORREGIMIENTO' => 'GUABITO',
                'id_distrito' => '20',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            263 => 
            array (
                'id' => 271,
                'CORREGIMIENTO' => 'GUABO',
                'id_distrito' => '18',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            264 => 
            array (
                'id' => 272,
                'CORREGIMIENTO' => 'GUACÁ',
                'id_distrito' => '28',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            265 => 
            array (
                'id' => 273,
                'CORREGIMIENTO' => 'GUADALUPE',
                'id_distrito' => '36',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            266 => 
            array (
                'id' => 274,
                'CORREGIMIENTO' => 'GUALACA (CAB)',
                'id_distrito' => '31',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            267 => 
            array (
                'id' => 275,
                'CORREGIMIENTO' => 'GUÁNICO',
                'id_distrito' => '85',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            268 => 
            array (
                'id' => 276,
                'CORREGIMIENTO' => 'GUARARÉ (CAB)',
                'id_distrito' => '32',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            269 => 
            array (
                'id' => 277,
                'CORREGIMIENTO' => 'GUARARÉ ARRIBA',
                'id_distrito' => '32',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            270 => 
            array (
                'id' => 278,
                'CORREGIMIENTO' => 'GUARIVIARA',
                'id_distrito' => '33',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            271 => 
            array (
                'id' => 279,
                'CORREGIMIENTO' => 'GUARUMAL',
                'id_distrito' => '2',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            272 => 
            array (
                'id' => 280,
                'CORREGIMIENTO' => 'GUARUMAL',
                'id_distrito' => '81',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            273 => 
            array (
                'id' => 281,
                'CORREGIMIENTO' => 'GUAYABAL',
                'id_distrito' => '11',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            274 => 
            array (
                'id' => 282,
                'CORREGIMIENTO' => 'GUAYABITO',
                'id_distrito' => '54',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            275 => 
            array (
                'id' => 283,
                'CORREGIMIENTO' => 'GUAYABITO',
                'id_distrito' => '70',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            276 => 
            array (
                'id' => 284,
                'CORREGIMIENTO' => 'GUIBALE',
                'id_distrito' => '54',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            277 => 
            array (
                'id' => 285,
                'CORREGIMIENTO' => 'GUNA DE MADUGANDÍ',
                'id_distrito' => '49',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            278 => 
            array (
                'id' => 286,
                'CORREGIMIENTO' => 'GUNA DE WARGANDÍ',
                'id_distrito' => '49',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            279 => 
            array (
                'id' => 287,
                'CORREGIMIENTO' => 'GUORONÍ',
                'id_distrito' => '34',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            280 => 
            array (
                'id' => 288,
                'CORREGIMIENTO' => 'GUZMÁN',
                'id_distrito' => '52',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            281 => 
            array (
                'id' => 289,
                'CORREGIMIENTO' => 'HATO CHAMÍ',
                'id_distrito' => '53',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            282 => 
            array (
                'id' => 290,
                'CORREGIMIENTO' => 'HATO COROTÚ',
                'id_distrito' => '46',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            283 => 
            array (
                'id' => 291,
                'CORREGIMIENTO' => 'HATO CULANTRO',
                'id_distrito' => '46',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            284 => 
            array (
                'id' => 292,
                'CORREGIMIENTO' => 'HATO JOBO',
                'id_distrito' => '46',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            285 => 
            array (
                'id' => 293,
                'CORREGIMIENTO' => 'HATO JULÍ',
                'id_distrito' => '46',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            286 => 
            array (
                'id' => 294,
                'CORREGIMIENTO' => 'HATO PILÓN',
                'id_distrito' => '46',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            287 => 
            array (
                'id' => 295,
                'CORREGIMIENTO' => 'HERRERA',
                'id_distrito' => '36',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            288 => 
            array (
                'id' => 296,
                'CORREGIMIENTO' => 'HICACO',
                'id_distrito' => '81',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            289 => 
            array (
                'id' => 297,
                'CORREGIMIENTO' => 'HORCONCITOS (CAB)',
                'id_distrito' => '73',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            290 => 
            array (
                'id' => 298,
                'CORREGIMIENTO' => 'HORNITO',
                'id_distrito' => '31',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            291 => 
            array (
                'id' => 299,
                'CORREGIMIENTO' => 'HURTADO',
                'id_distrito' => '36',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            292 => 
            array (
                'id' => 300,
                'CORREGIMIENTO' => 'ISLA DE CAÑAS',
                'id_distrito' => '85',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            293 => 
            array (
                'id' => 301,
                'CORREGIMIENTO' => 'ISLA GRANDE',
                'id_distrito' => '65',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            294 => 
            array (
                'id' => 302,
                'CORREGIMIENTO' => 'ITURRALDE',
                'id_distrito' => '36',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            295 => 
            array (
                'id' => 303,
                'CORREGIMIENTO' => 'JADEBERI',
                'id_distrito' => '53',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            296 => 
            array (
                'id' => 304,
                'CORREGIMIENTO' => 'JAQUÉ',
                'id_distrito' => '21',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            297 => 
            array (
                'id' => 4,
                'CORREGIMIENTO' => 'JARAMILLO',
                'id_distrito' => '12',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            298 => 
            array (
                'id' => 5,
                'CORREGIMIENTO' => 'JINGURUDÓ',
                'id_distrito' => '69',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            299 => 
            array (
                'id' => 305,
                'CORREGIMIENTO' => 'JOSÉ DOMINGO ESPINAR',
                'id_distrito' => '74',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            300 => 
            array (
                'id' => 306,
                'CORREGIMIENTO' => 'JUAN D. AROSEMENA',
                'id_distrito' => '5',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            301 => 
            array (
                'id' => 307,
                'CORREGIMIENTO' => 'JUAN DÍAZ',
                'id_distrito' => '4',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            302 => 
            array (
                'id' => 308,
                'CORREGIMIENTO' => 'JUAN DÍAZ',
                'id_distrito' => '58',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            303 => 
            array (
                'id' => 309,
                'CORREGIMIENTO' => 'JUAY',
                'id_distrito' => '71',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            304 => 
            array (
                'id' => 310,
                'CORREGIMIENTO' => 'JUSTO FIDEL PALACIOS',
                'id_distrito' => '84',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            305 => 
            array (
                'id' => 311,
                'CORREGIMIENTO' => 'KANKINTÚ',
                'id_distrito' => '34',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            306 => 
            array (
                'id' => 312,
                'CORREGIMIENTO' => 'KIKARI',
                'id_distrito' => '48',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            307 => 
            array (
                'id' => 313,
                'CORREGIMIENTO' => 'KRÚA',
                'id_distrito' => '48',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            308 => 
            array (
                'id' => 314,
                'CORREGIMIENTO' => 'KUSAPÍN',
                'id_distrito' => '35',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            309 => 
            array (
                'id' => 315,
                'CORREGIMIENTO' => 'LA ARENA',
                'id_distrito' => '25',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            310 => 
            array (
                'id' => 316,
                'CORREGIMIENTO' => 'LA ARENA',
                'id_distrito' => '42',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            311 => 
            array (
                'id' => 317,
                'CORREGIMIENTO' => 'LA CARRILLO',
                'id_distrito' => '6',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            312 => 
            array (
                'id' => 318,
                'CORREGIMIENTO' => 'LA COLORADA',
                'id_distrito' => '43',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            313 => 
            array (
                'id' => 319,
                'CORREGIMIENTO' => 'LA COLORADA',
                'id_distrito' => '80',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            314 => 
            array (
                'id' => 320,
                'CORREGIMIENTO' => 'LA CONCEPCIÓN (CAB)',
                'id_distrito' => '13',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            315 => 
            array (
                'id' => 321,
                'CORREGIMIENTO' => 'LA ENCANTADA',
                'id_distrito' => '18',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            316 => 
            array (
                'id' => 322,
                'CORREGIMIENTO' => 'LA ENEA',
                'id_distrito' => '32',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            317 => 
            array (
                'id' => 323,
                'CORREGIMIENTO' => 'LA ENSENADA',
                'id_distrito' => '7',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            318 => 
            array (
                'id' => 324,
                'CORREGIMIENTO' => 'LA ERMITA',
                'id_distrito' => '70',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            319 => 
            array (
                'id' => 325,
                'CORREGIMIENTO' => 'LA ESMERALDA',
                'id_distrito' => '7',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            320 => 
            array (
                'id' => 326,
                'CORREGIMIENTO' => 'LA ESPIGADILLA',
                'id_distrito' => '43',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            321 => 
            array (
                'id' => 6,
                'CORREGIMIENTO' => 'LA ESTRELLA',
                'id_distrito' => '13',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            322 => 
            array (
                'id' => 327,
                'CORREGIMIENTO' => 'LA GARCEANA',
                'id_distrito' => '47',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            323 => 
            array (
                'id' => 328,
                'CORREGIMIENTO' => 'LA GLORIA',
                'id_distrito' => '20',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            324 => 
            array (
                'id' => 329,
                'CORREGIMIENTO' => 'LA GUINEA',
                'id_distrito' => '7',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            325 => 
            array (
                'id' => 330,
                'CORREGIMIENTO' => 'LA LAGUNA',
                'id_distrito' => '14',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            326 => 
            array (
                'id' => 331,
                'CORREGIMIENTO' => 'LA LAGUNA',
                'id_distrito' => '70',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            327 => 
            array (
                'id' => 332,
                'CORREGIMIENTO' => 'LA LAJA',
                'id_distrito' => '41',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            328 => 
            array (
                'id' => 333,
                'CORREGIMIENTO' => 'LA MESA',
                'id_distrito' => '44',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            329 => 
            array (
                'id' => 334,
                'CORREGIMIENTO' => 'LA MESA (CAB)',
                'id_distrito' => '37',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            330 => 
            array (
                'id' => 335,
                'CORREGIMIENTO' => 'LA MIEL',
                'id_distrito' => '41',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            331 => 
            array (
                'id' => 336,
                'CORREGIMIENTO' => 'LA MONTAÑUELA',
                'id_distrito' => '6',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            332 => 
            array (
                'id' => 337,
                'CORREGIMIENTO' => 'LA PALMA',
                'id_distrito' => '41',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            333 => 
            array (
                'id' => 338,
                'CORREGIMIENTO' => 'LA PALMA (CAB)',
                'id_distrito' => '21',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            334 => 
            array (
                'id' => 339,
                'CORREGIMIENTO' => 'LA PASERA',
                'id_distrito' => '32',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            335 => 
            array (
                'id' => 340,
                'CORREGIMIENTO' => 'LA PAVA',
                'id_distrito' => '56',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            336 => 
            array (
                'id' => 341,
                'CORREGIMIENTO' => 'LA PEÑA',
                'id_distrito' => '80',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            337 => 
            array (
                'id' => 342,
                'CORREGIMIENTO' => 'LA PINTADA (CAB)',
                'id_distrito' => '38',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            338 => 
            array (
                'id' => 343,
                'CORREGIMIENTO' => 'LA PITALOZA',
                'id_distrito' => '42',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            339 => 
            array (
                'id' => 344,
                'CORREGIMIENTO' => 'LA RAYA ',
                'id_distrito' => '14',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            340 => 
            array (
                'id' => 345,
                'CORREGIMIENTO' => 'LA RAYA DE SANTA MARÍA',
                'id_distrito' => '80',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            341 => 
            array (
                'id' => 346,
                'CORREGIMIENTO' => 'LA REPRESA',
                'id_distrito' => '36',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            342 => 
            array (
                'id' => 347,
                'CORREGIMIENTO' => 'LA SOLEDAD',
                'id_distrito' => '81',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            343 => 
            array (
                'id' => 348,
                'CORREGIMIENTO' => 'LA TETILLA',
                'id_distrito' => '14',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            344 => 
            array (
                'id' => 349,
                'CORREGIMIENTO' => 'LA TIZA',
                'id_distrito' => '41',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            345 => 
            array (
                'id' => 350,
                'CORREGIMIENTO' => 'LA TRINCHERA',
                'id_distrito' => '81',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            346 => 
            array (
                'id' => 351,
                'CORREGIMIENTO' => 'LA TRINIDAD',
                'id_distrito' => '16',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            347 => 
            array (
                'id' => 352,
                'CORREGIMIENTO' => 'LA TRONOSA',
                'id_distrito' => '85',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            348 => 
            array (
                'id' => 353,
                'CORREGIMIENTO' => 'LA VILLA DE LOS SANTOS',
                'id_distrito' => '43',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            349 => 
            array (
                'id' => 354,
                'CORREGIMIENTO' => 'LA YEGUADA',
                'id_distrito' => '14',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            350 => 
            array (
                'id' => 355,
                'CORREGIMIENTO' => 'LAJAMINAS',
                'id_distrito' => '64',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            351 => 
            array (
                'id' => 356,
                'CORREGIMIENTO' => 'LAJAS ADENTRO',
                'id_distrito' => '71',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            352 => 
            array (
                'id' => 357,
                'CORREGIMIENTO' => 'LAJAS BLANCA',
                'id_distrito' => '17',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            353 => 
            array (
                'id' => 358,
                'CORREGIMIENTO' => 'LAJAS DE TOLÉ',
                'id_distrito' => '84',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            354 => 
            array (
                'id' => 359,
                'CORREGIMIENTO' => 'LAJERO',
                'id_distrito' => '53',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            355 => 
            array (
                'id' => 360,
                'CORREGIMIENTO' => 'LAS CABRAS',
                'id_distrito' => '62',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            356 => 
            array (
                'id' => 361,
                'CORREGIMIENTO' => 'LAS CRUCES',
                'id_distrito' => '15',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            357 => 
            array (
                'id' => 362,
                'CORREGIMIENTO' => 'LAS CRUCES',
                'id_distrito' => '43',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            358 => 
            array (
                'id' => 363,
                'CORREGIMIENTO' => 'LAS CUMBRES',
                'id_distrito' => '58',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            359 => 
            array (
                'id' => 364,
                'CORREGIMIENTO' => 'LAS DELICIAS',
                'id_distrito' => '20',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            360 => 
            array (
                'id' => 365,
                'CORREGIMIENTO' => 'LAS GARZAS',
                'id_distrito' => '58',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            361 => 
            array (
                'id' => 366,
                'CORREGIMIENTO' => 'LAS GUABAS',
                'id_distrito' => '43',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            362 => 
            array (
                'id' => 367,
                'CORREGIMIENTO' => 'LAS GUÍAS',
                'id_distrito' => '14',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            363 => 
            array (
                'id' => 368,
                'CORREGIMIENTO' => 'LAS HUACAS',
                'id_distrito' => '52',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            364 => 
            array (
                'id' => 369,
                'CORREGIMIENTO' => 'LAS HUACAS',
                'id_distrito' => '68',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            365 => 
            array (
                'id' => 370,
                'CORREGIMIENTO' => 'LAS LAJAS',
                'id_distrito' => '19',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            366 => 
            array (
                'id' => 371,
                'CORREGIMIENTO' => 'LAS LAJAS (CAB)',
                'id_distrito' => '71',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            367 => 
            array (
                'id' => 372,
                'CORREGIMIENTO' => 'LAS LLANAS',
                'id_distrito' => '42',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            368 => 
            array (
                'id' => 373,
                'CORREGIMIENTO' => 'LAS LOMAS',
                'id_distrito' => '28',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            369 => 
            array (
                'id' => 374,
                'CORREGIMIENTO' => 'LAS LOMAS',
                'id_distrito' => '38',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            370 => 
            array (
                'id' => 375,
                'CORREGIMIENTO' => 'LAS MAÑANITAS',
                'id_distrito' => '58',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            371 => 
            array (
                'id' => 376,
                'CORREGIMIENTO' => 'LAS MARGARITAS',
                'id_distrito' => '22',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            372 => 
            array (
                'id' => 377,
                'CORREGIMIENTO' => 'LAS MINAS (CAB)',
                'id_distrito' => '39',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            373 => 
            array (
                'id' => 378,
                'CORREGIMIENTO' => 'LAS OLLAS ARRIBA',
                'id_distrito' => '16',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            374 => 
            array (
                'id' => 379,
                'CORREGIMIENTO' => 'LAS PALMAS',
                'id_distrito' => '44',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            375 => 
            array (
                'id' => 380,
                'CORREGIMIENTO' => 'LAS PALMAS (CAB)',
                'id_distrito' => '40',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            376 => 
            array (
                'id' => 381,
                'CORREGIMIENTO' => 'LAS PALMITAS',
                'id_distrito' => '41',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            377 => 
            array (
                'id' => 382,
                'CORREGIMIENTO' => 'LAS TABLAS',
                'id_distrito' => '20',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            378 => 
            array (
                'id' => 383,
                'CORREGIMIENTO' => 'LAS TABLAS (CAB)',
                'id_distrito' => '41',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            379 => 
            array (
                'id' => 384,
                'CORREGIMIENTO' => 'LAS TABLAS ABAJO',
                'id_distrito' => '41',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            380 => 
            array (
                'id' => 385,
                'CORREGIMIENTO' => 'LAS TRANCAS',
                'id_distrito' => '32',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            381 => 
            array (
                'id' => 386,
                'CORREGIMIENTO' => 'LAS UVAS',
                'id_distrito' => '70',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            382 => 
            array (
                'id' => 387,
                'CORREGIMIENTO' => 'LEONES',
                'id_distrito' => '39',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            383 => 
            array (
                'id' => 388,
                'CORREGIMIENTO' => 'LEONES',
                'id_distrito' => '47',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            384 => 
            array (
                'id' => 389,
                'CORREGIMIENTO' => 'LÍDICE',
                'id_distrito' => '16',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            385 => 
            array (
                'id' => 390,
                'CORREGIMIENTO' => 'LIMÓN',
                'id_distrito' => '27',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            386 => 
            array (
                'id' => 391,
                'CORREGIMIENTO' => 'LIMONES',
                'id_distrito' => '8',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            387 => 
            array (
                'id' => 7,
                'CORREGIMIENTO' => 'LLANO ABAJO',
                'id_distrito' => '32',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            388 => 
            array (
                'id' => 392,
                'CORREGIMIENTO' => 'LLANO BONITO',
                'id_distrito' => '25',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            389 => 
            array (
                'id' => 393,
                'CORREGIMIENTO' => 'LLANO DE CATIVAL',
                'id_distrito' => '45',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            390 => 
            array (
                'id' => 394,
                'CORREGIMIENTO' => 'LLANO DE LA CRUZ',
                'id_distrito' => '59',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            391 => 
            array (
                'id' => 395,
                'CORREGIMIENTO' => 'LLANO DE PIEDRA',
                'id_distrito' => '44',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            392 => 
            array (
                'id' => 396,
                'CORREGIMIENTO' => 'LLANO GRANDE',
                'id_distrito' => '37',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            393 => 
            array (
                'id' => 397,
                'CORREGIMIENTO' => 'LLANO GRANDE',
                'id_distrito' => '38',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            394 => 
            array (
                'id' => 398,
                'CORREGIMIENTO' => 'LLANO GRANDE',
                'id_distrito' => '55',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            395 => 
            array (
                'id' => 399,
                'CORREGIMIENTO' => 'LLANO LARGO',
                'id_distrito' => '43',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            396 => 
            array (
                'id' => 400,
                'CORREGIMIENTO' => 'LLANO NORTE',
                'id_distrito' => '38',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            397 => 
            array (
                'id' => 401,
                'CORREGIMIENTO' => 'LOLÁ ',
                'id_distrito' => '40',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            398 => 
            array (
                'id' => 402,
                'CORREGIMIENTO' => 'LOMA YUCA',
                'id_distrito' => '75',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            399 => 
            array (
                'id' => 403,
                'CORREGIMIENTO' => 'LOS ALGARROBOS',
                'id_distrito' => '29',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            400 => 
            array (
                'id' => 404,
                'CORREGIMIENTO' => 'LOS ALGARROBOS',
                'id_distrito' => '80',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            401 => 
            array (
                'id' => 405,
                'CORREGIMIENTO' => 'LOS ANASTACIOS ',
                'id_distrito' => '29',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            402 => 
            array (
                'id' => 406,
                'CORREGIMIENTO' => 'LOS ANGELES',
                'id_distrito' => '31',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            403 => 
            array (
                'id' => 407,
                'CORREGIMIENTO' => 'LOS ANGELES',
                'id_distrito' => '43',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            404 => 
            array (
                'id' => 408,
                'CORREGIMIENTO' => 'LOS ASIENTOS',
                'id_distrito' => '60',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            405 => 
            array (
                'id' => 409,
                'CORREGIMIENTO' => 'LOS CANELOS',
                'id_distrito' => '79',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            406 => 
            array (
                'id' => 410,
                'CORREGIMIENTO' => 'LOS CASTILLOS',
                'id_distrito' => '59',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            407 => 
            array (
                'id' => 411,
                'CORREGIMIENTO' => 'LOS CASTILLOS',
                'id_distrito' => '68',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            408 => 
            array (
                'id' => 412,
                'CORREGIMIENTO' => 'LOS CERRITOS',
                'id_distrito' => '42',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            409 => 
            array (
                'id' => 413,
                'CORREGIMIENTO' => 'LOS CERROS DE PAJA',
                'id_distrito' => '42',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            410 => 
            array (
                'id' => 414,
                'CORREGIMIENTO' => 'LOS DÍAZ',
                'id_distrito' => '36',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            411 => 
            array (
                'id' => 415,
                'CORREGIMIENTO' => 'LOS HATILLOS',
                'id_distrito' => '72',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            412 => 
            array (
                'id' => 416,
                'CORREGIMIENTO' => 'LOS LLANITOS',
                'id_distrito' => '70',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            413 => 
            array (
                'id' => 417,
                'CORREGIMIENTO' => 'LOS LLANOS',
                'id_distrito' => '55',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            414 => 
            array (
                'id' => 418,
                'CORREGIMIENTO' => 'LOS MILAGROS',
                'id_distrito' => '37',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            415 => 
            array (
                'id' => 419,
                'CORREGIMIENTO' => 'LOS NARANJOS',
                'id_distrito' => '12',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            416 => 
            array (
                'id' => 420,
                'CORREGIMIENTO' => 'LOS OLIVOS',
                'id_distrito' => '43',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            417 => 
            array (
                'id' => 421,
                'CORREGIMIENTO' => 'LOS POZOS (CAB)',
                'id_distrito' => '42',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            418 => 
            array (
                'id' => 422,
                'CORREGIMIENTO' => 'LOS VALLES',
                'id_distrito' => '15',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            419 => 
            array (
                'id' => 423,
                'CORREGIMIENTO' => 'MACARACAS (CAB)',
                'id_distrito' => '44',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            420 => 
            array (
                'id' => 424,
                'CORREGIMIENTO' => 'MANCREEK',
                'id_distrito' => '33',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            421 => 
            array (
                'id' => 425,
                'CORREGIMIENTO' => 'MANUEL E AMADOR TERRERO',
                'id_distrito' => '40',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            422 => 
            array (
                'id' => 426,
                'CORREGIMIENTO' => 'MANUEL ORTEGA',
                'id_distrito' => '17',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            423 => 
            array (
                'id' => 427,
                'CORREGIMIENTO' => 'MARACA',
                'id_distrito' => '48',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            424 => 
            array (
                'id' => 428,
                'CORREGIMIENTO' => 'MARÍA CHIQUITA',
                'id_distrito' => '65',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            425 => 
            array (
                'id' => 429,
                'CORREGIMIENTO' => 'MARIABÉ',
                'id_distrito' => '60',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            426 => 
            array (
                'id' => 430,
                'CORREGIMIENTO' => 'MATEO ITURRALDE',
                'id_distrito' => '74',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            427 => 
            array (
                'id' => 431,
                'CORREGIMIENTO' => 'MENCHACA',
                'id_distrito' => '55',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            428 => 
            array (
                'id' => 432,
                'CORREGIMIENTO' => 'MENDOZA',
                'id_distrito' => '36',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            429 => 
            array (
                'id' => 433,
                'CORREGIMIENTO' => 'METETÍ',
                'id_distrito' => '63',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            430 => 
            array (
                'id' => 434,
                'CORREGIMIENTO' => 'MIGUEL DE LA BORDA (CAB)',
                'id_distrito' => '30',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            431 => 
            array (
                'id' => 435,
                'CORREGIMIENTO' => 'MIRAMAR',
                'id_distrito' => '24',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            432 => 
            array (
                'id' => 436,
                'CORREGIMIENTO' => 'MIRAMAR',
                'id_distrito' => '78',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            433 => 
            array (
                'id' => 437,
                'CORREGIMIENTO' => 'MOGOLLÓN',
                'id_distrito' => '44',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            434 => 
            array (
                'id' => 438,
                'CORREGIMIENTO' => 'MONAGRILLO',
                'id_distrito' => '25',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            435 => 
            array (
                'id' => 8,
                'CORREGIMIENTO' => 'MONJARÁS',
                'id_distrito' => '14',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            436 => 
            array (
                'id' => 439,
                'CORREGIMIENTO' => 'MONTE LIRIO',
                'id_distrito' => '67',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            437 => 
            array (
                'id' => 440,
                'CORREGIMIENTO' => 'MONTIJO (CAB)',
                'id_distrito' => '47',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            438 => 
            array (
                'id' => 441,
                'CORREGIMIENTO' => 'MREENI',
                'id_distrito' => '48',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            439 => 
            array (
                'id' => 442,
                'CORREGIMIENTO' => 'MUNUNÍ',
                'id_distrito' => '34',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            440 => 
            array (
                'id' => 443,
                'CORREGIMIENTO' => 'NA',
                'id_distrito' => '17',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            441 => 
            array (
                'id' => 444,
                'CORREGIMIENTO' => 'NA',
                'id_distrito' => '57',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            442 => 
            array (
                'id' => 445,
                'CORREGIMIENTO' => 'NA',
                'id_distrito' => '69',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            443 => 
            array (
                'id' => 446,
                'CORREGIMIENTO' => 'NA',
                'id_distrito' => '82',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            444 => 
            array (
                'id' => 447,
                'CORREGIMIENTO' => 'NAMNONI',
                'id_distrito' => '9',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            445 => 
            array (
                'id' => 448,
                'CORREGIMIENTO' => 'NANCE DE RISCÓ',
                'id_distrito' => '3',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            446 => 
            array (
                'id' => 449,
                'CORREGIMIENTO' => 'NARGANÁ',
                'id_distrito' => '49',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            447 => 
            array (
                'id' => 450,
                'CORREGIMIENTO' => 'NATÁ (CAB)',
                'id_distrito' => '52',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            448 => 
            array (
                'id' => 451,
                'CORREGIMIENTO' => 'NIBA',
                'id_distrito' => '9',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            449 => 
            array (
                'id' => 452,
                'CORREGIMIENTO' => 'NIBRA',
                'id_distrito' => '48',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            450 => 
            array (
                'id' => 453,
                'CORREGIMIENTO' => 'NOMBRE DE DIOS',
                'id_distrito' => '78',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            451 => 
            array (
                'id' => 454,
                'CORREGIMIENTO' => 'NUARIO',
                'id_distrito' => '41',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            452 => 
            array (
                'id' => 455,
                'CORREGIMIENTO' => 'NUEVA CALIFORNIA',
                'id_distrito' => '83',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            453 => 
            array (
                'id' => 456,
                'CORREGIMIENTO' => 'NUEVA ESPERANZA',
                'id_distrito' => '26',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            454 => 
            array (
                'id' => 457,
                'CORREGIMIENTO' => 'NUEVA GORGONA',
                'id_distrito' => '19',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            455 => 
            array (
                'id' => 458,
                'CORREGIMIENTO' => 'NUEVA PROVIDENCIA',
                'id_distrito' => '27',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            456 => 
            array (
                'id' => 459,
                'CORREGIMIENTO' => 'NUEVO CHAGRES (CAB)',
                'id_distrito' => '18',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            457 => 
            array (
                'id' => 460,
                'CORREGIMIENTO' => 'NUEVO EMPERADOR',
                'id_distrito' => '5',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            458 => 
            array (
                'id' => 461,
                'CORREGIMIENTO' => 'NUEVO MÉXICO',
                'id_distrito' => '2',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            459 => 
            array (
                'id' => 462,
                'CORREGIMIENTO' => 'NUEVO SANTIAGO',
                'id_distrito' => '80',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            460 => 
            array (
                'id' => 463,
                'CORREGIMIENTO' => 'OBALDÍA',
                'id_distrito' => '36',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            461 => 
            array (
                'id' => 464,
                'CORREGIMIENTO' => 'OCÚ (CAB)',
                'id_distrito' => '55',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            462 => 
            array (
                'id' => 465,
                'CORREGIMIENTO' => 'OLÁ (CAB)',
                'id_distrito' => '56',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            463 => 
            array (
                'id' => 466,
                'CORREGIMIENTO' => 'OMAR TORRIJOS',
                'id_distrito' => '74',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            464 => 
            array (
                'id' => 467,
                'CORREGIMIENTO' => 'ORIA ARRIBA',
                'id_distrito' => '60',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            465 => 
            array (
                'id' => 468,
                'CORREGIMIENTO' => 'OTOQUE OCCIDENTE',
                'id_distrito' => '82',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            466 => 
            array (
                'id' => 469,
                'CORREGIMIENTO' => 'OTOQUE ORIENTE',
                'id_distrito' => '82',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            467 => 
            array (
                'id' => 470,
                'CORREGIMIENTO' => 'PACORA',
                'id_distrito' => '58',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            468 => 
            array (
                'id' => 471,
                'CORREGIMIENTO' => 'PAJA DE SOMBRERO',
                'id_distrito' => '31',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            469 => 
            array (
                'id' => 472,
                'CORREGIMIENTO' => 'PAJONAL',
                'id_distrito' => '61',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            470 => 
            array (
                'id' => 473,
                'CORREGIMIENTO' => 'PALENQUE (CAB)',
                'id_distrito' => '78',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            471 => 
            array (
                'id' => 474,
                'CORREGIMIENTO' => 'PALMAS BELLAS',
                'id_distrito' => '18',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            472 => 
            array (
                'id' => 475,
                'CORREGIMIENTO' => 'PALMIRA',
                'id_distrito' => '12',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            473 => 
            array (
                'id' => 476,
                'CORREGIMIENTO' => 'PALMIRA',
                'id_distrito' => '41',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            474 => 
            array (
                'id' => 477,
                'CORREGIMIENTO' => 'PALMIRA',
                'id_distrito' => '78',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            475 => 
            array (
                'id' => 478,
                'CORREGIMIENTO' => 'PALO GRANDE',
                'id_distrito' => '2',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            476 => 
            array (
                'id' => 479,
                'CORREGIMIENTO' => 'PARAÍSO',
                'id_distrito' => '11',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            477 => 
            array (
                'id' => 480,
                'CORREGIMIENTO' => 'PARAÍSO',
                'id_distrito' => '64',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            478 => 
            array (
                'id' => 481,
                'CORREGIMIENTO' => 'PARÍS',
                'id_distrito' => '59',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            479 => 
            array (
                'id' => 482,
                'CORREGIMIENTO' => 'PARITA (CAB)',
                'id_distrito' => '59',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            480 => 
            array (
                'id' => 483,
                'CORREGIMIENTO' => 'PARITILLA',
                'id_distrito' => '64',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            481 => 
            array (
                'id' => 484,
                'CORREGIMIENTO' => 'PARQUE LEFEVRE',
                'id_distrito' => '58',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            482 => 
            array (
                'id' => 485,
                'CORREGIMIENTO' => 'PÁSIGA',
                'id_distrito' => '23',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            483 => 
            array (
                'id' => 486,
                'CORREGIMIENTO' => 'PASO ANCHO',
                'id_distrito' => '83',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            484 => 
            array (
                'id' => 487,
                'CORREGIMIENTO' => 'PAYA',
                'id_distrito' => '63',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            485 => 
            array (
                'id' => 488,
                'CORREGIMIENTO' => 'PEDASÍ (CAB)',
                'id_distrito' => '60',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            486 => 
            array (
                'id' => 489,
                'CORREGIMIENTO' => 'PEDREGAL',
                'id_distrito' => '11',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            487 => 
            array (
                'id' => 490,
                'CORREGIMIENTO' => 'PEDREGAL',
                'id_distrito' => '28',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            488 => 
            array (
                'id' => 491,
                'CORREGIMIENTO' => 'PEDREGAL',
                'id_distrito' => '58',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            489 => 
            array (
                'id' => 492,
                'CORREGIMIENTO' => 'PEDRO GONZÁLEZ',
                'id_distrito' => '7',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            490 => 
            array (
                'id' => 493,
                'CORREGIMIENTO' => 'PENONOMÉ (CAB)',
                'id_distrito' => '61',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            491 => 
            array (
                'id' => 494,
                'CORREGIMIENTO' => 'PEÑA BLANCA',
                'id_distrito' => '41',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            492 => 
            array (
                'id' => 495,
                'CORREGIMIENTO' => 'PEÑA BLANCA',
                'id_distrito' => '48',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            493 => 
            array (
                'id' => 496,
                'CORREGIMIENTO' => 'PEÑAS CHATAS',
                'id_distrito' => '55',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            494 => 
            array (
                'id' => 497,
                'CORREGIMIENTO' => 'PERALES',
                'id_distrito' => '32',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            495 => 
            array (
                'id' => 498,
                'CORREGIMIENTO' => 'PESÉ (CAB)',
                'id_distrito' => '62',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            496 => 
            array (
                'id' => 499,
                'CORREGIMIENTO' => 'PIEDRA ROJA',
                'id_distrito' => '34',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            497 => 
            array (
                'id' => 500,
                'CORREGIMIENTO' => 'PIEDRAS GORDAS',
                'id_distrito' => '38',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            498 => 
            array (
                'id' => 501,
                'CORREGIMIENTO' => 'PILÓN',
                'id_distrito' => '47',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            499 => 
            array (
                'id' => 502,
                'CORREGIMIENTO' => 'PINOGANA',
                'id_distrito' => '63',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            500 => 
            array (
                'id' => 503,
                'CORREGIMIENTO' => 'PIÑA',
                'id_distrito' => '18',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            501 => 
            array (
                'id' => 504,
                'CORREGIMIENTO' => 'PIXVAE',
                'id_distrito' => '40',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            502 => 
            array (
                'id' => 505,
                'CORREGIMIENTO' => 'PLAYA CHIQUITA',
                'id_distrito' => '78',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            503 => 
            array (
                'id' => 506,
                'CORREGIMIENTO' => 'PLAYA LEONA',
                'id_distrito' => '36',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            504 => 
            array (
                'id' => 507,
                'CORREGIMIENTO' => 'PLAZA DE CAISÁN',
                'id_distrito' => '67',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            505 => 
            array (
                'id' => 508,
                'CORREGIMIENTO' => 'POCRÍ',
                'id_distrito' => '1',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            506 => 
            array (
                'id' => 509,
                'CORREGIMIENTO' => 'POCRÍ (CAB)',
                'id_distrito' => '64',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            507 => 
            array (
                'id' => 510,
                'CORREGIMIENTO' => 'PONUGA',
                'id_distrito' => '80',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            508 => 
            array (
                'id' => 511,
                'CORREGIMIENTO' => 'PORTOBELILLO',
                'id_distrito' => '59',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            509 => 
            array (
                'id' => 512,
                'CORREGIMIENTO' => 'PORTOBELO (CAB)',
                'id_distrito' => '65',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            510 => 
            array (
                'id' => 513,
                'CORREGIMIENTO' => 'POTRERILLOS',
                'id_distrito' => '29',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            511 => 
            array (
                'id' => 514,
                'CORREGIMIENTO' => 'POTRERILLOS ABAJO',
                'id_distrito' => '29',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            512 => 
            array (
                'id' => 515,
                'CORREGIMIENTO' => 'POTRERO DE CAÑA',
                'id_distrito' => '84',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            513 => 
            array (
                'id' => 516,
                'CORREGIMIENTO' => 'POTUGA',
                'id_distrito' => '59',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            514 => 
            array (
                'id' => 517,
                'CORREGIMIENTO' => 'PROGRESO',
                'id_distrito' => '8',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            515 => 
            array (
                'id' => 518,
                'CORREGIMIENTO' => 'PÚCURO',
                'id_distrito' => '63',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            516 => 
            array (
                'id' => 519,
                'CORREGIMIENTO' => 'PUEBLO NUEVO',
                'id_distrito' => '58',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            517 => 
            array (
                'id' => 520,
                'CORREGIMIENTO' => 'PUEBLOS UNIDOS',
                'id_distrito' => '1',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            518 => 
            array (
                'id' => 521,
                'CORREGIMIENTO' => 'PUERTO ARMUELLES (CAB)',
                'id_distrito' => '8',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            519 => 
            array (
                'id' => 522,
                'CORREGIMIENTO' => 'PUERTO CAIMITO',
                'id_distrito' => '36',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            520 => 
            array (
                'id' => 523,
                'CORREGIMIENTO' => 'PUERTO OBALDÍA',
                'id_distrito' => '49',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            521 => 
            array (
                'id' => 524,
                'CORREGIMIENTO' => 'PUERTO PILÓN',
                'id_distrito' => '27',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            522 => 
            array (
                'id' => 525,
                'CORREGIMIENTO' => 'PUERTO PIÑA',
                'id_distrito' => '21',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            523 => 
            array (
                'id' => 526,
                'CORREGIMIENTO' => 'PUERTO VIDAL',
                'id_distrito' => '40',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            524 => 
            array (
                'id' => 527,
                'CORREGIMIENTO' => 'PUNTA CHAME',
                'id_distrito' => '19',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            525 => 
            array (
                'id' => 528,
                'CORREGIMIENTO' => 'PUNTA LAUREL',
                'id_distrito' => '10',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            526 => 
            array (
                'id' => 529,
                'CORREGIMIENTO' => 'PUNTA PEÑA',
                'id_distrito' => '24',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            527 => 
            array (
                'id' => 530,
                'CORREGIMIENTO' => 'PUNTA RÓBALO',
                'id_distrito' => '24',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            528 => 
            array (
                'id' => 531,
                'CORREGIMIENTO' => 'PÚRIO',
                'id_distrito' => '60',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            529 => 
            array (
                'id' => 532,
                'CORREGIMIENTO' => 'QUEBRADA DE LORO',
                'id_distrito' => '46',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            530 => 
            array (
                'id' => 533,
                'CORREGIMIENTO' => 'QUEBRADA DE ORO',
                'id_distrito' => '81',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            531 => 
            array (
                'id' => 534,
                'CORREGIMIENTO' => 'QUEBRADA DE PIEDRA',
                'id_distrito' => '84',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            532 => 
            array (
                'id' => 535,
                'CORREGIMIENTO' => 'QUEBRADA DEL ROSARIO',
                'id_distrito' => '39',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            533 => 
            array (
                'id' => 536,
                'CORREGIMIENTO' => 'QUEBRO',
                'id_distrito' => '45',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            534 => 
            array (
                'id' => 537,
                'CORREGIMIENTO' => 'QUERÉVALO',
                'id_distrito' => '2',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            535 => 
            array (
                'id' => 538,
                'CORREGIMIENTO' => 'RAMBALA',
                'id_distrito' => '24',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            536 => 
            array (
                'id' => 539,
                'CORREGIMIENTO' => 'REMANCE',
                'id_distrito' => '72',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            537 => 
            array (
                'id' => 540,
                'CORREGIMIENTO' => 'REMEDIOS (CAB)',
                'id_distrito' => '66',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            538 => 
            array (
                'id' => 541,
                'CORREGIMIENTO' => 'RINCÓN',
                'id_distrito' => '31',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            539 => 
            array (
                'id' => 542,
                'CORREGIMIENTO' => 'RINCÓN HONDO',
                'id_distrito' => '62',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            540 => 
            array (
                'id' => 543,
                'CORREGIMIENTO' => 'RÍO ABAJO',
                'id_distrito' => '58',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            541 => 
            array (
                'id' => 544,
                'CORREGIMIENTO' => 'RÍO CHIRIQUÍ',
                'id_distrito' => '35',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            542 => 
            array (
                'id' => 545,
                'CORREGIMIENTO' => 'RÍO CONGO',
                'id_distrito' => '76',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            543 => 
            array (
                'id' => 546,
                'CORREGIMIENTO' => 'RÍO CONGO ARRIBA',
                'id_distrito' => '76',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            544 => 
            array (
                'id' => 547,
                'CORREGIMIENTO' => 'RÍO DE JESÚS (CAB)',
                'id_distrito' => '68',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            545 => 
            array (
                'id' => 548,
                'CORREGIMIENTO' => 'RÍO GRANDE',
                'id_distrito' => '61',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            546 => 
            array (
                'id' => 549,
                'CORREGIMIENTO' => 'RÍO GRANDE',
                'id_distrito' => '81',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            547 => 
            array (
                'id' => 550,
                'CORREGIMIENTO' => 'RÍO HATO',
                'id_distrito' => '4',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            548 => 
            array (
                'id' => 551,
                'CORREGIMIENTO' => 'RÍO HONDO',
                'id_distrito' => '41',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            549 => 
            array (
                'id' => 552,
                'CORREGIMIENTO' => 'RÍO IGLESIAS',
                'id_distrito' => '76',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            550 => 
            array (
                'id' => 553,
                'CORREGIMIENTO' => 'RÍO INDIO',
                'id_distrito' => '30',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            551 => 
            array (
                'id' => 554,
                'CORREGIMIENTO' => 'RÍO INDIO',
                'id_distrito' => '61',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            552 => 
            array (
                'id' => 555,
                'CORREGIMIENTO' => 'RÍO LUIS',
                'id_distrito' => '77',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            553 => 
            array (
                'id' => 556,
                'CORREGIMIENTO' => 'RÍO SÁBALO',
                'id_distrito' => '69',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            554 => 
            array (
                'id' => 557,
                'CORREGIMIENTO' => 'RÍO SERENO (CAB)',
                'id_distrito' => '67',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            555 => 
            array (
                'id' => 558,
                'CORREGIMIENTO' => 'RODEO VIEJO',
                'id_distrito' => '81',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            556 => 
            array (
                'id' => 559,
                'CORREGIMIENTO' => 'RODOLFO AGUILAR DELGADO',
                'id_distrito' => '8',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            557 => 
            array (
                'id' => 560,
                'CORREGIMIENTO' => 'RODRIGO LUQUE',
                'id_distrito' => '80',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            558 => 
            array (
                'id' => 561,
                'CORREGIMIENTO' => 'ROKARI',
                'id_distrito' => '48',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            559 => 
            array (
                'id' => 562,
                'CORREGIMIENTO' => 'ROVIRA',
                'id_distrito' => '29',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            560 => 
            array (
                'id' => 9,
                'CORREGIMIENTO' => 'RUBÉN CANTÚ',
                'id_distrito' => '77',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            561 => 
            array (
                'id' => 563,
                'CORREGIMIENTO' => 'RUFINA ALFARO',
                'id_distrito' => '74',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            562 => 
            array (
                'id' => 564,
                'CORREGIMIENTO' => 'SÁBANA GRANDE',
                'id_distrito' => '43',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            563 => 
            array (
                'id' => 565,
                'CORREGIMIENTO' => 'SÁBANA GRANDE',
                'id_distrito' => '62',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            564 => 
            array (
                'id' => 566,
                'CORREGIMIENTO' => 'SABANITAS',
                'id_distrito' => '27',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            565 => 
            array (
                'id' => 567,
                'CORREGIMIENTO' => 'SABOGA',
                'id_distrito' => '7',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            566 => 
            array (
                'id' => 568,
                'CORREGIMIENTO' => 'SAJALICES',
                'id_distrito' => '19',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            567 => 
            array (
                'id' => 569,
                'CORREGIMIENTO' => 'SALAMANCA',
                'id_distrito' => '27',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            568 => 
            array (
                'id' => 570,
                'CORREGIMIENTO' => 'SALTO DUPI',
                'id_distrito' => '46',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            569 => 
            array (
                'id' => 571,
                'CORREGIMIENTO' => 'SALUD',
                'id_distrito' => '18',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            570 => 
            array (
                'id' => 572,
                'CORREGIMIENTO' => 'SAMBOA',
                'id_distrito' => '33',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            571 => 
            array (
                'id' => 573,
                'CORREGIMIENTO' => 'SAMBÚ',
                'id_distrito' => '21',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            572 => 
            array (
                'id' => 574,
                'CORREGIMIENTO' => 'SAN ANDRÉS',
                'id_distrito' => '13',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            573 => 
            array (
                'id' => 575,
                'CORREGIMIENTO' => 'SAN ANTONIO',
                'id_distrito' => '6',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            574 => 
            array (
                'id' => 576,
                'CORREGIMIENTO' => 'SAN BARTOLO',
                'id_distrito' => '37',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            575 => 
            array (
                'id' => 577,
                'CORREGIMIENTO' => 'SAN CARLOS',
                'id_distrito' => '28',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            576 => 
            array (
                'id' => 578,
                'CORREGIMIENTO' => 'SAN CARLOS (CAB)',
                'id_distrito' => '70',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            577 => 
            array (
                'id' => 579,
                'CORREGIMIENTO' => 'SAN FELIPE',
                'id_distrito' => '58',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            578 => 
            array (
                'id' => 580,
                'CORREGIMIENTO' => 'SAN FÉLIX',
                'id_distrito' => '71',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            579 => 
            array (
                'id' => 581,
                'CORREGIMIENTO' => 'SAN FRANCISCO',
                'id_distrito' => '58',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            580 => 
            array (
                'id' => 582,
                'CORREGIMIENTO' => 'SAN FRANCISCO (CAB)',
                'id_distrito' => '72',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            581 => 
            array (
                'id' => 583,
                'CORREGIMIENTO' => 'SAN ISIDRO',
                'id_distrito' => '13',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            582 => 
            array (
                'id' => 584,
                'CORREGIMIENTO' => 'SAN JOSÉ',
                'id_distrito' => '14',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            583 => 
            array (
                'id' => 585,
                'CORREGIMIENTO' => 'SAN JOSÉ',
                'id_distrito' => '15',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            584 => 
            array (
                'id' => 586,
                'CORREGIMIENTO' => 'SAN JOSÉ',
                'id_distrito' => '41',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            585 => 
            array (
                'id' => 587,
                'CORREGIMIENTO' => 'SAN JOSÉ',
                'id_distrito' => '70',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            586 => 
            array (
                'id' => 588,
                'CORREGIMIENTO' => 'SAN JOSÉ',
                'id_distrito' => '72',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            587 => 
            array (
                'id' => 589,
                'CORREGIMIENTO' => 'SAN JOSÉ DEL GENERAL',
                'id_distrito' => '26',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            588 => 
            array (
                'id' => 590,
                'CORREGIMIENTO' => 'SAN JUAN',
                'id_distrito' => '27',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            589 => 
            array (
                'id' => 591,
                'CORREGIMIENTO' => 'SAN JUAN',
                'id_distrito' => '72',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            590 => 
            array (
                'id' => 592,
                'CORREGIMIENTO' => 'SAN JUAN',
                'id_distrito' => '73',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            591 => 
            array (
                'id' => 593,
                'CORREGIMIENTO' => 'SAN JUAN BAUTISTA',
                'id_distrito' => '25',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            592 => 
            array (
                'id' => 594,
                'CORREGIMIENTO' => 'SAN JUAN DE DIOS',
                'id_distrito' => '4',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            593 => 
            array (
                'id' => 595,
                'CORREGIMIENTO' => 'SAN JUAN DE TURBE',
                'id_distrito' => '26',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            594 => 
            array (
                'id' => 596,
                'CORREGIMIENTO' => 'SAN LORENZO',
                'id_distrito' => '73',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            595 => 
            array (
                'id' => 597,
                'CORREGIMIENTO' => 'SAN MARCELO',
                'id_distrito' => '15',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            596 => 
            array (
                'id' => 598,
                'CORREGIMIENTO' => 'SAN MARTÍN',
                'id_distrito' => '58',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            597 => 
            array (
                'id' => 599,
                'CORREGIMIENTO' => 'SAN MARTÍN DE PORRES',
                'id_distrito' => '40',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            598 => 
            array (
                'id' => 600,
                'CORREGIMIENTO' => 'SAN MARTÍN DE PORRES',
                'id_distrito' => '80',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            599 => 
            array (
                'id' => 601,
                'CORREGIMIENTO' => 'SAN MIGUEL',
                'id_distrito' => '41',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            600 => 
            array (
                'id' => 602,
                'CORREGIMIENTO' => 'SAN MIGUEL (CAB)',
                'id_distrito' => '7',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            601 => 
            array (
                'id' => 603,
                'CORREGIMIENTO' => 'SAN PABLO NUEVO',
                'id_distrito' => '28',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            602 => 
            array (
                'id' => 604,
                'CORREGIMIENTO' => 'SAN PABLO VIEJO',
                'id_distrito' => '28',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            603 => 
            array (
                'id' => 605,
                'CORREGIMIENTO' => 'SAN PEDRITO (JIKUI)',
                'id_distrito' => '75',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            604 => 
            array (
                'id' => 606,
                'CORREGIMIENTO' => 'SAN PEDRO DEL ESPINO',
                'id_distrito' => '80',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            605 => 
            array (
                'id' => 607,
                'CORREGIMIENTO' => 'SANTA ANA',
                'id_distrito' => '43',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            606 => 
            array (
                'id' => 608,
                'CORREGIMIENTO' => 'SANTA ANA',
                'id_distrito' => '58',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            607 => 
            array (
                'id' => 609,
                'CORREGIMIENTO' => 'SANTA CATALINA O CALOVÉBORA',
                'id_distrito' => '75',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            608 => 
            array (
                'id' => 610,
                'CORREGIMIENTO' => 'SANTA CLARA',
                'id_distrito' => '5',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            609 => 
            array (
                'id' => 611,
                'CORREGIMIENTO' => 'SANTA CLARA',
                'id_distrito' => '67',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            610 => 
            array (
                'id' => 612,
                'CORREGIMIENTO' => 'SANTA CRUZ',
                'id_distrito' => '67',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            611 => 
            array (
                'id' => 613,
                'CORREGIMIENTO' => 'SANTA CRUZ',
                'id_distrito' => '71',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            612 => 
            array (
                'id' => 614,
                'CORREGIMIENTO' => 'SANTA CRUZ DE CHININA',
                'id_distrito' => '22',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            613 => 
            array (
                'id' => 615,
                'CORREGIMIENTO' => 'SANTA FÉ',
                'id_distrito' => '76',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            614 => 
            array (
                'id' => 616,
                'CORREGIMIENTO' => 'SANTA FE (CAB)',
                'id_distrito' => '77',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            615 => 
            array (
                'id' => 617,
                'CORREGIMIENTO' => 'SANTA ISABEL',
                'id_distrito' => '78',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            616 => 
            array (
                'id' => 618,
                'CORREGIMIENTO' => 'SANTA LUCÍA',
                'id_distrito' => '66',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            617 => 
            array (
                'id' => 619,
                'CORREGIMIENTO' => 'SANTA MARÍA (CAB)',
                'id_distrito' => '79',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            618 => 
            array (
                'id' => 620,
                'CORREGIMIENTO' => 'SANTA MARTA',
                'id_distrito' => '13',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            619 => 
            array (
                'id' => 621,
                'CORREGIMIENTO' => 'SANTA RITA',
                'id_distrito' => '4',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            620 => 
            array (
                'id' => 622,
                'CORREGIMIENTO' => 'SANTA RITA',
                'id_distrito' => '36',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            621 => 
            array (
                'id' => 623,
                'CORREGIMIENTO' => 'SANTA ROSA',
                'id_distrito' => '13',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            622 => 
            array (
                'id' => 624,
                'CORREGIMIENTO' => 'SANTA ROSA',
                'id_distrito' => '16',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            623 => 
            array (
                'id' => 625,
                'CORREGIMIENTO' => 'SANTA ROSA',
                'id_distrito' => '27',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            624 => 
            array (
                'id' => 626,
                'CORREGIMIENTO' => 'SANTIAGO (CAB)',
                'id_distrito' => '80',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            625 => 
            array (
                'id' => 627,
                'CORREGIMIENTO' => 'SANTIAGO ESTE',
                'id_distrito' => '80',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            626 => 
            array (
                'id' => 628,
                'CORREGIMIENTO' => 'SANTIAGO SUR',
                'id_distrito' => '80',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            627 => 
            array (
                'id' => 629,
                'CORREGIMIENTO' => 'SANTO DOMINGO',
                'id_distrito' => '13',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            628 => 
            array (
                'id' => 630,
                'CORREGIMIENTO' => 'SANTO DOMINGO',
                'id_distrito' => '41',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            629 => 
            array (
                'id' => 631,
                'CORREGIMIENTO' => 'SANTO TOMÁS',
                'id_distrito' => '2',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            630 => 
            array (
                'id' => 632,
                'CORREGIMIENTO' => 'SETEGANTÍ',
                'id_distrito' => '21',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            631 => 
            array (
                'id' => 633,
                'CORREGIMIENTO' => 'SITIO PRADO',
                'id_distrito' => '48',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            632 => 
            array (
                'id' => 634,
                'CORREGIMIENTO' => 'SOLANO',
                'id_distrito' => '13',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            633 => 
            array (
                'id' => 635,
                'CORREGIMIENTO' => 'SOLOY',
                'id_distrito' => '9',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            634 => 
            array (
                'id' => 636,
                'CORREGIMIENTO' => 'SONÁ (CAB)',
                'id_distrito' => '81',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            635 => 
            array (
                'id' => 637,
                'CORREGIMIENTO' => 'SORÁ',
                'id_distrito' => '19',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            636 => 
            array (
                'id' => 638,
                'CORREGIMIENTO' => 'SORTOVÁ',
                'id_distrito' => '13',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            637 => 
            array (
                'id' => 639,
                'CORREGIMIENTO' => 'SUSAMÁ',
                'id_distrito' => '53',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            638 => 
            array (
                'id' => 10,
                'CORREGIMIENTO' => 'TABOGA (CAB)',
                'id_distrito' => '82',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            639 => 
            array (
                'id' => 640,
                'CORREGIMIENTO' => 'TAIMATÍ',
                'id_distrito' => '21',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            640 => 
            array (
                'id' => 641,
                'CORREGIMIENTO' => 'TEBARIO',
                'id_distrito' => '45',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            641 => 
            array (
                'id' => 642,
                'CORREGIMIENTO' => 'TIERRA OSCURA',
                'id_distrito' => '10',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            642 => 
            array (
                'id' => 643,
                'CORREGIMIENTO' => 'TIJERAS',
                'id_distrito' => '11',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            643 => 
            array (
                'id' => 644,
                'CORREGIMIENTO' => 'TINAJAS',
                'id_distrito' => '29',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            644 => 
            array (
                'id' => 645,
                'CORREGIMIENTO' => 'TOABRÉ',
                'id_distrito' => '61',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            645 => 
            array (
                'id' => 646,
                'CORREGIMIENTO' => 'TOBOBE',
                'id_distrito' => '35',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            646 => 
            array (
                'id' => 647,
                'CORREGIMIENTO' => 'TOCUMEN',
                'id_distrito' => '58',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            647 => 
            array (
                'id' => 648,
                'CORREGIMIENTO' => 'TOLÉ (CAB)',
                'id_distrito' => '84',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            648 => 
            array (
                'id' => 649,
                'CORREGIMIENTO' => 'TOLOTE',
                'id_distrito' => '34',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            649 => 
            array (
                'id' => 650,
                'CORREGIMIENTO' => 'TONOSÍ (CAB)',
                'id_distrito' => '85',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            650 => 
            array (
                'id' => 651,
                'CORREGIMIENTO' => 'TORTÍ',
                'id_distrito' => '22',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            651 => 
            array (
                'id' => 652,
                'CORREGIMIENTO' => 'TOZA',
                'id_distrito' => '52',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            652 => 
            array (
                'id' => 653,
                'CORREGIMIENTO' => 'TRES QUEBRADAS',
                'id_distrito' => '43',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            653 => 
            array (
                'id' => 654,
                'CORREGIMIENTO' => 'TU GWAI',
                'id_distrito' => '33',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            654 => 
            array (
                'id' => 655,
                'CORREGIMIENTO' => 'TUBUALÁ',
                'id_distrito' => '49',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            655 => 
            array (
                'id' => 656,
                'CORREGIMIENTO' => 'TUCUTÍ',
                'id_distrito' => '21',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            656 => 
            array (
                'id' => 657,
                'CORREGIMIENTO' => 'TULÚ',
                'id_distrito' => '61',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            657 => 
            array (
                'id' => 658,
                'CORREGIMIENTO' => 'UMANI',
                'id_distrito' => '48',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            658 => 
            array (
                'id' => 659,
                'CORREGIMIENTO' => 'UNIÓN DEL NORTE',
                'id_distrito' => '47',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            659 => 
            array (
                'id' => 660,
                'CORREGIMIENTO' => 'UNIÓN SANTEÑA',
                'id_distrito' => '23',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            660 => 
            array (
                'id' => 661,
                'CORREGIMIENTO' => 'URRACÁ',
                'id_distrito' => '80',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            661 => 
            array (
                'id' => 662,
                'CORREGIMIENTO' => 'UTIRA',
                'id_distrito' => '68',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            662 => 
            array (
                'id' => 663,
                'CORREGIMIENTO' => 'VALLE BONITO (DOGATA)',
                'id_distrito' => '75',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            663 => 
            array (
                'id' => 664,
                'CORREGIMIENTO' => 'VALLE DE AGUA ARRIBA',
                'id_distrito' => '3',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            664 => 
            array (
                'id' => 665,
                'CORREGIMIENTO' => 'VALLE DEL RISCO',
                'id_distrito' => '3',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            665 => 
            array (
                'id' => 666,
                'CORREGIMIENTO' => 'VALLE RICO',
                'id_distrito' => '41',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            666 => 
            array (
                'id' => 667,
                'CORREGIMIENTO' => 'VALLERRIQUITO',
                'id_distrito' => '41',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            667 => 
            array (
                'id' => 668,
                'CORREGIMIENTO' => 'VELADERO',
                'id_distrito' => '84',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            668 => 
            array (
                'id' => 669,
                'CORREGIMIENTO' => 'VERACRUZ',
                'id_distrito' => '5',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            669 => 
            array (
                'id' => 670,
                'CORREGIMIENTO' => 'VICTORIANO LORENZO',
                'id_distrito' => '74',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            670 => 
            array (
                'id' => 671,
                'CORREGIMIENTO' => 'VIENTO FRÍO',
                'id_distrito' => '78',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            671 => 
            array (
                'id' => 672,
                'CORREGIMIENTO' => 'VIGUÍ',
                'id_distrito' => '40',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            672 => 
            array (
                'id' => 673,
                'CORREGIMIENTO' => 'VILLA CARMEN',
                'id_distrito' => '16',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            673 => 
            array (
                'id' => 674,
                'CORREGIMIENTO' => 'VILLA LOURDES',
                'id_distrito' => '43',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            674 => 
            array (
                'id' => 675,
                'CORREGIMIENTO' => 'VILLA ROSARIO',
                'id_distrito' => '16',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            675 => 
            array (
                'id' => 676,
                'CORREGIMIENTO' => 'VILLARREAL',
                'id_distrito' => '52',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            676 => 
            array (
                'id' => 677,
                'CORREGIMIENTO' => 'VIRGEN DEL CARMEN',
                'id_distrito' => '1',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            677 => 
            array (
                'id' => 678,
                'CORREGIMIENTO' => 'VISTA ALEGRE',
                'id_distrito' => '5',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            678 => 
            array (
                'id' => 679,
                'CORREGIMIENTO' => 'VOLCÁN',
                'id_distrito' => '83',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            679 => 
            array (
                'id' => 680,
                'CORREGIMIENTO' => 'YAPE',
                'id_distrito' => '63',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            680 => 
            array (
                'id' => 681,
                'CORREGIMIENTO' => 'YAVIZA',
                'id_distrito' => '63',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            681 => 
            array (
                'id' => 682,
                'CORREGIMIENTO' => 'ZAPALLAL',
                'id_distrito' => '76',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            682 => 
            array (
                'id' => 683,
                'CORREGIMIENTO' => 'ZAPOTILLO',
                'id_distrito' => '40',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
        ));
    }
}
