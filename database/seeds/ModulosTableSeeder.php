<?php

use Illuminate\Database\Seeder;
use App\Models\Base\Modulo;

class ModulosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Modulo::create([
        	'name' => 'administracion',
        	'display_name' => 'Administracion',
        	'nivel1' => 1
    	]);
        Modulo::create([
            'name' => 'cartera',
            'display_name' => 'Cartera',
            'nivel1' => 2
        ]);
    	Modulo::create([
        	'name' => 'comercial',
        	'display_name' => 'Comercial',
        	'nivel1' => 3
    	]);
    	Modulo::create([
        	'name' => 'contabilidad',
        	'display_name' => 'Contabilidad',
        	'nivel1' => 4
    	]);
        Modulo::create([
            'name' => 'inventario',
            'display_name' => 'Inventario',
            'nivel1' => 5
        ]);
    	Modulo::create([
        	'name' => 'tecnico',
        	'display_name' => 'Tecnico',
        	'nivel1' => 6
    	]);

    	// Administracion
    	Modulo::create([
        	'display_name' => 'Modulos',
        	'nivel1' => 1,
        	'nivel2' => 1
    	]);
    	Modulo::create([
        	'display_name' => 'Referencias',
        	'nivel1' => 1,
        	'nivel2' => 2
    	]);

    	//Modulos
    	Modulo::create([
        	'name' => 'empresa',
        	'display_name' => 'Empresa',
        	'nivel1' => 1,
        	'nivel2' => 1,
        	'nivel3' => 1
    	]);
    	Modulo::create([
        	'name' => 'terceros',
        	'display_name' => 'Terceros',
        	'nivel1' => 1,
        	'nivel2' => 1,
        	'nivel3' => 2
    	]);
    	Modulo::create([
        	'name' => 'roles',
        	'display_name' => 'Roles',
        	'nivel1' => 1,
        	'nivel2' => 1,
        	'nivel3' => 3
    	]);

    	//Referencias
    	Modulo::create([
        	'name' => 'actividades',
        	'display_name' => 'Acitividades',
        	'nivel1' => 1,
        	'nivel2' => 2,
        	'nivel3' => 1
    	]);
    	Modulo::create([
        	'name' => 'departamentos',
        	'display_name' => 'Departamentos',
        	'nivel1' => 1,
        	'nivel2' => 2,
        	'nivel3' => 2
    	]);
        Modulo::create([
            'name' => 'documento',
            'display_name' => 'Documentos',
            'nivel1' => 1,
            'nivel2' => 2,
            'nivel3' => 3
        ]);
    	Modulo::create([
        	'name' => 'modulos',
        	'display_name' => 'Modulos',
        	'nivel1' => 1,
        	'nivel2' => 2,
        	'nivel3' => 4
    	]);
        Modulo::create([
            'name' => 'municipios',
            'display_name' => 'Municipios',
            'nivel1' => 1,
            'nivel2' => 2,
            'nivel3' => 5
        ]);
    	Modulo::create([
        	'name' => 'paises',
        	'display_name' => 'Paises',
        	'nivel1' => 1,
        	'nivel2' => 2,
        	'nivel3' => 6
    	]);
    	Modulo::create([
        	'name' => 'permisos',
        	'display_name' => 'Permisos',
        	'nivel1' => 1,
        	'nivel2' => 2,
        	'nivel3' => 7
    	]);
		Modulo::create([
        	'name' => 'puntosventa',
        	'display_name' => 'Puntos de venta',
        	'nivel1' => 1,
        	'nivel2' => 2,
        	'nivel3' => 8
    	]);
        Modulo::create([
            'name' => 'regionales',
            'display_name' => 'Regionales',
            'nivel1' => 1,
            'nivel2' => 2,
            'nivel3' => 9
        ]);
        Modulo::create([
            'name' => 'sucursales',
            'display_name' => 'Sucursales',
            'nivel1' => 1,
            'nivel2' => 2,
            'nivel3' => 10
        ]);
        Modulo::create([
            'name' => 'tiposactividad',
            'display_name' => 'Tipo actividad',
            'nivel1' => 1,
            'nivel2' => 2,
            'nivel3' => 11
        ]);

        // Cartera
        Modulo::create([
            'display_name' => 'Modulos',
            'nivel1' => 2,
            'nivel2' => 1
        ]);
        Modulo::create([
            'display_name' => 'Referencias',
            'nivel1' => 2,
            'nivel2' => 2
        ]);

        // Modulo
        Modulo::create([
            'name' => 'ajustesc',
            'display_name' => 'Ajustes cartera',
            'nivel1' => 2,
            'nivel2' => 1,
            'nivel3' => 1
        ]);
        Modulo::create([
            'name' => 'anticipos',
            'display_name' => 'Anticipos',
            'nivel1' => 2,
            'nivel2' => 1,
            'nivel3' => 2
        ]);
        Modulo::create([
            'name' => 'chequesdevueltos',
            'display_name' => 'Cheques devueltos',
            'nivel1' => 2,
            'nivel2' => 1,
            'nivel3' => 3
        ]);
        Modulo::create([
            'name' => 'cheques',
            'display_name' => 'Cheques posfechados',
            'nivel1' => 2,
            'nivel2' => 1,
            'nivel3' => 4
        ]);
        Modulo::create([
            'name' => 'devoluciones',
            'display_name' => 'Devoluciones',
            'nivel1' => 2,
            'nivel2' => 1,
            'nivel3' => 5
        ]);
        Modulo::create([
            'name' => 'facturas',
            'display_name' => 'Facturas',
            'nivel1' => 2,
            'nivel2' => 1,
            'nivel3' => 6
        ]);
        Modulo::create([
            'name' => 'gestioncobros',
            'display_name' => 'Gestion cobro',
            'nivel1' => 2,
            'nivel2' => 1,
            'nivel3' => 7
        ]);
        Modulo::create([
            'name' => 'notas',
            'display_name' => 'Notas',
            'nivel1' => 2,
            'nivel2' => 1,
            'nivel3' => 8
        ]);
        Modulo::create([
            'name' => 'recibos',
            'display_name' => 'Recibo de caja',
            'nivel1' => 2,
            'nivel2' => 1,
            'nivel3' => 9
        ]);

        // Referencia
        Modulo::create([
            'name' => 'autorizacionesca',
            'display_name' => 'Autorizacion de cartera',
            'nivel1' => 2,
            'nivel2' => 2,
            'nivel3' => 1
        ]);
        Modulo::create([
            'name' => 'bancos',
            'display_name' => 'Bancos',
            'nivel1' => 2,
            'nivel2' => 2,
            'nivel3' => 2
        ]);
        Modulo::create([
            'name' => 'causas',
            'display_name' => 'Causas',
            'nivel1' => 2,
            'nivel2' => 2,
            'nivel3' => 3
        ]);
        Modulo::create([
            'name' => 'cuentabancos',
            'display_name' => 'Cuentas de banco',
            'nivel1' => 2,
            'nivel2' => 2,
            'nivel3' => 4
        ]);
        Modulo::create([
            'name' => 'conceptonotas',
            'display_name' => 'Concepto de nota',
            'nivel1' => 2,
            'nivel2' => 2,
            'nivel3' => 5
        ]);
        Modulo::create([
            'name' => 'conceptocobros',
            'display_name' => 'Concepto cobro',
            'nivel1' => 2,
            'nivel2' => 2,
            'nivel3' => 6
        ]);
        Modulo::create([
            'name' => 'conceptosajustec',
            'display_name' => 'Concepto ajuste de cartera',
            'nivel1' => 2,
            'nivel2' => 2,
            'nivel3' => 7
        ]);
        Modulo::create([
            'name' => 'conceptosrc',
            'display_name' => 'Concepto recibo de caja',
            'nivel1' => 2,
            'nivel2' => 2,
            'nivel3' => 8
        ]);
        Modulo::create([
            'name' => 'mediopagos',
            'display_name' => 'Medios de pago',
            'nivel1' => 2,
            'nivel2' => 2,
            'nivel3' => 9
        ]);

    	// Comercial
    	Modulo::create([
        	'display_name' => 'Modulos',
        	'nivel1' => 3,
        	'nivel2' => 1
    	]);
        Modulo::create([
            'display_name' => 'Referencias',
            'nivel1' => 3,
            'nivel2' => 2
        ]);
        // Modulos
        Modulo::create([
            'name' => 'gestionescomercial',
            'display_name' => 'Gestión comercial',
            'nivel1' => 3,
            'nivel2' => 1,
            'nivel3' => 1
        ]);
        Modulo::create([
            'name' => 'pedidosc',
            'display_name' => 'Pedidos',
            'nivel1' => 3,
            'nivel2' => 1,
            'nivel3' => 2
        ]);
        Modulo::create([
            'name' => 'presupuestoasesor',
            'display_name' => 'Presupuesto',
            'nivel1' => 3,
            'nivel2' => 1,
            'nivel3' => 3
        ]);        
        // Referencias
        Modulo::create([
            'name' => 'conceptoscomercial',
            'display_name' => 'Concepto comercial',
            'nivel1' => 3,
            'nivel2' => 2,
            'nivel3' => 1
        ]);
    	// Contabilidad
        Modulo::create([
            'display_name' => 'Modulos',
            'nivel1' => 4,
            'nivel2' => 1
        ]);
        Modulo::create([
            'name' => 'reportes',
            'display_name' => 'Reportes',
            'nivel1' => 4,
            'nivel2' => 2
        ]);
        Modulo::create([
            'display_name' => 'Referencias',
            'nivel1' => 4,
            'nivel2' => 3
        ]);

    	//Modulos
        Modulo::create([
            'name' => 'asientos',
            'display_name' => 'Asientos',
            'nivel1' => 4,
            'nivel2' => 1,
            'nivel3' => 1
        ]);

    	//Reportes
        Modulo::create([
            'name' => 'rplancuentas',
            'display_name' => 'Plan cuentas',
            'nivel1' => 4,
            'nivel2' => 2,
            'nivel3' => 1
        ]);
        Modulo::create([
            'name' => 'rmayorbalance',
            'display_name' => 'Mayor y Balance',
            'nivel1' => 4,
            'nivel2' => 2,
            'nivel3' => 2
        ]);

        //Referencias
        Modulo::create([
            'name' => 'centroscosto',
            'display_name' => 'Centros de costo',
            'nivel1' => 4,
            'nivel2' => 3,
            'nivel3' => 1
        ]);
        Modulo::create([
            'name' => 'documentos',
            'display_name' => 'Documentos',
            'nivel1' => 4,
            'nivel2' => 3,
            'nivel3' => 2
        ]);
        Modulo::create([
            'name' => 'folders',
            'display_name' => 'Folders',
            'nivel1' => 4,
            'nivel2' => 3,
            'nivel3' => 3
        ]);
        Modulo::create([
            'name' => 'plancuentas',
            'display_name' => 'Plan de cuentas',
            'nivel1' => 4,
            'nivel2' => 3,
            'nivel3' => 4
        ]);

        //Inventario
        Modulo::create([
            'display_name' => 'Modulos',
            'nivel1' => 5,
            'nivel2' => 1
        ]);
        Modulo::create([
            'display_name' => 'Referencias',
            'nivel1' => 5,
            'nivel2' => 2
        ]);

        //Modulos
        Modulo::create([
            'name' => 'ajustes',
            'display_name' => 'Ajustes',
            'nivel1' => 5,
            'nivel2' => 1,
            'nivel3' => 1
        ]);
        Modulo::create([
            'name' => 'productos',
            'display_name' => 'Productos',
            'nivel1' => 5,
            'nivel2' => 1,
            'nivel3' => 2
        ]);
        Modulo::create([
            'name' => 'pedidos',
            'display_name' => 'Pedidos',
            'nivel1' => 5,
            'nivel2' => 1,
            'nivel3' => 3
        ]);
        Modulo::create([
            'name' => 'traslados',
            'display_name' => 'Traslados',
            'nivel1' => 5,
            'nivel2' => 1,
            'nivel3' => 4
        ]);

        //Referencia
        Modulo::create([
            'name' => 'categorias',
            'display_name' => 'Categorias',
            'nivel1' => 5,
            'nivel2' => 2,
            'nivel3' => 1
        ]);
        Modulo::create([
            'name' => 'impuestos',
            'display_name' => 'Impuestos',
            'nivel1' => 5,
            'nivel2' => 2,
            'nivel3' => 2
        ]);
        Modulo::create([
            'name' => 'lineas',
            'display_name' => 'Lineas',
            'nivel1' => 5,
            'nivel2' => 2,
            'nivel3' => 3
        ]);
        Modulo::create([
            'name' => 'marcas',
            'display_name' => 'Marcas',
            'nivel1' => 5,
            'nivel2' => 2,
            'nivel3' => 4
        ]);
        Modulo::create([
            'name' => 'modelos',
            'display_name' => 'Modelos',
            'nivel1' => 5,
            'nivel2' => 2,
            'nivel3' => 5
        ]);
        Modulo::create([
            'name' => 'subcategorias',
            'display_name' => 'Subcategorias',
            'nivel1' => 5,
            'nivel2' => 2,
            'nivel3' => 6
        ]);
        Modulo::create([
            'name' => 'tiposajuste',
            'display_name' => 'Tipo ajuste',
            'nivel1' => 5,
            'nivel2' => 2,
            'nivel3' => 7
        ]);
        Modulo::create([
            'name' => 'tipostraslados',
            'display_name' => 'Tipo de traslado',
            'nivel1' => 5,
            'nivel2' => 2,
            'nivel3' => 8
        ]);
        Modulo::create([
            'name' => 'unidades',
            'display_name' => 'Unidades',
            'nivel1' => 5,
            'nivel2' => 2,
            'nivel3' => 9
        ]);
        Modulo::create([
            'name' => 'unidadesnegocio',
            'display_name' => 'Unidades de negocio',
            'nivel1' => 5,
            'nivel2' => 2,
            'nivel3' => 10
        ]);
        // Tecnico
        Modulo::create([
            'display_name' => 'Modulos',
            'nivel1' => 6,
            'nivel2' => 1
        ]);

        Modulo::create([
            'display_name' => 'Referencias',
            'nivel1' => 6,
            'nivel2' => 2
        ]);

        //Modulos
        Modulo::create([
            'name' => 'gestionestecnico',
            'display_name' => 'Gestión tecnico',
            'nivel1' => 6,
            'nivel2' => 1,
            'nivel3' => 1
        ]);
        Modulo::create([
            'name' => 'ordenes',
            'display_name' => 'Ordenes',
            'nivel1' => 6,
            'nivel2' => 1,
            'nivel3' => 2
        ]);

        //Referencias
        Modulo::create([
            'name' => 'conceptostecnico',
            'display_name' => 'Concepto tecnico',
            'nivel1' => 6,
            'nivel2' => 2,
            'nivel3' => 1
        ]);
        Modulo::create([
            'name' => 'danos',
            'display_name' => 'Daños',
            'nivel1' => 6,
            'nivel2' => 2,
            'nivel3' => 2
        ]);
        Modulo::create([
            'name' => 'prioridades',
            'display_name' => 'Prioridades',
            'nivel1' => 6,
            'nivel2' => 2,
            'nivel3' => 3
        ]);
        Modulo::create([
            'name' => 'solicitantes',
            'display_name' => 'Solicitantes',
            'nivel1' => 6,
            'nivel2' => 2,
            'nivel3' => 4
        ]);
        Modulo::create([
            'name' => 'tiposorden',
            'display_name' => 'Tipo de Orden',
            'nivel1' => 6,
            'nivel2' => 2,
            'nivel3' => 5
        ]);
    }
}