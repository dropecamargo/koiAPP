<?php

use Illuminate\Database\Seeder;
use App\Models\Base\Departamento;

class DepartamentoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Departamento::create([
        	'departamento_codigo' => '1',
        	'departamento_nombre' => 'Bogota D.C'
        ]);
    }
}
