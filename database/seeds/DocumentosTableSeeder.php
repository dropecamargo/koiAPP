<?php

use Illuminate\Database\Seeder;
use App\Models\Base\Documentos;

class DocumentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Documentos::create([
	    	'documentos_codigo' => 'AJUS',
	    	'documentos_nombre' => 'AJUSTE'
    	]);

    	Documentos::create([
	    	'documentos_codigo' => 'PEDN',
	    	'documentos_nombre' => 'PEDIDOS NACIONAL'
    	]);

    }
}
