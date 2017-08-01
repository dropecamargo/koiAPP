<?php

use Illuminate\Database\Seeder;
use App\Models\Base\Sucursal;

class SucursalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sucursal::create([
            'sucursal_regional'=>1,
            'sucursal_nombre'=>'090 GARANTIA',
            'sucursal_telefono' => '5711111111',
            'sucursal_direccion' => 'CALLE 25 #10-35',
            'sucursal_activo' => 1
        ]);
        Sucursal::create([
            'sucursal_regional'=>1,
            'sucursal_nombre'=>'091 PROVISIONAL',
            'sucursal_telefono' => '5712222222',
            'sucursal_direccion' => 'CARRERA 6 #10-20',
            'sucursal_activo' => 1
        ]);
        Sucursal::create([
    		'sucursal_regional'=>1,
    		'sucursal_nombre'=>'001 BOGOTA',
    		'sucursal_telefono' => '58742238',
    		'sucursal_direccion' => 'CALLE 22 #5-33',
    		'sucursal_activo' => 1
    	]);
    }
}
