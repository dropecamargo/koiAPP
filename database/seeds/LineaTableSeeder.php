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
    		'linea_nombre' => 'L. LINEA',
        	'linea_activo' => true
    	]);
    }
}
