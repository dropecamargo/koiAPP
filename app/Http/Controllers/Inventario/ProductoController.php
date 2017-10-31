<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB, Log, Datatables;
use App\Models\Base\Sucursal;
use App\Models\Inventario\Producto, App\Models\Inventario\Prodbode, App\Models\Inventario\Impuesto, App\Models\Inventario\TipoAjuste, App\Models\Base\Tercero, App\Models\Base\Contacto, App\Models\Inventario\Servicio;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Producto::query();
            $query->select('producto.id as id', 'producto_serie', 'producto_nombre','producto_referencia','producto_costo','producto_precio1','impuesto.impuesto_porcentaje');
            $query->join('impuesto', 'producto.producto_impuesto', '=', 'impuesto.id');
            // Persistent data filter
            if($request->has('persistent') && $request->persistent) {
                session(['search_producto_referencia' => $request->has('producto_referencia') ? $request->producto_referencia : '']);
                session(['search_producto_serie' => $request->has('producto_serie') ? $request->producto_serie : '']);
                session(['search_producto_nombre' => $request->has('producto_nombre') ? $request->producto_nombre : '']);
            }

            return Datatables::of($query)
                ->filter(function($query) use($request) {
                    // Serie
                    if($request->has('producto_serie')) {
                        $query->whereRaw("producto_serie LIKE '%{$request->producto_serie}%'");
                    }
                    //Referencia
                    if($request->has('producto_referencia')) {
                        $query->whereRaw("producto_serie LIKE '%{$request->producto_referencia}%'");
                    }

                    // Nombre
                    if($request->has('producto_nombre')) {
                        $query->whereRaw("producto_nombre LIKE '%{$request->producto_nombre}%'");
                    }
                    //Ref and Serie equals filter
                    if ($request->has('equalsRef')) {
                        if($request->equalsRef == "true"){
                            $query->whereRaw('producto_serie = producto_referencia');
                        }else{
                            $query->select('producto.id as id','impuesto.impuesto_porcentaje','producto_maneja_serie','producto_serie', 'producto_nombre','producto_referencia','producto_costo','producto_precio1','prodbode.prodbode_cantidad','prodbode_serie', 'prodbode_sucursal');
                            $query->join('prodbode', 'producto.id','=','prodbode.prodbode_serie');
                            $query->whereRaw('prodbode_cantidad > 0');
                            $sucursal = Sucursal::find($request->officeSucursal);
                            ($sucursal instanceof Sucursal) ? $query->where('prodbode_sucursal', $sucursal->id) : '' ;
                            $query->groupBy('prodbode_serie');
                        }
                    }

                    // Orden only serie filter
                    if ($request->has('orden')) {
                        if($request->orden == "true"){
                            $query->where('producto_maneja_serie', true);
                            $query->where('producto_unidad', true);
                        }
                    }

                    // remision and sucursal filter
                    if ($request->has('remision') && $request->has('sucursal')) {
                        if( $request->remision == "true" && !empty($request->sucursal)) {
                            $query->select('producto.id as id','impuesto.impuesto_porcentaje','producto_maneja_serie','producto_serie', 'producto_nombre','producto_referencia','producto_costo','producto_precio1','prodbode.prodbode_cantidad','prodbode_serie', 'prodbode_sucursal');
                            $query->join('prodbode', 'producto.id','=','prodbode.prodbode_serie');
                            $sucursal = Sucursal::find($request->sucursal);
                            ($sucursal instanceof Sucursal) ? $query->where('prodbode_sucursal', $sucursal->id) : '' ;
                            $query->whereRaw('prodbode_cantidad > 0');
                            $query->where('producto_maneja_serie', false);
                            $query->where('producto_metrado', false);
                            $query->where('producto_vence', false);
                            $query->where('producto_unidad', true);
                        }
                    }
                    if ($request->has('whitOutInventory')) {
                        $query->where('producto_maneja_serie', false);
                        $query->where('producto_metrado', false);
                        $query->where('producto_vence', false);
                        $query->where('producto_unidad', false);
                    }
                })
                ->make(true);
        }
        return view('inventario.productos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventario.productos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $producto = new Producto;
            if ($producto->isValid($data)) {

                DB::beginTransaction();
                try {
                    $impuesto = Impuesto::where('id', $request->producto_impuesto)->first();
                    if (!$impuesto instanceof Impuesto) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar IMPUESTO,verifique información ó por favor consulte al administrador.']);
                    }
                    // Producto
                    $producto->producto_serie = $request->producto_referencia;
                    $producto->fill($data);
                    $producto->producto_impuesto = $impuesto->id;
                    $producto->fillBoolean($data);
                    $producto->save();

                    // Commit Transaction
                    DB::commit();

                    return response()->json(['success' => true, 'id' => $producto->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $producto->errors]);
        }
        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $producto = Producto::getProduct($id);
        if($producto instanceof Producto){
            if ( $request->ajax() ) {
                return response()->json($producto);
            }
            $prodbode  = $producto->prodbode();
            return view('inventario.productos.show', ['producto' => $producto, 'prodbode' => $prodbode]);
        }
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        return view('inventario.productos.edit', ['producto' => $producto]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $producto = Producto::findOrFail($id);
            if ($producto->isValid($data)) {
                if($producto->producto_serie != $producto->producto_referencia ) {
                    return response()->json(['success' => false, 'errors' => 'No es posible editar una serie, por favor verifique información o consulte con el administrador.']);
                }
                DB::beginTransaction();
                try {
                    // Producto
                    $producto->fill($data);
                    $producto->fillBoolean($data);
                    $producto->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $producto->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $producto->errors]);
        }
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    /**
     * Evaluate actions detail asiento.
     *
     * @return \Illuminate\Http\Response
     */
    public function evaluate(Request $request)
    {
        $tipoMovimiento = '';
        // Prepare response
        $response = new \stdClass();
        $response->action = "";
        $response->tipo = "";
        $response->success = false;
        if ($request->has('tipoajuste')) {
            $tipoajuste = TipoAjuste::find($request->tipoajuste);
            if (!$tipoajuste instanceof TipoAjuste) {
                $response->errors = "No es posible recuperar TIPO AJUSTE,verifique información ó por favor consulte al administrador.";
            }
            $tipoMovimiento = $tipoajuste->tipoajuste_tipo;
        }else{
            $tipoMovimiento = $request->tipo;
        }

        $producto = Producto::where('producto_serie', $request->producto_serie)->first();
        if (!$producto instanceof Producto) {
            $response->errors = "No es posible recuperar PRODUCTO,verifique información ó por favor consulte al administrador.";
        }

        if ($producto->producto_unidad == true) {
            if($tipoMovimiento == 'E'){
                if ($producto->producto_maneja_serie == true) {
                    $action = 'modalSerie';
                    $response->action = $action;
                    $response->tipo = $tipoMovimiento;
                    $response->success = true;
                }elseif($producto->producto_metrado == true){
                    $action = 'ProductoMetrado';
                    $response->action = $action;
                    $response->tipo = $tipoMovimiento;
                    $response->success = true;
                }elseif($producto->producto_vence == true){
                    $action = 'ProductoVence';
                    $response->action = $action;
                    $response->tipo = $tipoMovimiento;
                    $response->success = true;
                }else{
                    $action = 'NoSerieNoMetros';
                    $response->action = $action;
                    $response->tipo = $tipoMovimiento;
                    $response->success = true;
                }
            }else{
                $productoBode = Prodbode::where('prodbode_serie', $producto->id)->where('prodbode_sucursal' ,$request->sucursal)->where('prodbode_cantidad','>', 0)->orWhere('prodbode_metros','>', 0)->first();
                if ($productoBode instanceof Prodbode) {
                    if($productoBode->prodbode_cantidad > 0){
                        if ($producto->producto_maneja_serie == true) {
                            //Salidas Series
                            $action = 'modalSerie';
                            $response->action = $action;
                            $response->tipo = $tipoMovimiento;
                            $response->success = true;
                        }elseif($producto->producto_metrado == true){
                            $action = 'ProductoMetrado';
                            $response->action = $action;
                            $response->tipo = $tipoMovimiento;
                            $response->success = true;
                        }elseif($producto->producto_vence == true){
                            $action = 'ProductoVence';
                            $response->action = $action;
                            $response->tipo = $tipoMovimiento;
                            $response->success = true;
                        }else{
                            $action = 'NoSerieNoMetros';
                            $response->action = $action;
                            $response->tipo = $tipoMovimiento;
                            $response->success = true;
                        }
                    }else{
                        $response->errors = "No hay unidades en BODEGA de esta SUCURSAL,verifique información ó por favor consulte al administrador.";
                        $response->success = false;
                    }
                }else{
                    $response->errors = "No es posible recuperar PRODUCTO en PRODBODE,verifique información ó por favor consulte al administrador.";
                    $response->success = false;
                }
            }
        }else{
            $response->errors = "No es posible realizar movimientos para productos que no manejan unidades";
            $response->success = false;
        }

        return response()->json($response);
    }
    /**
     * Validate actions detail asiento.
     *
     * @return \Illuminate\Http\Response
     */
    public function validation(Request $request)
    {
        // Prepare response
        $response = new \stdClass();
        $response->success = false;
        $response->asiento2_valor = $request->asiento2_valor;


        $response->errors = 'No es posible definir acción a validar, por favor verifique la información del asiento o consulte al administrador.';
        return response()->json($response);
    }

    /**
     * Search producto.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        if($request->has('producto_serie')) {
            $query = Producto::query();
            $query->select('producto.id as id', 'producto_nombre', 'producto_serie','producto_costo','producto_precio1','impuesto.impuesto_porcentaje');
            $query->join('impuesto','producto_impuesto', '=', 'impuesto.id');
            $query->where('producto_serie', $request->producto_serie);
            $producto = $query->first();
            if($producto instanceof Producto) {
                return response()->json(['success' => true, 'id' => $producto->id, 'producto_nombre' => $producto->producto_nombre, 'producto_serie' => $producto->producto_serie ,'producto_costo'=>$producto->producto_costo, 'producto_precio1'=>$producto->producto_precio1, 'impuesto_porcentaje'=> $producto->impuesto_porcentaje]);
            }
        }
        return response()->json(['success' => false]);
    }

    /**
     * store serie.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeserie(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            $producto = Producto::findOrFail($request->producto_id);
            if(!$producto instanceof Producto){
                return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique información o consulte con el administrador.']);
            }

            if($producto->producto_serie != $producto->producto_referencia ) {
                return response()->json(['success' => false, 'errors' => 'No es posible editar una serie que no es padre, por favor verifique información o consulte con el administrador.']);
            }

            if( empty($request->producto_serie) ) {
                return response()->json(['success' => false, 'errors' => 'El campo serie es obligatorio.']);
            }

            if( $producto->producto_nombre != $request->producto_nombre ){
                return response()->json(['success' => false, 'errors' => 'El nombre del producto no se valido, por favor verifique información o consulte con el administrador.']);
            }

            if( $producto->producto_referencia != $request->producto_referencia ){
                return response()->json(['success' => false, 'errors' => 'La referencia del producto no se valido, por favor verifique información o consulte con el administrador.']);
            }

            // Recuperar servicio por defecto -> cliente
            $servicio = Servicio::where('servicio_nombre' ,'CLIENTE')->first();
            if( !$servicio instanceof Servicio ){
                return response()->json(['success' => false, 'errors' => 'El servicio CLIENTE no existe, por favor verifique información o consulte con el administrador.']);
            }

            DB::beginTransaction();
            try {
                // Producto
                $result = $producto->replicate();
                $result->producto_serie = $request->producto_serie;
                $result->producto_servicio = $servicio->id;
                $result->save();

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'msg' => 'Se agrego la serie de forma exitosa.']);
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(404);
    }

    /**
     * Update machine.
     *
     * @return \Illuminate\Http\Response
     */
    public function machine(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            $producto = Producto::findOrFail($request->producto_id);
            if(!$producto instanceof Producto){
                return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique información o consulte con el administrador.']);
            }

            if($producto->producto_serie == $producto->producto_referencia ) {
                return response()->json(['success' => false, 'errors' => 'No es posible editar una serie padre, por favor verifique información o consulte con el administrador.']);
            }

            if( empty($request->producto_vencimiento) ) {
                return response()->json(['success' => false, 'errors' => 'El campo vencimiento es obligatorio.']);
            }

            if( empty($request->producto_servicio) ) {
                return response()->json(['success' => false, 'errors' => 'El campo servicio es obligatorio.']);
            }

            DB::beginTransaction();
            try {
                // Recuperar servicio && tercero && contacto
                $tercero = Tercero::where('tercero_nit', $request->producto_tercero)->first();
                if(!$tercero instanceof Tercero){
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar el tercero, por favor verifique información o consulte con el administrador.']);
                }
                $contacto = Contacto::find($request->producto_contacto);
                if(!$contacto instanceof Contacto){
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar el contacto, por favor verifique información o consulte con el administrador.']);
                }
                $servicio = Servicio::find($request->producto_servicio);
                if(!$servicio instanceof Servicio){
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar el servicio, por favor verifique información o consulte con el administrador.']);
                }

                // Validar contacto a tercero
                if($contacto->tcontacto_tercero != $tercero->id){
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'El contacto no corresponde al cliente. por favor verifique la información o consulte al administrador.']);
                }

                // Producto
                $producto->producto_tercero = $tercero->id;
                $producto->producto_contacto = $contacto->id;
                $producto->producto_servicio = $servicio->id;
                $producto->producto_vencimiento = $request->producto_vencimiento;
                $producto->save();

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'msg' => 'Se actualizo la informacion de la maquina de forma exitosa.']);
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(404);
    }
    /**
     * Validate productos referencia.
     *
     * @return \Illuminate\Http\Response
     */
    public function referencia(Request $request)
    {
        if ($request->has('producto_referencia')) {
             // Valid referencia 
            if (! Producto::isValidReferencia($request->all())) {
                return response()->json(['success' => false, 'errors' => "El nit $request->producto_referencia ya se encuentra registrado"]);
            }
            return response()->json(['success' => true ]);
        }
    }
}
