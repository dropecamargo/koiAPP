<?php

use Illuminate\Database\Seeder;
use App\Models\Inventario\Impuesto;

class ImpuestoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Impuesto::create([
        	'impuesto_nombre' => 'IVA',
        	'impuesto_porcentaje' => '19',
        	'impuesto_activo' => true
        	]);

    }
}
