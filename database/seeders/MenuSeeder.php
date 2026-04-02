<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            // ── Menús principales ──────────────────────────────────────
            ['id' => 1,  'nom_menu' => 'INSTITUCIONAL',                       'link_menu' => '#',                                                                 'activo_menu' => 1, 'idpagina' => null, 'categoriamenu' => null],
            ['id' => 2,  'nom_menu' => 'DIRECCIONES',                         'link_menu' => '#',                                                                 'activo_menu' => 1, 'idpagina' => null, 'categoriamenu' => null],
            ['id' => 11, 'nom_menu' => 'UGELES',                              'link_menu' => '#',                                                                 'activo_menu' => 1, 'idpagina' => null, 'categoriamenu' => null],
            ['id' => 73, 'nom_menu' => 'INSTITUTOS PUBLICOS',                 'link_menu' => '#',                                                                 'activo_menu' => 1, 'idpagina' => 46,   'categoriamenu' => null],

            // ── INSTITUCIONAL (categoriamenu = 1) ─────────────────────
            ['id' => 28, 'nom_menu' => 'MISION Y VISION',                     'link_menu' => 'https://www.drehuanuco.gob.pe/menus/paginaweb/15',                  'activo_menu' => 1, 'idpagina' => 15,   'categoriamenu' => 1],
            ['id' => 29, 'nom_menu' => 'BIENVENIDA',                          'link_menu' => 'https://www.drehuanuco.gob.pe/menus/paginaweb/16',                  'activo_menu' => 1, 'idpagina' => 16,   'categoriamenu' => 1],
            ['id' => 32, 'nom_menu' => 'VALORES',                             'link_menu' => 'https://www.drehuanuco.gob.pe/menus/paginaweb/19',                  'activo_menu' => 1, 'idpagina' => 19,   'categoriamenu' => 1],
            ['id' => 50, 'nom_menu' => 'DIRECTORIO',                          'link_menu' => 'https://www.drehuanuco.gob.pe/directorioweb',                       'activo_menu' => 1, 'idpagina' => 0,    'categoriamenu' => 1],
            ['id' => 53, 'nom_menu' => 'ORGANIGRAMA',                         'link_menu' => 'https://www.drehuanuco.gob.pe/menus/paginaweb/37',                  'activo_menu' => 1, 'idpagina' => 37,   'categoriamenu' => 1],
            ['id' => 54, 'nom_menu' => 'CONVOCATORIA',                        'link_menu' => 'https://drehuanuco.gob.pe/convocatoriaweb',                         'activo_menu' => 1, 'idpagina' => 38,   'categoriamenu' => 1],

            // ── DIRECCIONES (categoriamenu = 2) ───────────────────────
            ['id' => 33, 'nom_menu' => 'DIRECCION DE GESTION PEDAGOGICA',     'link_menu' => 'https://www.drehuanuco.gob.pe/menus/paginaweb/20',                  'activo_menu' => 1, 'idpagina' => 20,   'categoriamenu' => 2],
            ['id' => 34, 'nom_menu' => 'DIRECCION DE GESTION INSTITUCIONAL',  'link_menu' => 'https://www.drehuanuco.gob.pe/menus/paginaweb/21',                  'activo_menu' => 1, 'idpagina' => 21,   'categoriamenu' => 2],
            ['id' => 35, 'nom_menu' => 'DIRECCION DE GESTION ADMINISTRATIVA', 'link_menu' => 'https://www.drehuanuco.gob.pe/menus/paginaweb/22',                  'activo_menu' => 1, 'idpagina' => 22,   'categoriamenu' => 2],
            ['id' => 36, 'nom_menu' => 'ASESORIA JURIDICA',                   'link_menu' => 'https://www.drehuanuco.gob.pe/menus/paginaweb/23',                  'activo_menu' => 1, 'idpagina' => 23,   'categoriamenu' => 2],

            // ── UGELES (categoriamenu = 11) ───────────────────────────
            ['id' => 79, 'nom_menu' => 'UGEL HUANUCO',                        'link_menu' => 'https://ugelhuanuco.gob.pe/',                                       'activo_menu' => 1, 'idpagina' => 46,   'categoriamenu' => 11],
            ['id' => 80, 'nom_menu' => 'UGEL PACHITEA',                       'link_menu' => 'https://www.facebook.com/UGELPachitea304/',                         'activo_menu' => 1, 'idpagina' => 46,   'categoriamenu' => 11],
            ['id' => 81, 'nom_menu' => 'UGEL HUAMALIES',                      'link_menu' => 'http://ugelhuamalies.regionhuanuco.gob.pe/',                        'activo_menu' => 1, 'idpagina' => 46,   'categoriamenu' => 11],
            ['id' => 86, 'nom_menu' => 'UGEL YAROWILCA',                      'link_menu' => 'https://ugelyarowilca.edu.pe/',                                     'activo_menu' => 1, 'idpagina' => 46,   'categoriamenu' => 11],
            ['id' => 87, 'nom_menu' => 'UGEL AMBO',                           'link_menu' => 'https://www.ugelambo.com/',                                         'activo_menu' => 1, 'idpagina' => 46,   'categoriamenu' => 11],
            ['id' => 88, 'nom_menu' => 'UGEL DOS DE MAYO',                    'link_menu' => 'https://www.ugeldosdemayo.edu.pe/',                                 'activo_menu' => 1, 'idpagina' => null, 'categoriamenu' => 11],
            ['id' => 89, 'nom_menu' => 'UGEL HUACAYBAMBA',                    'link_menu' => 'https://ugelhuacaybamba.edu.pe/',                                   'activo_menu' => 1, 'idpagina' => null, 'categoriamenu' => 11],
            ['id' => 90, 'nom_menu' => 'UGEL LAURICOCHA',                     'link_menu' => 'http://ugellauricocha.regionhuanuco.gob.pe/',                       'activo_menu' => 1, 'idpagina' => null, 'categoriamenu' => 11],
            ['id' => 91, 'nom_menu' => 'UGEL LEONCIO PRADO',                  'link_menu' => 'https://www.ugel302.gob.pe/',                                       'activo_menu' => 1, 'idpagina' => null, 'categoriamenu' => 11],
            ['id' => 92, 'nom_menu' => 'UGEL MARANON',                        'link_menu' => 'https://www.facebook.com/profile.php?id=61587239126054&locale=es_LA','activo_menu' => 1, 'idpagina' => null, 'categoriamenu' => 11],
            ['id' => 93, 'nom_menu' => 'UGEL PUERTO INCA',                    'link_menu' => 'https://www.facebook.com/ue306educacionpuertoinca/?locale=es_LA',   'activo_menu' => 1, 'idpagina' => null, 'categoriamenu' => 11],

            // ── INSTITUTOS PUBLICOS (categoriamenu = 73) ─────────────
            ['id' => 74, 'nom_menu' => 'HERMILIO VALDIZAN',                   'link_menu' => 'http://iesphermiliovaldizan.edu.pe/portal/',                        'activo_menu' => 1, 'idpagina' => 46,   'categoriamenu' => 73],
            ['id' => 75, 'nom_menu' => 'GLICERIO GOMEZ IGARZA',               'link_menu' => 'https://www.iestpggi.edu.pe/',                                      'activo_menu' => 1, 'idpagina' => 46,   'categoriamenu' => 73],
            ['id' => 76, 'nom_menu' => 'TINYASH',                             'link_menu' => 'https://institutotinyash.edu.pe/',                                  'activo_menu' => 1, 'idpagina' => 46,   'categoriamenu' => 73],
            ['id' => 77, 'nom_menu' => 'JOSE CRESPO Y CASTILLO',              'link_menu' => 'https://iesppjosecrespoycastillo.edu.pe/2.0/',                      'activo_menu' => 1, 'idpagina' => 46,   'categoriamenu' => 73],
            ['id' => 78, 'nom_menu' => 'APARICIO POMARES',                    'link_menu' => 'https://www.istap.edu.pe/',                                         'activo_menu' => 1, 'idpagina' => 46,   'categoriamenu' => 73],
            ['id' => 84, 'nom_menu' => 'MAX PLANCK',                          'link_menu' => 'https://ietpmaxplanck.edu.pe/',                                     'activo_menu' => 1, 'idpagina' => 46,   'categoriamenu' => 73],
        ];

        DB::table('menus')->upsert(
            $menus,
            ['id'],
            ['nom_menu', 'link_menu', 'activo_menu', 'idpagina', 'categoriamenu']
        );
    }
}
