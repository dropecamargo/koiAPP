<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Routes Auth
|--------------------------------------------------------------------------
*/
Route::post('login', ['as' => 'login', 'uses' => 'Auth\AuthController@postLogin']);
Route::get('login', ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);
Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);

Route::group(['middleware' => 'auth'], function(){
	Route::get('/', ['as' => 'dashboard', 'uses' => 'HomeController@index']);

	/*
	|-------------------------
	| Admin Routes
	|-------------------------
	*/
	Route::group(['prefix' => 'terceros'], function()
	{
		Route::get('dv', ['as' => 'terceros.dv', 'uses' => 'Admin\TerceroController@dv']);
		Route::get('rcree', ['as' => 'terceros.rcree', 'uses' => 'Admin\TerceroController@rcree']);
		Route::get('search', ['as' => 'terceros.search', 'uses' => 'Admin\TerceroController@search']);
		Route::post('setpassword', ['as' => 'terceros.setpassword', 'uses' => 'Admin\TerceroController@setpassword']);
		Route::resource('contactos', 'Admin\ContactoController', ['only' => ['index', 'store', 'update']]);
		Route::resource('roles', 'Admin\UsuarioRolController', ['only' => ['index', 'store', 'destroy']]);
	});

	/*
	|--------------------------
	| Admin Routes
	|--------------------------
	*/
	Route::resource('empresa', 'Admin\EmpresaController', ['only' => ['index', 'update']]);
	Route::resource('terceros', 'Admin\TerceroController', ['except' => ['destroy']]);
	Route::resource('actividades', 'Admin\ActividadController', ['except' => ['destroy']]);
	Route::resource('departamentos', 'Admin\DepartamentoController', ['only' => ['index', 'show']]);
	Route::resource('municipios', 'Admin\MunicipioController', ['only' => ['index']]);
	Route::resource('paises', 'Admin\PaisController', ['only' => ['index']]);
	Route::resource('sucursales', 'Admin\SucursalController', ['except' => ['destroy']]);
	Route::resource('ubicaciones', 'Admin\UbicacionController', ['except' => ['destroy']]);
	Route::resource('notificaciones', 'Admin\NotificacionController', ['only' => ['index','update']]);

	Route::resource('regionales', 'Admin\RegionalController', ['except' => ['destroy']]);
	Route::resource('puntosventa', 'Admin\PuntoVentaController', ['except' => ['destroy']]);
	Route::resource('tiposactividad', 'Admin\TipoActividadController', ['except' => ['destroy']]);
	Route::resource('bitacoras','Admin\BitacoraController', ['only' => ['index']]);
	Route::group(['prefix' => 'documento'],function()
	{
		Route::post('evaluate', ['as' => 'documento.evaluate', 'uses' => 'Admin\DocumentosController@evaluate']);
	});
	Route::resource('documento', 'Admin\DocumentosController', ['except' => ['destroy']]);

	Route::group(['prefix' => 'roles'], function()
	{
		Route::resource('permisos', 'Admin\PermisoRolController', ['only' => ['index', 'update', 'destroy']]);
	});

	Route::resource('roles', 'Admin\RolController', ['except' => ['destroy']]);
    Route::resource('permisos', 'Admin\PermisoController', ['only' => ['index']]);
    Route::resource('modulos', 'Admin\ModuloController', ['only' => ['index']]);

	/*
	|--------------------------
	| Comercial Routes
	|--------------------------
	*/
	Route::group(['prefix' => 'pedidosc'], function()
	{
		Route::resource('detalle', 'Comercial\DetallePedidoController');
	});
	Route::resource('presupuestoasesor', 'Comercial\PresupuestoAsesorController', ['only' => ['index', 'store']]);
	Route::resource('pedidosc', 'Comercial\PedidoController',['except' => ['destroy']]);
	Route::resource('conceptoscomercial', 'Comercial\ConceptoComercialController',['except' => ['destroy']]);
	Route::resource('gestionescomercial', 'Comercial\GestionComercialController',['except' => ['destroy']]);


	/*
	|--------------------------
	| Contabilidad Routes
	|--------------------------
	*/
	Route::resource('documentos', 'Contabilidad\DocumentoController', ['except' => ['destroy']]);
	Route::resource('folders', 'Contabilidad\FolderController', ['except' => ['destroy']]);
	Route::resource('centroscosto', 'Contabilidad\CentroCostoController', ['except' => ['destroy']]);
	Route::resource('tipoactivos', 'Contabilidad\TipoActivoController', ['except' => ['destroy']]);
	Route::resource('activosfijos', 'Contabilidad\ActivoFijoController', ['except' => ['destroy']]);

	Route::group(['prefix' => 'plancuentas'], function()
	{
		Route::get('nivel', ['as' => 'plancuentas.nivel', 'uses' => 'Contabilidad\PlanCuentasController@nivel']);
		Route::get('search', ['as' => 'plancuentas.search', 'uses' => 'Contabilidad\PlanCuentasController@search']);
	});
    Route::resource('plancuentas', 'Contabilidad\PlanCuentasController', ['except' => ['destroy']]);

	Route::group(['prefix' => 'asientos'], function()
	{
		Route::resource('detalle', 'Contabilidad\DetalleAsientoController', ['only' => ['index', 'store', 'destroy']]);
		Route::get('exportar/{asientos}', ['as' => 'asientos.exportar', 'uses' => 'Contabilidad\AsientoController@exportar']);

		Route::group(['prefix' => 'detalle'], function()
		{
			Route::post('evaluate', ['as' => 'asientos.detalle.evaluate', 'uses' => 'Contabilidad\DetalleAsientoController@evaluate']);
			Route::post('validate', ['as' => 'asientos.detalle.validate', 'uses' => 'Contabilidad\DetalleAsientoController@validation']);
			Route::get('movimientos', ['as' => 'asientos.detalle.movimientos', 'uses' => 'Contabilidad\DetalleAsientoController@movimientos']);
		});
	});
	Route::resource('asientos', 'Contabilidad\AsientoController', ['only' => ['index', 'create', 'store', 'edit', 'update', 'show']]);
    /*
	|-------------------------
	| Reportes Routes
	|-------------------------
	*/
	Route::resource('rmayorbalance', 'Reporte\MayorBalanceController', ['only' => ['index']]);
   	Route::resource('rplancuentas', 'Reporte\PlanCuentasController', ['only' => ['index']]);

   	/*
	|-------------------------
	| Inventario Routes
	|-------------------------
	*/
	Route::group(['prefix' => 'productos'], function()
	{
		Route::get('search', ['as' => 'productos.search', 'uses' => 'Inventario\ProductoController@search']);
		Route::resource('rollos', 'Inventario\RolloController', ['only' => ['index']]);
		Route::resource('lotes', 'Inventario\LoteController', ['only' => ['index']]);
		Route::post('evaluate',['as' =>'productos.evaluate','uses'=>'Inventario\ProductoController@evaluate'] );
		Route::post('validate',['as' =>'productos.validate','uses'=>'Inventario\ProductoController@validation'] );
		Route::put('machine',['as' =>'productos.machine','uses'=>'Inventario\ProductoController@machine'] );
		Route::post('storeserie',['as' =>'productos.storeserie','uses'=>'Inventario\ProductoController@storeserie'] );
		Route::resource('prodbode', 'Inventario\ProdbodeController', ['only' => ['index']]);
	});

	Route::group(['prefix' => 'pedidos'], function()
	{
		Route::resource('detalle', 'Inventario\DetallePedidoController');
		Route::get('cerrar/{pedidos}', ['as' => 'pedidos.cerrar', 'uses' => 'Inventario\PedidoController@cerrar']);
		Route::get('anular/{pedidos}', ['as' => 'pedidos.anular', 'uses' => 'Inventario\PedidoController@anular']);
	});

	Route::group(['prefix' => 'ajustes'], function()
	{
		Route::resource('detalle', 'Inventario\DetalleAjusteController');
		Route::get('exportar/{ajustes}', ['as' => 'ajustes.exportar', 'uses' => 'Inventario\AjusteController@exportar']);
		Route::get('alistar/{ajustes}', ['as' => 'ajustes.alistar', 'uses' => 'Inventario\AjusteController@alistar']);
	});
	Route::group(['prefix' => 'traslados'], function()
	{
		Route::resource('detalle', 'Inventario\DetalleTrasladoController');
	});
	Route::group(['prefix' => 'trasladosubicaciones'], function()
	{
		Route::resource('detalle', 'Inventario\DetalleTrasladoUbicacionController');
	});

	Route::group(['prefix' => 'entradas'], function()
	{
		Route::resource('detalle', 'Inventario\EntradaDetalleController');
	});
	Route::resource('modelos','Inventario\ModeloController', ['except' => ['destroy']]);
	Route::resource('marcas', 'Inventario\MarcaController', ['except' => ['destroy']]);
	Route::resource('categorias', 'Inventario\CategoriaController', ['except' => ['destroy']]);
	Route::resource('impuestos', 'Inventario\ImpuestoController', ['except' => ['destroy']]);
	Route::resource('pedidos', 'Inventario\PedidoController', ['except' => ['destroy']]);
	Route::resource('productos', 'Inventario\ProductoController', ['except' => ['destroy']]);
	Route::resource('lineas', 'Inventario\LineaController', ['except' => ['destroy']]);
	Route::resource('unidades', 'Inventario\UnidadesMedidaController', ['except' => ['destroy']]);
	Route::resource('ajustes', 'Inventario\AjusteController', ['except' => ['edit','destroy']]);
	Route::resource('traslados', 'Inventario\TrasladoController', ['except' => ['edit','destroy']]);
	Route::resource('trasladosubicaciones', 'Inventario\TrasladoUbicacionController', ['except' => ['edit','destroy']]);
	Route::resource('tiposajuste', 'Inventario\TipoAjusteController', ['except' => ['destroy']]);
	Route::resource('tipostraslados', 'Inventario\TipoTrasladoController', ['except' => ['destroy']]);
	Route::resource('subcategorias', 'Inventario\SubCategoriaController', ['except' => ['destroy']]);
	Route::resource('servicios', 'Inventario\ServicioController', ['except' => ['edit','destroy']]);
	Route::resource('unidadesnegocio', 'Inventario\UnidadNegocioController', ['except' => ['destroy']]);

   	/*
	|-------------------------
	| Cartera Routes
	|-------------------------
	*/
	Route::group(['prefix' => 'recibos'], function()
	{
		Route::resource('detalle', 'Cartera\Recibo2Controller');
		Route::resource('factura', 'Cartera\Factura3Controller');
		Route::resource('mediopago', 'Cartera\Recibo3Controller');
	});

	Route::group(['prefix' => 'anticipos'], function()
	{
		Route::resource('mediopago', 'Cartera\Anticipo2Controller');
		Route::resource('detalle', 'Cartera\Anticipo3Controller');
	});
	Route::group(['prefix' => 'cheques'], function()
	{
		Route::resource('detalle', 'Cartera\ChposFechado2Controller');
		Route::get('anular/{cheques}', ['as' => 'cheques.anular', 'uses' => 'Cartera\ChposFechado1Controller@anular']);
	});

	Route::group(['prefix' => 'conceptosrc'], function()
	{
		Route::post('evaluate',['as' =>'conceptosrc.evaluate','uses'=>'Cartera\ConceptosrcController@evaluate'] );
	});

	Route::group(['prefix' => 'notas'], function()
	{
		Route::resource('detalle', 'Cartera\Nota2Controller');
	});

	Route::group(['prefix' => 'facturas'], function()
	{
		Route::resource('detalle', 'Cartera\Factura2Controller');
		Route::get('search', ['as' => 'facturas.search', 'uses' => 'Cartera\Factura1Controller@search']);
		Route::get('anular/{facturas}', ['as' => 'facturas.anular', 'uses' => 'Cartera\Factura1Controller@anular']);
		Route::get('exportar/{facturas}', ['as' => 'facturas.exportar', 'uses' => 'Cartera\Factura1Controller@exportar']);
	});
	Route::group(['prefix' => 'devoluciones'], function()
	{
		Route::resource('detalle', 'Cartera\Devolucion2Controller',['execpt' => ['destroy']]);
	});

	Route::group(['prefix' => 'ajustesc'], function()
	{
		Route::resource('detalle', 'Cartera\Ajustec2Controller');
	});

	Route::resource('autorizacionesca', 'Cartera\AutorizaCaController', ['only' => ['index']]);
	Route::resource('bancos', 'Cartera\BancoController', ['except' => ['destroy']]);
	Route::resource('causas', 'Cartera\CausalController', ['except' => ['destroy']]);
	Route::resource('cuentabancos', 'Cartera\CuentaBancoController', ['except' => ['destroy']]);
	Route::resource('mediopagos', 'Cartera\MedioPagoController', ['except' => ['destroy']]);
	Route::resource('conceptosrc', 'Cartera\ConceptosrcController', ['except' => ['destroy']]);
	Route::resource('conceptonotas', 'Cartera\ConceptoNotaController', ['except' => ['destroy']]);
	Route::resource('conceptocobros', 'Cartera\ConceptoCobroController', ['except' => ['destroy']]);
	Route::resource('recibos', 'Cartera\Recibo1Controller', ['only' => ['index','create','store','show']]);
	Route::resource('notas', 'Cartera\Nota1Controller', ['only' => ['index','create','store','show']]);
	Route::resource('facturas', 'Cartera\Factura1Controller', ['except' => ['destroy', 'edit' , 'update']]);
	Route::resource('devoluciones', 'Cartera\Devolucion1Controller', ['except' => ['destroy', 'edit' , 'update']]);
	Route::resource('gestioncobros', 'Cartera\GestionCobroController', ['except' => ['destroy', 'edit' , 'update']]);
	Route::resource('conceptosajustec', 'Cartera\ConceptoAjustecController', ['except' => ['destroy']]);
	Route::resource('ajustesc', 'Cartera\Ajustec1Controller', ['except' => ['destroy']]);
	Route::resource('anticipos', 'Cartera\AnticipoController', ['except' => ['destroy']]);
	Route::resource('cheques', 'Cartera\ChposFechado1Controller', ['except' => ['destroy']]);
	Route::resource('chequesdevueltos', 'Cartera\ChDevueltoController', ['except' => ['destroy']]);
	Route::resource('carteraterceros', 'Cartera\CarteraController', ['only' => ['index']]);

	/*
	|-------------------------
	| Tecnico Routes
	|-------------------------
	*/
	Route::group(['prefix'=>'ordenes'],function()
	{
		Route::resource('visitas','Tecnico\VisitaController',['only'=>['index', 'store', 'destroy']]);
		Route::resource('remrepuestos','Tecnico\RemRepuController',['only'=>['index', 'store']]);
		Route::resource('imagenes','Tecnico\OrdenImagenController',['only'=>['index', 'store', 'destroy']]);
		Route::get('cerrar/{ordenes}', ['as' => 'ordenes.cerrar', 'uses' => 'Tecnico\OrdenController@cerrar']);
		Route::get('mail/{ordenes}', ['as' => 'ordenes.mail', 'uses' => 'Tecnico\OrdenController@mail']);

		Route::group(['prefix' => 'detalle'],function(){
			Route::resource('remrepuestos','Tecnico\RemRepuDetalleController',['only'=>['index', 'store', 'update']]);
			Route::post('legalizacion', ['as' => 'ordenes.detalle.remrepuestos.legalizacion', 'uses' => 'Tecnico\RemRepuDetalleController@legalizacion']);
		});
	});

	Route::resource('ordenes', 'Tecnico\OrdenController', ['except' => ['destroy']]);
	Route::resource('danos', 'Tecnico\DanoController', ['except' => ['destroy']]);
	Route::resource('tiposorden', 'Tecnico\TipoOrdenController', ['except' => ['destroy']]);
	Route::resource('solicitantes', 'Tecnico\SolicitanteController', ['except' => ['destroy']]);
	Route::resource('prioridades', 'Tecnico\PrioridadController', ['except' => ['destroy']]);
	Route::resource('conceptostecnico', 'Tecnico\ConceptoTecController', ['except' => ['destroy']]);
	Route::resource('gestionestecnico', 'Tecnico\GestionTecnicoController', ['except' => ['destroy']]);
	Route::resource('agendatecnica', 'Tecnico\AgendaTecnicaController', ['except' => ['destroy']]);
	Route::resource('sitios', 'Tecnico\SitioController', ['except' => ['destroy']]);

	/*
	|-------------------------
	| Tesoreria Routes
	|-------------------------
	*/
	Route::group(['prefix'=>'facturasp'],function()
	{
		Route::resource('detalle','Tesoreria\Facturap2Controller',['only'=>['index', 'store', 'destroy']]);
		Route::resource('cuotas','Tesoreria\Facturap3Controller',['only'=>['index']]);
		Route::get('validate', ['as' => 'facturasp.validate', 'uses' => 'Tesoreria\Facturap1Controller@validation']);
	});

	Route::group(['prefix' => 'ajustesp'], function()
	{
		Route::resource('detalle', 'Tesoreria\AjustepDetalleController');
	});

	Route::group(['prefix' => 'egresos'], function()
	{
		Route::resource('detalle', 'Tesoreria\EgresoDetalleController');
	});

	Route::resource('facturasp', 'Tesoreria\Facturap1Controller', ['except' => ['destroy','update','edit']]);
	Route::resource('ajustesp', 'Tesoreria\AjustepController', ['except' => ['destroy']]);
	Route::resource('egresos', 'Tesoreria\EgresoController', ['except' => ['destroy']]);
	Route::resource('retefuentes', 'Tesoreria\ReteFuenteController', ['except' => ['destroy']]);
	Route::resource('tipogastos', 'Tesoreria\TipoGastoController', ['except' => ['destroy']]);
	Route::resource('tipopagos', 'Tesoreria\TipoPagoController', ['except' => ['destroy']]);
	Route::resource('tipoproveedores', 'Tesoreria\TipoProveedorController', ['except' => ['destroy']]);
	Route::resource('conceptosajustep', 'Tesoreria\ConceptoAjustepController', ['except' => ['destroy']]);
});
