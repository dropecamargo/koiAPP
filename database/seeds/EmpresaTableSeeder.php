<?php

use Illuminate\Database\Seeder;
use App\Models\Base\Empresa;

class EmpresaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Empresa::create([
        	'empresa_tercero' => '1',
        	'empresa_iva' => '19'
        ]);
    }
}
