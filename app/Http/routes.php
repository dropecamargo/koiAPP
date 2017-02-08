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

		Route::resource('contactos', 'Admin\ContactoController', ['only' => ['index', 'store', 'update']]);
		
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
	Route::resource('sucursales', 'Admin\SucursalController', ['except' => ['destroy']]);
	Route::resource('puntosventa', 'Admin\PuntoVentaController', ['except' => ['destroy']]);

	/*
	|--------------------------
	| Contabilidad Routes
	|--------------------------
	*/
	Route::resource('documentos', 'Contabilidad\DocumentoController', ['except' => ['destroy']]);
	Route::resource('folders', 'Contabilidad\FolderController', ['except' => ['destroy']]);
	Route::resource('centroscosto', 'Contabilidad\CentroCostoController', ['except' => ['destroy']]);
	
	Route::group(['prefix' => 'plancuentas'], function()
	{
		Route::get('nivel', ['as' => 'plancuentas.nivel', 'uses' => 'Contabilidad\PlanCuentasController@nivel']);
		Route::get('search', ['as' => 'plancuentas.search', 'uses' => 'Contabilidad\PlanCuentasController@search']);
	});
    Route::resource('plancuentas', 'Contabilidad\PlanCuentasController', ['except' => ['destroy']]);

    /*
	|-------------------------
	| Reports Routes
	|-------------------------
	*/

	Route::resource('asientos', 'Contabilidad\AsientoController', ['only' => ['index', 'create', 'store', 'edit', 'update', 'show']]);

	Route::resource('rmayorbalance', 'Reporte\MayorBalanceController', ['only' => ['index']]);
   	Route::resource('rplancuentas', 'Reporte\PlanCuentasController', ['only' => ['index']]);

});
