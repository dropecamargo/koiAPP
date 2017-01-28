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
        	'tcontacto_nombres' => 'Camilo',
        	'tcontacto_apellidos' => 'Rodriguez',
        	'tcontacto_municipio' => 1,
        	'tcontacto_direccion' => 'Calle 1',
        	'tcontacto_telefono' => '1234567',
        	'tcontacto_celular' => '1234567890',
        	'tcontacto_email' => 'email@hotmail.com',
        	'tcontacto_cargo' => 'Boss'
        	]);
    }
}
