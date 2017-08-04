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
    		'sucursal_nombre'=>'001 COTA TRAMOS',
    		'sucursal_telefono' => '(571) 587-42-23',
    		'sucursal_direccion' => 'Kilometro 1 V I A - C O T A',
    		'sucursal_direccion_nomenclatura' => 'KM 1 V I A   C O T A',
    		'sucursal_activo' => 1
    	]);
        Sucursal::create([
    		'sucursal_regional'=>1,
    		'sucursal_nombre'=>'002 COTA',
    		'sucursal_telefono' => '(571) 444-55-66',
    		'sucursal_direccion' => 'Kilometro 1 V I A - C O T A',
    		'sucursal_direccion_nomenclatura' => 'KM 1 V I A   C O T A',
    		'sucursal_activo' => 1
    	]);
        Sucursal::create([
    		'sucursal_regional'=>1,
    		'sucursal_nombre'=>'003 COTA CONSIGNACIÓN SURTIGRAFICO',
    		'sucursal_telefono' => '(571) 444-55-66',
    		'sucursal_direccion' => 'Kilometro 1 V I A - C O T A',
    		'sucursal_direccion_nomenclatura' => 'KM 1 V I A   C O T A',
    		'sucursal_activo' => 1
    	]);
        Sucursal::create([
    		'sucursal_regional'=>1,
    		'sucursal_nombre'=>'004 FACTURACIÓN I-TEX',
    		'sucursal_telefono' => '(571) 333-33-33',
    		'sucursal_direccion' => 'Kilometro 1 V I A - C O T A',
    		'sucursal_direccion_nomenclatura' => 'KM 1 V I A   C O T A',
    		'sucursal_activo' => 1
    	]);
        Sucursal::create([
    		'sucursal_regional'=>1,
    		'sucursal_nombre'=>'090 GARANTIA',
    		'sucursal_telefono' => '(571) 333-33-33',
    		'sucursal_direccion' => 'Kilometro 1 V I A - C O T A',
    		'sucursal_direccion_nomenclatura' => 'KM 1 V I A   C O T A',
    		'sucursal_activo' => 1
    	]);
        Sucursal::create([
    		'sucursal_regional'=>1,
    		'sucursal_nombre'=>'091 PROVISIONAL',
    		'sucursal_telefono' => '(571) 333-33-33',
    		'sucursal_direccion' => 'Kilometro 1 V I A - C O T A',
    		'sucursal_direccion_nomenclatura' => 'KM 1 V I A   C O T A',
    		'sucursal_activo' => 1
    	]);
    }
}
