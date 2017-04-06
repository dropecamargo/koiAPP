<?php

use Illuminate\Database\Seeder;
use App\Models\Inventario\Producto;

class ProductoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Producto::create([
        	'producto_serie' => 'REF-1',
        	'producto_referencia' => 'REF-1',
        	'producto_nombre' => 'TONNER',
        	'producto_ref_proveedor' => 'PRO-1',
        	'producto_subcategoria' => 1,
        	'producto_categoria' => 1,
        	'producto_marca' => 1,
        	'producto_modelo' => 1,
        	'producto_linea' => 1,
        	'producto_unidadmedida' => 1,
        	'producto_unidadnegocio' => 1,
        	'producto_maneja_serie' => 0,
        	'producto_metrado' => 0,
        	'producto_vence' => 0,
        	'producto_unidad' => 1,
        	'producto_vidautil' => 0,
        	'producto_costo' => 0,
        	'producto_peso' => 1,
        	'producto_largo' => 2,
        	'producto_alto' => 3,
        	'producto_barras' => '3a<s3w4s',
        	'producto_ancho' => 4,
        	'producto_precio1' => 11540,
        	'producto_precio2' => 12540,
        	'producto_precio3' => 13540,
        	'producto_impuesto' => 1,

        	]);   
        Producto::create([
        	'producto_serie' => 'REF-2',
        	'producto_referencia' => 'REF-2',
        	'producto_nombre' => 'RICOH-MP3500',
        	'producto_ref_proveedor' => 'PRO-1',
        	'producto_subcategoria' => 1,
        	'producto_categoria' => 1,
        	'producto_marca' => 1,
        	'producto_modelo' => 1,
        	'producto_linea' => 1,
        	'producto_unidadmedida' => 1,
        	'producto_unidadnegocio' => 1,
        	'producto_maneja_serie' => 1,
        	'producto_metrado' => 0,
        	'producto_vence' => 0,
        	'producto_unidad' => 1,
        	'producto_vidautil' => 0,
        	'producto_costo' => 0,
        	'producto_peso' => 1,
        	'producto_largo' => 2,
        	'producto_alto' => 3,
        	'producto_barras' => '3a<PAS',
        	'producto_ancho' => 4,
        	'producto_precio1' => 111540,
        	'producto_precio2' => 122540,
        	'producto_precio3' => 133540,
        	'producto_impuesto' => 1,

        	]);   
    	Producto::create([
        	'producto_serie' => 'REF-3',
        	'producto_referencia' => 'REF-3',
        	'producto_nombre' => 'BANNER 50X50 MTS',
        	'producto_ref_proveedor' => 'PRO-1',
        	'producto_subcategoria' => 1,
        	'producto_categoria' => 1,
        	'producto_marca' => 1,
        	'producto_modelo' => 1,
        	'producto_linea' => 1,
        	'producto_unidadmedida' => 1,
        	'producto_unidadnegocio' => 1,
        	'producto_maneja_serie' => 0,
        	'producto_metrado' => 1,
        	'producto_vence' => 0,
        	'producto_unidad' => 1,
        	'producto_vidautil' => 0,
        	'producto_costo' => 0,
        	'producto_peso' => 1,
        	'producto_largo' => 2,
        	'producto_alto' => 3,
        	'producto_barras' => '3a<s3w4s',
        	'producto_ancho' => 4,
        	'producto_precio1' => 151540,
        	'producto_precio2' => 142540,
        	'producto_precio3' => 143540,
        	'producto_impuesto' => 1,

        	]);
    }
}
