<?php

use Illuminate\Database\Seeder;
use App\Models\Inventario\Servicio;

class ServicioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Servicio::create([
    		'servicio_nombre'=>'DISPONIBLE',
    		'servicio_activo' => 1
    	]);
        Servicio::create([
    		'servicio_nombre'=>'GARANTIA',
    		'servicio_activo' => 1
    	]);
        Servicio::create([
    		'servicio_nombre'=>'CLIENTE',
    		'servicio_activo' => 1
    	]);
        Servicio::create([
    		'servicio_nombre'=>'CONTRATO',
    		'servicio_activo' => 1
    	]);
    }
}
