<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstitucionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $institucion = Area::firstOrCreate([
            'nombre' => 'UGEL HUACAYBAMBA',
            'titulo' => 'UGEL - HUACAYBAMBA',
            'slogan' => 'La Unidad de Gestión Educativa Local Huacaybamba, es una entidad pública con fines netamente educativos, constituido desde el Órgano de Dirección, área de Gestión Pedagógica, Área de Gestión  Administrativa,',
            'direccion' => 'AV. 28 de julio Nº 502 - 504 10830',
            'email' => 'ue307hbba@hotmail.com',
            'celular' => '998 872 733',
            'director_apenom',
            'director_dni',
            'director_email',
            'director_foto',
            'director_celular',
            'agp_apenom',
            'agp_dni',
            'agp_email',
            'agp_foto',
            'agp_celular',
            'agi_apenom',
            'agi_dni',
            'agi_email',
            'agi_foto',
            'agi_celular',
            'aga_apenom',
            'aga_dni',
            'aga_email',
            'aga_foto',
            'aga_celular', 
        ]); 


    }
}
