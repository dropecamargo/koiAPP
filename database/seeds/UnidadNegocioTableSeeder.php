<?php

use Illuminate\Database\Seeder;
use App\Models\Inventario\UnidadNegocio;

class UnidadNegocioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UnidadNegocio::create([
        	'unidadnegocio_nombre' => 'U. UNIDADNEGOCIO',
        	'unidadnegocio_activo' => true
    	]);

    }
}
