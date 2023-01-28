<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Institucion;
class InstitucionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $institucion = Institucion::firstOrCreate([
            'nombre' => 'DRE HUANUCO',
            'titulo' => 'DRE - HUANUCO',
            'slogan' => 'La Unidad de Gestión Educativa Local Huacaybamba, es una entidad pública con fines netamente educativos.',
            'direccion' => 'AV. 28 de julio Nº 502 - 504 10830',
            'email' => 'ue307hbba@hotmail.com',
            'celular' => '998 872 733',
            'director_apenom' => 'Lozano Yllatopa Julio Luis',
            'director_dni' => '12345678',
            'director_email' => 'lozanoyllatopa047@gmail.com',
            'director_foto' => '43353.png',
            'director_celular' => '941804029',
            'agp_apenom' => 'MEDINA ESTRADA ROMER',
            'agp_dni' => '00222222',
            'agp_email' => 'romees2803@gmail.com',
            'agp_foto' => 'SFSSFDFD.png',
            'agp_celular' => '962756278',
            'agi_apenom' => 'PEÑA TARAZONA ALEMBERTH',
            'agi_dni' => '35242423',
            'agi_email' => 'alemberth_01_85@hotmail.com',
            'agi_foto' => 'SFSSFDFD.png',
            'agi_celular' => '962756278',
            'aga_apenom' => 'EULOGIO VALENZUELA KENNEDY ROBINSON',
            'aga_dni' => '12313132',
            'aga_email' => 'kennedyeulogio@gmail.com',
            'aga_foto' => '12313132.png',
            'aga_celular' => '901880368', 
        ]); 


    }
}
