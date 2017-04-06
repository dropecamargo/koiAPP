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
        		'sucursal_nombre'=>'BOGOTA',
        		'sucursal_telefono' => '58742238',
        		'sucursal_direccion' => 'CALLE 22 #5-33',
        		'sucursal_activo' => 1
        	]);
    }
}
