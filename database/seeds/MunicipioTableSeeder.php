<?php

use Illuminate\Database\Seeder;
use App\Models\Base\Municipio;

class MunicipioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Municipio::create([
        	'municipio_codigo' => '1',
        	'municipio_nombre' => 'Bogota',
        	'departamento_codigo' => '1'
        ]);
    }
}
