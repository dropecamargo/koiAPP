<?php

use Illuminate\Database\Seeder;
use App\Models\Inventario\SubCategoria;

class SubCategoriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SubCategoria::create([
            'subcategoria_nombre' => 'S. SUBCATEGORIA',
            'subcategoria_margen_nivel1' => '10',
            'subcategoria_margen_nivel2' => '20',
        	'subcategoria_margen_nivel3' => '30',
        	'subcategoria_activo' => true
    	]);
    }
}
