<?php

use Illuminate\Database\Seeder;
use App\Models\Inventario\Linea;

class LineaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       	Linea::create([
    		'linea_nombre' => 'LINEA1',
    		'linea_margen_nivel1' => '1234',
    		'linea_margen_nivel2' => '421234',
    		'linea_margen_nivel3' => '54621',
        	'linea_activo' => true
        	]);
    }
}
