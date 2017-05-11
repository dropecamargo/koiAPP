<?php

use Illuminate\Database\Seeder;
use App\Models\Base\Contacto;

class ContactoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contacto::create([
        	'tcontacto_tercero' => 1,
        	'tcontacto_nombres' => 'CAMILO',
        	'tcontacto_apellidos' => 'RODRIGUEZ',
        	'tcontacto_telefono' => '5741234567',
        	'tcontacto_celular' => '1234567890',
            'tcontacto_direccion' => 'Administracion 94 Sur',
            'tcontacto_direccion_nomenclatura' => 'AD SUR',
        	'tcontacto_email' => 'email@hotmail.com',
        	'tcontacto_cargo' => 'BOSS'
    	]);

        Contacto::create([
            'tcontacto_tercero' => 2,
            'tcontacto_nombres' => 'VALENTINA',
            'tcontacto_apellidos' => 'RAMIREZ',
            'tcontacto_telefono' => '5413216574',
            'tcontacto_celular' => '1234567890',
            'tcontacto_direccion' => 'Administracion Bodega',
            'tcontacto_direccion_nomenclatura' => 'AD BG',
            'tcontacto_email' => 'email@hotmail.com',
            'tcontacto_cargo' => 'DUSS'
        ]);

        Contacto::create([
            'tcontacto_tercero' => 3,
            'tcontacto_nombres' => 'Camilo',
            'tcontacto_apellidos' => 'Rodriguez',
            'tcontacto_telefono' => '5414451156',
            'tcontacto_celular' => '1234567890',
            'tcontacto_direccion' => 'Administracion',
            'tcontacto_direccion_nomenclatura' => 'AD',
            'tcontacto_email' => 'email@hotmail.com',
            'tcontacto_cargo' => 'DOSS'
        ]);
    }
}
