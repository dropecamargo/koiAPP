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
        	'name' => 'cobros',
        	'display_name' => 'Cobros',
        	'nivel1' => 3
    	]);

    	Modulo::create([
        	'name' => 'comercial',
        	'display_name' => 'Comercial',
        	'nivel1' => 4
    	]);

    	Modulo::create([
        	'name' => 'contabilidad',
        	'display_name' => 'Contabilidad',
        	'nivel1' => 5
    	]);

        Modulo::create([
            'name' => 'inventario',
            'display_name' => 'Inventario',
            'nivel1' => 6
        ]);

    	Modulo::create([
        	'name' => 'tecnico',
        	'display_name' => 'Tecnico',
        	'nivel1' => 7
    	]);

        Modulo::create([
        	'name' => 'tesoreria',
        	'display_name' => 'Tesorería',
        	'nivel1' => 8
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
        	'display_name' => 'Actividades',
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

        Modulo::create([
            'name' => 'ubicaciones',
            'display_name' => 'Ubicaciones',
            'nivel1' => 1,
            'nivel2' => 2,
            'nivel3' => 12
        ]);

        // Cartera
        Modulo::create([
            'display_name' => 'Modulos',
            'nivel1' => 2,
            'nivel2' => 1
        ]);

        Modulo::create([
            'display_name' => 'Reportes',
            'nivel1' => 2,
            'nivel2' => 2
        ]);

        Modulo::create([
            'display_name' => 'Referencias',
            'nivel1' => 2,
            'nivel2' => 3
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

        // Reportes
        Modulo::create([
            'name' => 'rcarteraedades',
            'display_name' => 'Cartera edad',
            'nivel1' => 2,
            'nivel2' => 2,
            'nivel3' => 1
        ]);

        Modulo::create([
            'name' => 'rhistorialclientes',
            'display_name' => 'Historial clientes',
            'nivel1' => 2,
            'nivel2' => 2,
            'nivel3' => 2
        ]);

        // Referencia
        Modulo::create([
            'name' => 'autorizacionesca',
            'display_name' => 'Autorizacion de cartera',
            'nivel1' => 2,
            'nivel2' => 3,
            'nivel3' => 1
        ]);

        Modulo::create([
            'name' => 'bancos',
            'display_name' => 'Bancos',
            'nivel1' => 2,
            'nivel2' => 3,
            'nivel3' => 2
        ]);

        Modulo::create([
            'name' => 'causas',
            'display_name' => 'Causas',
            'nivel1' => 2,
            'nivel2' => 3,
            'nivel3' => 3
        ]);

        Modulo::create([
            'name' => 'cuentabancos',
            'display_name' => 'Cuentas de banco',
            'nivel1' => 2,
            'nivel2' => 3,
            'nivel3' => 4
        ]);

        Modulo::create([
            'name' => 'conceptonotas',
            'display_name' => 'Concepto de nota',
            'nivel1' => 2,
            'nivel2' => 3,
            'nivel3' => 5
        ]);

        Modulo::create([
            'name' => 'conceptocobros',
            'display_name' => 'Concepto cobro',
            'nivel1' => 2,
            'nivel2' => 3,
            'nivel3' => 6
        ]);

        Modulo::create([
            'name' => 'conceptosajustec',
            'display_name' => 'Concepto ajuste de cartera',
            'nivel1' => 2,
            'nivel2' => 3,
            'nivel3' => 7
        ]);

        Modulo::create([
            'name' => 'conceptosrc',
            'display_name' => 'Concepto recibo de caja',
            'nivel1' => 2,
            'nivel2' => 3,
            'nivel3' => 8
        ]);

        Modulo::create([
            'name' => 'mediopagos',
            'display_name' => 'Medios de pago',
            'nivel1' => 2,
            'nivel2' => 3,
            'nivel3' => 9
        ]);

    	// Cobros
    	Modulo::create([
        	'display_name' => 'Modulos',
        	'nivel1' => 3,
        	'nivel2' => 1
    	]);

        Modulo::create([
            'display_name' => 'Reportes',
            'nivel1' => 3,
            'nivel2' => 2
        ]);

        // Modulos
        Modulo::create([
            'name' => 'gestioncarteras',
            'display_name' => 'Gestión de carteras',
            'nivel1' => 3,
            'nivel2' => 1,
            'nivel3' => 1
        ]);

        Modulo::create([
            'name' => 'deudores',
            'display_name' => 'Deudores',
            'nivel1' => 3,
            'nivel2' => 1,
            'nivel3' => 2
        ]);

        Modulo::create([
            'name' => 'gestiondeudores',
            'display_name' => 'Gestión de deudor',
            'nivel1' => 3,
            'nivel2' => 1,
            'nivel3' => 3
        ]);

        // Reportes
        Modulo::create([
            'name' => 'rresumencobros',
            'display_name' => 'Resumen de cobros',
            'nivel1' => 3,
            'nivel2' => 2,
            'nivel3' => 1
        ]);

    	// Comercial
    	Modulo::create([
        	'display_name' => 'Modulos',
        	'nivel1' => 4,
        	'nivel2' => 1
    	]);

        Modulo::create([
            'display_name' => 'Reportes',
            'nivel1' => 4,
            'nivel2' => 2
        ]);

        Modulo::create([
            'display_name' => 'Referencias',
            'nivel1' => 4,
            'nivel2' => 3
        ]);

        // Modulos
        Modulo::create([
            'name' => 'gestionescomercial',
            'display_name' => 'Gestión comercial',
            'nivel1' => 4,
            'nivel2' => 1,
            'nivel3' => 1
        ]);

        Modulo::create([
            'name' => 'pedidosc',
            'display_name' => 'Pedidos',
            'nivel1' => 4,
            'nivel2' => 1,
            'nivel3' => 2
        ]);

        Modulo::create([
            'name' => 'presupuestoasesor',
            'display_name' => 'Presupuesto',
            'nivel1' => 4,
            'nivel2' => 1,
            'nivel3' => 3
        ]);

        // Reportes
        Modulo::create([
            'name' => 'rsabanaventascostos',
            'display_name' => 'Sábana de ventas',
            'nivel1' => 4,
            'nivel2' => 2,
            'nivel3' => 1
        ]);

        // Referencias
        Modulo::create([
            'name' => 'conceptoscomercial',
            'display_name' => 'Concepto comercial',
            'nivel1' => 4,
            'nivel2' => 3,
            'nivel3' => 1
        ]);

    	// Contabilidad
        Modulo::create([
            'display_name' => 'Modulos',
            'nivel1' => 5,
            'nivel2' => 1
        ]);

        Modulo::create([
            'display_name' => 'Reportes',
            'nivel1' => 5,
            'nivel2' => 2
        ]);

        Modulo::create([
            'display_name' => 'Referencias',
            'nivel1' => 5,
            'nivel2' => 3
        ]);

    	//Modulos
        Modulo::create([
            'name' => 'activosfijos',
            'display_name' => 'Activos fijos',
            'nivel1' => 5,
            'nivel2' => 1,
            'nivel3' => 1
        ]);

        Modulo::create([
            'name' => 'asientos',
            'display_name' => 'Asientos',
            'nivel1' => 5,
            'nivel2' => 1,
            'nivel3' => 2
        ]);

        Modulo::create([
            'name' => 'asientosnif',
            'display_name' => 'Asientos NIF',
            'nivel1' => 5,
            'nivel2' => 1,
            'nivel3' => 3
        ]);

    	//Reportes
        Modulo::create([
            'name' => 'rplancuentas',
            'display_name' => 'Plan cuentas',
            'nivel1' => 5,
            'nivel2' => 2,
            'nivel3' => 1
        ]);

        Modulo::create([
            'name' => 'rmayorbalance',
            'display_name' => 'Mayor y Balance',
            'nivel1' => 5,
            'nivel2' => 2,
            'nivel3' => 2
        ]);

        //Referencias
        Modulo::create([
            'name' => 'centroscosto',
            'display_name' => 'Centros de costo',
            'nivel1' => 5,
            'nivel2' => 3,
            'nivel3' => 1
        ]);

        Modulo::create([
            'name' => 'documentos',
            'display_name' => 'Documentos',
            'nivel1' => 5,
            'nivel2' => 3,
            'nivel3' => 2
        ]);

        Modulo::create([
            'name' => 'folders',
            'display_name' => 'Folders',
            'nivel1' => 5,
            'nivel2' => 3,
            'nivel3' => 3
        ]);

        Modulo::create([
            'name' => 'plancuentas',
            'display_name' => 'Plan de cuentas',
            'nivel1' => 5,
            'nivel2' => 3,
            'nivel3' => 4
        ]);

        Modulo::create([
            'name' => 'plancuentasnif',
            'display_name' => 'Plan de cuentas NIF',
            'nivel1' => 5,
            'nivel2' => 3,
            'nivel3' => 5
        ]);

        Modulo::create([
            'name' => 'tipoactivos',
            'display_name' => 'Tipo activos',
            'nivel1' => 5,
            'nivel2' => 3,
            'nivel3' => 6
        ]);

        // Inventario
        Modulo::create([
            'display_name' => 'Modulos',
            'nivel1' => 6,
            'nivel2' => 1
        ]);

        Modulo::create([
            'display_name' => 'Reportes',
            'nivel1' => 6,
            'nivel2' => 2
        ]);

        Modulo::create([
            'display_name' => 'Referencias',
            'nivel1' => 6,
            'nivel2' => 3
        ]);

        //Modulos
        Modulo::create([
            'name' => 'ajustes',
            'display_name' => 'Ajustes',
            'nivel1' => 6,
            'nivel2' => 1,
            'nivel3' => 1
        ]);

        Modulo::create([
            'name' => 'productos',
            'display_name' => 'Productos',
            'nivel1' => 6,
            'nivel2' => 1,
            'nivel3' => 2
        ]);

        Modulo::create([
            'name' => 'pedidos',
            'display_name' => 'Pedidos',
            'nivel1' => 6,
            'nivel2' => 1,
            'nivel3' => 3
        ]);

        Modulo::create([
            'name' => 'traslados',
            'display_name' => 'Traslados',
            'nivel1' => 6,
            'nivel2' => 1,
            'nivel3' => 4
        ]);

        Modulo::create([
            'name' => 'trasladosubicaciones',
            'display_name' => 'Traslados ubicaciones',
            'nivel1' => 6,
            'nivel2' => 1,
            'nivel3' => 5
        ]);

        // Reportes
        Modulo::create([
            'name' => 'ractivosfijos',
            'display_name' => 'Activos fijos',
            'nivel1' => 6,
            'nivel2' => 2,
            'nivel3' => 1
        ]);

        Modulo::create([
            'name' => 'rexistencias',
            'display_name' => 'Existencias',
            'nivel1' => 6,
            'nivel2' => 2,
            'nivel3' => 2
        ]);

        Modulo::create([
            'name' => 'rmovimientosproductos',
            'display_name' => 'Movimiento de producto',
            'nivel1' => 6,
            'nivel2' => 2,
            'nivel3' => 3
        ]);

        //Referencia
        Modulo::create([
            'name' => 'grupos',
            'display_name' => 'Grupos',
            'nivel1' => 6,
            'nivel2' => 3,
            'nivel3' => 1
        ]);

        Modulo::create([
            'name' => 'impuestos',
            'display_name' => 'Impuestos',
            'nivel1' => 6,
            'nivel2' => 3,
            'nivel3' => 2
        ]);

        Modulo::create([
            'name' => 'lineas',
            'display_name' => 'Lineas',
            'nivel1' => 6,
            'nivel2' => 3,
            'nivel3' => 3
        ]);

        Modulo::create([
            'name' => 'marcas',
            'display_name' => 'Marcas',
            'nivel1' => 6,
            'nivel2' => 3,
            'nivel3' => 4
        ]);

        Modulo::create([
            'name' => 'modelos',
            'display_name' => 'Modelos',
            'nivel1' => 6,
            'nivel2' => 3,
            'nivel3' => 5
        ]);

        Modulo::create([
            'name' => 'servicios',
            'display_name' => 'Servicios',
            'nivel1' => 6,
            'nivel2' => 3,
            'nivel3' => 6
        ]);

        Modulo::create([
            'name' => 'subgrupos',
            'display_name' => 'Subgrupos',
            'nivel1' => 6,
            'nivel2' => 3,
            'nivel3' => 7
        ]);

        Modulo::create([
            'name' => 'tiposajuste',
            'display_name' => 'Tipos de ajuste',
            'nivel1' => 6,
            'nivel2' => 3,
            'nivel3' => 8
        ]);

        Modulo::create([
            'name' => 'tipostraslados',
            'display_name' => 'Tipos de traslado',
            'nivel1' => 6,
            'nivel2' => 3,
            'nivel3' => 9
        ]);

        Modulo::create([
            'name' => 'tiposproducto',
            'display_name' => 'Tipos de producto',
            'nivel1' => 6,
            'nivel2' => 3,
            'nivel3' => 10
        ]);

        Modulo::create([
            'name' => 'unidades',
            'display_name' => 'Unidades',
            'nivel1' => 6,
            'nivel2' => 3,
            'nivel3' => 11
        ]);

        // Tecnico
        Modulo::create([
            'display_name' => 'Modulos',
            'nivel1' => 7,
            'nivel2' => 1
        ]);

        Modulo::create([
            'display_name' => 'Reportes',
            'nivel1' => 7,
            'nivel2' => 2
        ]);

        Modulo::create([
            'display_name' => 'Referencias',
            'nivel1' => 7,
            'nivel2' => 3
        ]);

        //Modulos
        Modulo::create([
            'name' => 'agendatecnica',
            'display_name' => 'Agenda tecnica',
            'nivel1' => 7,
            'nivel2' => 1,
            'nivel3' => 1
        ]);

        Modulo::create([
            'name' => 'gestionestecnico',
            'display_name' => 'Gestión tecnico',
            'nivel1' => 7,
            'nivel2' => 1,
            'nivel3' => 2
        ]);

        Modulo::create([
            'name' => 'ordenes',
            'display_name' => 'Ordenes',
            'nivel1' => 7,
            'nivel2' => 1,
            'nivel3' => 3
        ]);

        // Reportes
        Modulo::create([
            'name' => 'rordenesabiertas',
            'display_name' => 'Ordenes abiertas',
            'nivel1' => 7,
            'nivel2' => 2,
            'nivel3' => 1
        ]);

        //Referencias
        Modulo::create([
            'name' => 'conceptostecnico',
            'display_name' => 'Concepto tecnico',
            'nivel1' => 7,
            'nivel2' => 3,
            'nivel3' => 1
        ]);

        Modulo::create([
            'name' => 'danos',
            'display_name' => 'Daños',
            'nivel1' => 7,
            'nivel2' => 3,
            'nivel3' => 2
        ]);

        Modulo::create([
            'name' => 'prioridades',
            'display_name' => 'Prioridades',
            'nivel1' => 7,
            'nivel2' => 3,
            'nivel3' => 3
        ]);

        Modulo::create([
            'name' => 'sitios',
            'display_name' => 'Sitios de atencion',
            'nivel1' => 7,
            'nivel2' => 3,
            'nivel3' => 4
        ]);

        Modulo::create([
            'name' => 'solicitantes',
            'display_name' => 'Solicitantes',
            'nivel1' => 7,
            'nivel2' => 3,
            'nivel3' => 5
        ]);

        Modulo::create([
            'name' => 'tiposorden',
            'display_name' => 'Tipo de Orden',
            'nivel1' => 7,
            'nivel2' => 3,
            'nivel3' => 6
        ]);

        // Tesorería
        Modulo::create([
            'display_name' => 'Modulos',
            'nivel1' => 8,
            'nivel2' => 1
        ]);

        Modulo::create([
            'display_name' => 'Reportes',
            'nivel1' => 8,
            'nivel2' => 2
        ]);

        Modulo::create([
            'display_name' => 'Referencias',
            'nivel1' => 8,
            'nivel2' => 3
        ]);

        //Modulos
        Modulo::create([
            'name' => 'ajustesp',
            'display_name' => 'Ajustes proveedor',
            'nivel1' => 8,
            'nivel2' => 1,
            'nivel3' => 1
        ]);

        Modulo::create([
            'name' => 'egresos',
            'display_name' => 'Egresos',
            'nivel1' => 8,
            'nivel2' => 1,
            'nivel3' => 2
        ]);

        Modulo::create([
            'name' => 'facturasp',
            'display_name' => 'Facturas proveedor',
            'nivel1' => 8,
            'nivel2' => 1,
            'nivel3' => 3
        ]);

        // Reportes
        Modulo::create([
            'name' => 'rcarteraedadesproveedores',
            'display_name' => 'Cartera proveedor',
            'nivel1' => 8,
            'nivel2' => 2,
            'nivel3' => 1
        ]);

        Modulo::create([
            'name' => 'rhistorialproveedores',
            'display_name' => 'Historial proveedor',
            'nivel1' => 8,
            'nivel2' => 2,
            'nivel3' => 2
        ]);

        //Referencias
        Modulo::create([
            'name' => 'conceptosajustep',
            'display_name' => 'Concepto ajuste proveedor',
            'nivel1' => 8,
            'nivel2' => 3,
            'nivel3' => 1
        ]);

        Modulo::create([
            'name' => 'retefuentes',
            'display_name' => 'Retención de fuente',
            'nivel1' => 8,
            'nivel2' => 3,
            'nivel3' => 2
        ]);

        Modulo::create([
            'name' => 'tipogastos',
            'display_name' => 'Tipo de gasto',
            'nivel1' => 8,
            'nivel2' => 3,
            'nivel3' => 3
        ]);

        Modulo::create([
            'name' => 'tipopagos',
            'display_name' => 'Tipo de pago',
            'nivel1' => 8,
            'nivel2' => 3,
            'nivel3' => 4
        ]);

        Modulo::create([
            'name' => 'tipoproveedores',
            'display_name' => 'Tipo de proveedor',
            'nivel1' => 8,
            'nivel2' => 3,
            'nivel3' => 5
        ]);
    }
}
