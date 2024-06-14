<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class usr_nacionalidad extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   DB::table('usr_nacionalidad')->delete();
        DB::table('usr_nacionalidad')->insert(array (
            0 => 
            array (
                'id' => 1,
                'pais' => 'AFGANISTÁN',
                'nacionalidad' => 'AFGANA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            1 => 
            array (
                'id' => 2,
                'pais' => 'ALEMANIA',
                'nacionalidad' => 'ALEMANA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            2 => 
            array (
                'id' => 3,
                'pais' => 'ARABIA SAUDITA',
                'nacionalidad' => 'ÁRABE',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            3 => 
            array (
                'id' => 4,
                'pais' => 'ARGENTINA',
                'nacionalidad' => 'ARGENTINA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            4 => 
            array (
                'id' => 5,
                'pais' => 'AUSTRALIA',
                'nacionalidad' => 'AUSTRALIANA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            5 => 
            array (
                'id' => 6,
                'pais' => 'BÉLGICA',
                'nacionalidad' => 'BELGA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            6 => 
            array (
                'id' => 7,
                'pais' => 'BOLIVIA',
                'nacionalidad' => 'BOLIVIANA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            7 => 
            array (
                'id' => 8,
                'pais' => 'BRASIL',
                'nacionalidad' => 'BRASILEÑA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            8 => 
            array (
                'id' => 9,
                'pais' => 'CAMBOYA',
                'nacionalidad' => 'CAMBOYANA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            9 => 
            array (
                'id' => 10,
                'pais' => 'CANADÁ',
                'nacionalidad' => 'CANADIENSE',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            10 => 
            array (
                'id' => 11,
                'pais' => 'CHILE',
                'nacionalidad' => 'CHILENA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            11 => 
            array (
                'id' => 12,
                'pais' => 'CHINA',
                'nacionalidad' => 'CHINA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            12 => 
            array (
                'id' => 13,
                'pais' => 'COLOMBIA',
                'nacionalidad' => 'COLOMBIANA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            13 => 
            array (
                'id' => 14,
                'pais' => 'COREA',
                'nacionalidad' => 'COREANA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            14 => 
            array (
                'id' => 15,
                'pais' => 'COSTA RICA',
                'nacionalidad' => 'COSTARRICENSE',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            15 => 
            array (
                'id' => 16,
                'pais' => 'CUBA',
                'nacionalidad' => 'CUBANA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            16 => 
            array (
                'id' => 17,
                'pais' => 'DINAMARCA',
                'nacionalidad' => 'DANESA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            17 => 
            array (
                'id' => 18,
                'pais' => 'ECUADOR',
                'nacionalidad' => 'ECUATORIANA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            18 => 
            array (
                'id' => 19,
                'pais' => 'EGIPTO',
                'nacionalidad' => 'EGIPCIA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            19 => 
            array (
                'id' => 20,
                'pais' => 'EL SALVADOR',
                'nacionalidad' => 'SALVADOREÑA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            20 => 
            array (
                'id' => 21,
                'pais' => 'ESCOCIA',
                'nacionalidad' => 'ESCOCESA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            21 => 
            array (
                'id' => 22,
                'pais' => 'ESPAÑA',
                'nacionalidad' => 'ESPAÑOLA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            22 => 
            array (
                'id' => 23,
                'pais' => 'ESTADOS UNIDOS',
                'nacionalidad' => 'ESTADOUNIDENSE',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            23 => 
            array (
                'id' => 24,
                'pais' => 'ESTONIA',
                'nacionalidad' => 'ESTONIA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            24 => 
            array (
                'id' => 25,
                'pais' => 'ETIOPIA',
                'nacionalidad' => 'ETIOPE',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            25 => 
            array (
                'id' => 26,
                'pais' => 'FILIPINAS',
                'nacionalidad' => 'FILIPINA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            26 => 
            array (
                'id' => 27,
                'pais' => 'FINLANDIA',
                'nacionalidad' => 'FINLANDESA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            27 => 
            array (
                'id' => 28,
                'pais' => 'FRANCIA',
                'nacionalidad' => 'FRANCESA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            28 => 
            array (
                'id' => 29,
                'pais' => 'GALES',
                'nacionalidad' => 'GALESA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            29 => 
            array (
                'id' => 30,
                'pais' => 'GRECIA',
                'nacionalidad' => 'GRIEGA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            30 => 
            array (
                'id' => 31,
                'pais' => 'GUATEMALA',
                'nacionalidad' => 'GUATEMALTECA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            31 => 
            array (
                'id' => 32,
                'pais' => 'HAITÍ',
                'nacionalidad' => 'HAITIANA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            32 => 
            array (
                'id' => 33,
                'pais' => 'HOLANDA',
                'nacionalidad' => 'HOLANDESA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            33 => 
            array (
                'id' => 34,
                'pais' => 'HONDURAS',
                'nacionalidad' => 'HONDUREÑA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            34 => 
            array (
                'id' => 35,
                'pais' => 'INDONESIA',
                'nacionalidad' => 'INDONESA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            35 => 
            array (
                'id' => 36,
                'pais' => 'INGLATERRA',
                'nacionalidad' => 'INGLESA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            36 => 
            array (
                'id' => 37,
                'pais' => 'IRAK',
                'nacionalidad' => 'IRAQUÍ',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            37 => 
            array (
                'id' => 38,
                'pais' => 'IRÁN',
                'nacionalidad' => 'IRANÍ',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            38 => 
            array (
                'id' => 39,
                'pais' => 'IRLANDA',
                'nacionalidad' => 'IRLANDESA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            39 => 
            array (
                'id' => 40,
                'pais' => 'ISRAEL',
                'nacionalidad' => 'ISRAELÍ',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            40 => 
            array (
                'id' => 41,
                'pais' => 'ITALIA',
                'nacionalidad' => 'ITALIANA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            41 => 
            array (
                'id' => 42,
                'pais' => 'JAPÓN',
                'nacionalidad' => 'JAPONESA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            42 => 
            array (
                'id' => 43,
                'pais' => 'JORDANIA',
                'nacionalidad' => 'JORDANA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            43 => 
            array (
                'id' => 44,
                'pais' => 'LAOS',
                'nacionalidad' => 'LAOSIANA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            44 => 
            array (
                'id' => 45,
                'pais' => 'LETONIA',
                'nacionalidad' => 'LETONA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            45 => 
            array (
                'id' => 46,
                'pais' => 'LITUANIA',
                'nacionalidad' => 'LETONESA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            46 => 
            array (
                'id' => 47,
                'pais' => 'MALASIA',
                'nacionalidad' => 'MALAYA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            47 => 
            array (
                'id' => 48,
                'pais' => 'MARRUECOS',
                'nacionalidad' => 'MARROQUÍ',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            48 => 
            array (
                'id' => 49,
                'pais' => 'MÉXICO',
                'nacionalidad' => 'MEXICANA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            49 => 
            array (
                'id' => 50,
                'pais' => 'NICARAGUA',
                'nacionalidad' => 'NICARAGÜENSE',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            50 => 
            array (
                'id' => 51,
                'pais' => 'NORUEGA',
                'nacionalidad' => 'NORUEGA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            51 => 
            array (
                'id' => 52,
                'pais' => 'NUEVA ZELANDIA',
                'nacionalidad' => 'NEOZELANDESA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            52 => 
            array (
                'id' => 53,
                'pais' => 'PANAMÁ',
                'nacionalidad' => 'PANAMEÑA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            53 => 
            array (
                'id' => 54,
                'pais' => 'PARAGUAY',
                'nacionalidad' => 'PARAGUAYA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            54 => 
            array (
                'id' => 55,
                'pais' => 'PERÚ',
                'nacionalidad' => 'PERUANA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            55 => 
            array (
                'id' => 56,
                'pais' => 'POLONIA',
                'nacionalidad' => 'POLACA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            56 => 
            array (
                'id' => 57,
                'pais' => 'PORTUGAL',
                'nacionalidad' => 'PORTUGUESA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            57 => 
            array (
                'id' => 58,
                'pais' => 'PUERTO RICO',
                'nacionalidad' => 'PUERTORRIQUEÑA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            58 => 
            array (
                'id' => 59,
                'pais' => 'REPUBLICA DOMINICANA',
                'nacionalidad' => 'DOMINICANA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            59 => 
            array (
                'id' => 60,
                'pais' => 'RUMANIA',
                'nacionalidad' => 'RUMANA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            60 => 
            array (
                'id' => 61,
                'pais' => 'RUSIA',
                'nacionalidad' => 'RUSA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            61 => 
            array (
                'id' => 62,
                'pais' => 'SUECIA',
                'nacionalidad' => 'SUECA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            62 => 
            array (
                'id' => 63,
                'pais' => 'SUIZA',
                'nacionalidad' => 'SUIZA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            63 => 
            array (
                'id' => 64,
                'pais' => 'TAILANDIA',
                'nacionalidad' => 'TAILANDESA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            64 => 
            array (
                'id' => 65,
                'pais' => 'TAIWÁN',
                'nacionalidad' => 'TAIWANESA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            65 => 
            array (
                'id' => 66,
                'pais' => 'TURQUÍA',
                'nacionalidad' => 'TURCA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            66 => 
            array (
                'id' => 67,
                'pais' => 'UCRANIA',
                'nacionalidad' => 'UCRANIANA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            67 => 
            array (
                'id' => 68,
                'pais' => 'URUGUAY',
                'nacionalidad' => 'URUGUAYA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            68 => 
            array (
                'id' => 69,
                'pais' => 'VENEZUELA',
                'nacionalidad' => 'VENEZOLANA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
            69 => 
            array (
                'id' => 70,
                'pais' => 'VIETNAM',
                'nacionalidad' => 'VIETNAMITA',
                'created_at' => '2024-01-01 12:00:00',
                'updated_at' => '2024-01-01 12:00:00'
            ),
    ));
    }
}
