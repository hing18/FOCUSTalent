<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class carreras_subarea extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   DB::table('carreras_subarea')->delete();
        DB::table('carreras_subarea')->insert(array (
        0 => 
        array (
            'id' => 1,
            'subarea' => 'Gestión de Compras',
            'id_area' => '1',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        1 => 
        array (
            'id' => 2,
            'subarea' => 'Gestión de Instalaciones',
            'id_area' => '1',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        2 => 
        array (
            'id' => 3,
            'subarea' => 'Gestión de Operaciones',
            'id_area' => '1',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        3 => 
        array (
            'id' => 4,
            'subarea' => 'Gestión de Proyectos',
            'id_area' => '1',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        4 => 
        array (
            'id' => 5,
            'subarea' => 'Gestión de Recursos Humanos',
            'id_area' => '1',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        5 => 
        array (
            'id' => 6,
            'subarea' => 'Gestión Financiera',
            'id_area' => '1',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        6 => 
        array (
            'id' => 7,
            'subarea' => 'Análisis Financiero',
            'id_area' => '2',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        7 => 
        array (
            'id' => 8,
            'subarea' => 'Auditoría',
            'id_area' => '2',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        8 => 
        array (
            'id' => 9,
            'subarea' => 'Contabilidad',
            'id_area' => '2',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        9 => 
        array (
            'id' => 10,
            'subarea' => 'Control de Costos',
            'id_area' => '2',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        10 => 
        array (
            'id' => 11,
            'subarea' => 'Planificación Financiera',
            'id_area' => '2',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        11 => 
        array (
            'id' => 12,
            'subarea' => 'Tesorería',
            'id_area' => '2',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        12 => 
        array (
            'id' => 13,
            'subarea' => 'Asesoría Legal',
            'id_area' => '3',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        13 => 
        array (
            'id' => 14,
            'subarea' => 'Contratos y Acuerdos',
            'id_area' => '3',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        14 => 
        array (
            'id' => 15,
            'subarea' => 'Cumplimiento Normativo',
            'id_area' => '3',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        15 => 
        array (
            'id' => 16,
            'subarea' => 'Licencias y Permisos',
            'id_area' => '3',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        16 => 
        array (
            'id' => 17,
            'subarea' => 'Protección de Datos',
            'id_area' => '3',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        17 => 
        array (
            'id' => 18,
            'subarea' => 'Limpieza de Espacios Públicos',
            'id_area' => '4',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        18 => 
        array (
            'id' => 19,
            'subarea' => 'Limpieza de Oficinas',
            'id_area' => '4',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        19 => 
        array (
            'id' => 20,
            'subarea' => 'Limpieza/Mantenimiento Industrial',
            'id_area' => '4',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        20 => 
        array (
            'id' => 21,
            'subarea' => 'Mantenimiento de Edificios',
            'id_area' => '4',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        21 => 
        array (
            'id' => 22,
            'subarea' => 'Gestión de la Cadena de Suministro',
            'id_area' => '5',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        22 => 
        array (
            'id' => 23,
            'subarea' => 'Logística de Almacén',
            'id_area' => '5',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        23 => 
        array (
            'id' => 24,
            'subarea' => 'Planificación de la Producción',
            'id_area' => '5',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        24 => 
        array (
            'id' => 25,
            'subarea' => 'Transporte y Distribución',
            'id_area' => '5',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        25 => 
        array (
            'id' => 26,
            'subarea' => 'Administración de Nóminas',
            'id_area' => '6',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        26 => 
        array (
            'id' => 27,
            'subarea' => 'Compensación y Beneficios',
            'id_area' => '6',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        27 => 
        array (
            'id' => 28,
            'subarea' => 'Formación y Desarrollo',
            'id_area' => '6',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        28 => 
        array (
            'id' => 29,
            'subarea' => 'Gestión del Desempeño',
            'id_area' => '6',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        29 => 
        array (
            'id' => 30,
            'subarea' => 'Relaciones Laborales',
            'id_area' => '6',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        30 => 
        array (
            'id' => 31,
            'subarea' => 'Selección y Contratación',
            'id_area' => '6',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        31 => 
        array (
            'id' => 32,
            'subarea' => 'Atención al Cliente',
            'id_area' => '7',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        32 => 
        array (
            'id' => 33,
            'subarea' => 'Gestión de Quejas',
            'id_area' => '7',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        33 => 
        array (
            'id' => 34,
            'subarea' => 'Retención de Clientes',
            'id_area' => '7',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        34 => 
        array (
            'id' => 35,
            'subarea' => 'Soporte Técnico al Cliente',
            'id_area' => '7',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        35 => 
        array (
            'id' => 36,
            'subarea' => 'Control de Stock',
            'id_area' => '8',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        36 => 
        array (
            'id' => 37,
            'subarea' => 'Distribución Interna',
            'id_area' => '8',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        37 => 
        array (
            'id' => 38,
            'subarea' => 'Gestión de Inventarios',
            'id_area' => '8',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        38 => 
        array (
            'id' => 39,
            'subarea' => 'Gestión de Proveedores',
            'id_area' => '8',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        39 => 
        array (
            'id' => 40,
            'subarea' => 'Recepción y Almacenamiento de Mercancías',
            'id_area' => '8',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        40 => 
        array (
            'id' => 41,
            'subarea' => 'Administración de Redes',
            'id_area' => '9',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        41 => 
        array (
            'id' => 42,
            'subarea' => 'Administración de Sistemas',
            'id_area' => '9',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        42 => 
        array (
            'id' => 43,
            'subarea' => 'Análisis de Datos',
            'id_area' => '9',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        43 => 
        array (
            'id' => 44,
            'subarea' => 'Desarrollo de Software',
            'id_area' => '9',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        44 => 
        array (
            'id' => 45,
            'subarea' => 'Seguridad Informática',
            'id_area' => '9',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        45 => 
        array (
            'id' => 46,
            'subarea' => 'Soporte Técnico',
            'id_area' => '9',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        46 => 
        array (
            'id' => 47,
            'subarea' => 'Desarrollo de Producto',
            'id_area' => '10',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        47 => 
        array (
            'id' => 48,
            'subarea' => 'Gestión de Clientes',
            'id_area' => '10',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        48 => 
        array (
            'id' => 49,
            'subarea' => 'Investigación de Mercado',
            'id_area' => '10',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        49 => 
        array (
            'id' => 50,
            'subarea' => 'Marketing Digital',
            'id_area' => '10',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        50 => 
        array (
            'id' => 51,
            'subarea' => 'Publicidad y Promoción',
            'id_area' => '10',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
        51 => 
        array (
            'id' => 52,
            'subarea' => 'Ventas Directas',
            'id_area' => '10',
            'created_at' => '2024-01-01 12:00:00',
            'updated_at' => '2024-01-01 12:00:00'
        ),
    ));
    }
}
