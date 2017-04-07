<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB, Log, Datatables;

use App\Models\Inventario\Producto,App\Models\Inventario\Prodbode,App\Models\Inventario\Impuesto,App\Models\Inventario\TipoAjuste;

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
            $query->select('producto.id as id', 'producto_serie', 'producto_nombre','producto_referencia','producto_costo');

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
                            $query->select('producto.id as id','producto_maneja_serie','producto_serie', 'producto_nombre','producto_referencia','producto_costo','prodbode.id','prodbode.prodbode_cantidad','prodbode_serie');
                            $query->join('prodbode', 'producto.id','=','prodbode.prodbode_serie');
                            $query->whereRaw('prodbode_cantidad > 0');
                        }
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
        $prodbode = Prodbode::getProdBode($id);

        if($producto instanceof Producto){
            if ($request->ajax()) {
                return response()->json($producto);
            }
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
                // if($producto->id != $producto->producto_referencia ) {
                //     return response()->json(['success' => false, 'errors' => 'No es posible editar una serie, para modificar comportamiento por favor modifique la referencia padre.']);
                // }

                DB::beginTransaction();
                try {
                    // Producto
                    $producto->producto_serie = $request->producto_referencia;
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
        // Prepare response
        $response = new \stdClass();
        $response->action = "";
        $response->tipoajuste = "";
        $response->success = false;

        $tipoajuste = TipoAjuste::find($request->tipoajuste);
        if (!$tipoajuste instanceof TipoAjuste) {            
            $response->errors = "No es posible recuperar TIPO AJUSTE,verifique información ó por favor consulte al administrador.";
        }
        $producto = Producto::where('producto_serie', $request->ajuste2_producto)->first();
        if (!$producto instanceof Producto) {
            $response->errors = "No es posible recuperar PRODUCTO,verifique información ó por favor consulte al administrador.";
        }

        if ($producto->producto_unidad == true) {
            if($tipoajuste->tipoajuste_tipo == 'E'){
                if ($producto->producto_maneja_serie == true) {
                    $action = 'modalSerie';
                    $response->action = $action;   
                    $response->tipoajuste = $tipoajuste->tipoajuste_tipo;
                    $response->success = true;
                }elseif($producto->producto_metrado == true){
                    $action = 'ProductoMetrado';
                    $response->action = $action;   
                    $response->tipoajuste = $tipoajuste->tipoajuste_tipo;
                    $response->success = true;
                }else{
                    $action = 'NoSerieNoMetros';
                    $response->action = $action;   
                    $response->tipoajuste = $tipoajuste->tipoajuste_tipo;
                    $response->success = true;
                }  
            }else{
                $productoBode = Prodbode::where('prodbode_serie', $producto->id)->where('prodbode_sucursal' ,$request->sucursal)->first();
                if ($productoBode instanceof Prodbode) {
                    if($productoBode->prodbode_cantidad > 0){
                        if ($producto->producto_maneja_serie == true) {
                            //Salidas Series
                            $action = 'modalSerie';
                            $response->action = $action;   
                            $response->tipoajuste = $tipoajuste->tipoajuste_tipo;
                            $response->success = true;
                        }elseif($producto->producto_metrado == true){
                            $action = 'ProductoMetrado';
                            $response->action = $action;   
                            $response->tipoajuste = $tipoajuste->tipoajuste_tipo;
                            $response->success = true;
                        }else{
                            $action = 'NoSerieNoMetros';
                            $response->action = $action;   
                            $response->tipoajuste = $tipoajuste->tipoajuste_tipo;
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
            $producto = Producto::select('id', 'producto_nombre', 'producto_serie','producto_costo')->where('producto_serie', $request->producto_serie)->first();
            if($producto instanceof Producto) {
                return response()->json(['success' => true, 'id' => $producto->id, 'producto_nombre' => $producto->producto_nombre, 'producto_serie' => $producto->producto_serie ,'producto_costo'=>$producto->producto_costo]);
            }
        }
        return response()->json(['success' => false]);
    }
}
