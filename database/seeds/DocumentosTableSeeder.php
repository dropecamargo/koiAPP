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

        Documentos::create([
            'documentos_codigo' => 'RECI',
            'documentos_nombre' => 'RECIBO'
        ]);

        Documentos::create([
            'documentos_codigo' => 'FACT',
            'documentos_nombre' => 'FACTURA'
        ]);

        Documentos::create([
            'documentos_codigo' => 'PEDC',
            'documentos_nombre' => 'PEDIDO COMERCIAL'
        ]);

        Documentos::create([
            'documentos_codigo' => 'NOTA',
            'documentos_nombre' => 'NOTA'
        ]);

        Documentos::create([
            'documentos_codigo' => 'DEVO',
            'documentos_nombre' => 'DEVOLUCION'
        ]);

        Documentos::create([
            'documentos_codigo' => 'AJUC',
            'documentos_nombre' => 'AJUSTE CARTERA'
        ]);
        Documentos::create([
            'documentos_codigo' => 'TRAS',
            'documentos_nombre' => 'TRASLADOS'
        ]);
        Documentos::create([
            'documentos_codigo' => 'ANTI',
            'documentos_nombre' => 'ANTICIPOS'
        ]);
        Documentos::create([
            'documentos_codigo' => 'ORD',
            'documentos_nombre' => 'ORDEN'
        ]);
        Documentos::create([
            'documentos_codigo' => 'CHD',
            'documentos_nombre' => 'CHEQUES DEVUELTOS'
        ]);
        Documentos::create([
            'documentos_codigo' => 'CHP',
            'documentos_nombre' => 'CHEQUES'
        ]);
        Documentos::create([
            'documentos_codigo' => 'REMR',
            'documentos_nombre' => 'REMISION'
        ]);
        Documentos::create([
            'documentos_codigo' => 'TRAU',
            'documentos_nombre' => 'TRASLADOS UNIDADES'
        ]);
    }
}
