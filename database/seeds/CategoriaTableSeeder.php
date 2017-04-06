<?php

use Illuminate\Database\Seeder;
use App\Models\Inventario\Categoria;

class CategoriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categoria::create([
        	'categoria_nombre' => 'CATEGORIA',
        	'categoria_activo' => true
        	]);
    }
}
