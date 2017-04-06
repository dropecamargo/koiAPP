<?php

use Illuminate\Database\Seeder;
use App\Models\Inventario\Marca;

class MarcaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Marca::create([
        	'marca_nombre' => 'MARCA1',
        	'marca_activo' => true
    	]);
    }
}
