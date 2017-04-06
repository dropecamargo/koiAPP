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
        	'subcategoria_nombre' => 'SUBCATEGORIA1',
        	'subcategoria_activo' => true
        	]);
    }
}
