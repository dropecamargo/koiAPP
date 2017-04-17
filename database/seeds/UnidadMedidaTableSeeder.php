<?php

use Illuminate\Database\Seeder;
use App\Models\Inventario\Unidad;

class UnidadMedidaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Unidad::create([
        	'unidadmedida_nombre' => 'METROS',
        	'unidadmedida_sigla' => 'M',
        	'unidad_medida_activo' => true
    	]);
    }
}
