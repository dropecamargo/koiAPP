<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Cartera\Factura2;
use App\Models\Comercial\Pedidoc2;
use App\Models\Tecnico\RemRepu2;
use App\Models\Inventario\Producto;
use DB, Log;
class Factura2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            if ($request->has('codigo_pedido')) {

                $pediodoc2 = Pedidoc2::getPedidoc2($request->codigo_pedido);
                $object = new \stdClass();
                $object->model = [];
                foreach ($pediodoc2 as $value) {
                    $factura2 = Factura2::modelCreate($value);
                    $object->model[] = $factura2;
                }
                return response()->json($object->model);
            }else if($request->has('codigo_orden')) {

                $query = RemRepu2::getRemRepu2();
                $query->whereIn('remrepu2_remrepu1', DB::table('remrepu1')->select('remrepu1.id')->where('remrepu1_orden',  $request->codigo_orden) );
                $query->where('remrepu1_tipo', 'R')->whereRaw('remrepu2_facturado > 0');
                $query->orderBy('sucursal_nombre', 'desc');
                $remrepu2 = $query->get();

                $object = new \stdClass();
                $object->model = [];
                foreach ($remrepu2 as $value) {
                    $factura2 = Factura2::remRmpuModelCreate($value);
                    $object->model[] = $factura2;
                }
                return response()->json($object->model);
            }

            $factura2Detalle = Factura2::getFactura2($request->id);
            return response()->json($factura2Detalle);
        }
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            $factura2 = new Factura2;
            if ($factura2->isValid($data)) {
                try {
                    $producto = Producto::where('producto_serie', $request->producto_serie)->first();
                    if(!$producto instanceof Producto){
                        return response()->json(['success'=> false, 'errors'=>'No es posible recuperar producto, por favor consulte al administrador.']);
                    } 
                    if ($request->get('factura2_cantidad') <= 0 && $request->get('factura2_costo') == 0) {
                        return response()->json(['success' => false,'errors' => "No es posible realizar $tipoAjuste->tipoajuste_nombre, por favor verifique la información ó consulte al administrador"]);
                    }
                    if($producto->producto_maneja_serie){
                        if (!$request->has('factura2_cantidad') || $request->factura2_cantidad > 1 ||$request->factura2_cantidad < 1) {
                            return response()->json(['success'=> false, 'errors' => "La cantidad de salida de {$producto->producto_nombre} debe ser de una unidad"]);
                        }
                    }else{
                        $items = isset($data['items']) ? $data['items'] : null;
                        $cantidadItems = 0.0;
                        if ($items != null) {
                            foreach ($items as $item) {
                                $cantidadItems += $item;
                            }
                            if ($cantidadItems > $request->factura2_cantidad || $cantidadItems < $request->factura2_cantidad  || $cantidadItems == 0  ) {
                                return response()->json(['success' => false,'errors' => "Cantidad de items de  {$request->producto_nombre} no coincide con el valor de SALIDA, por favor verifique información."]);
                            }
                        }
                    }
                    return response()->json(['success' => true, 'id' => uniqid()]);
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
        }
        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            $factura2 = new Factura2;
            if ($factura2->isValid($data)) {
                try {
                    $producto = Producto::where('producto_serie', $request->producto_serie)->first();
                    if(!$producto instanceof Producto){
                        return response()->json(['success'=> false, 'errors'=>'No es posible recuperar producto, por favor consulte al administrador.']);
                    } 
                    if ($request->get('factura2_cantidad') <= 0 && $request->get('factura2_costo') == 0) {
                        return response()->json(['success' => false,'errors' => "No es posible realizar $tipoAjuste->tipoajuste_nombre, por favor verifique la información ó consulte al administrador"]);
                    }
                    if($producto->producto_maneja_serie){
                        if (!$request->has('factura2_cantidad') || $request->factura2_cantidad > 1 ||$request->factura2_cantidad < 1) {
                            return response()->json(['success'=> false, 'errors' => "La cantidad de salida de {$producto->producto_nombre} debe ser de una unidad"]);
                        }
                    }else{
                        $items = isset($data['items']) ? $data['items'] : null;
                        $cantidadItems = 0.0;
                        if ($items != null) {
                            foreach ($items as $item) {
                                $cantidadItems += $item;
                            }
                            if ($cantidadItems > $request->factura2_cantidad || $cantidadItems < $request->factura2_cantidad  || $cantidadItems == 0  ) {
                                return response()->json(['success' => false,'errors' => "Cantidad de items de  {$request->producto_nombre} no coincide con el valor de SALIDA, por favor verifique información."]);
                            }
                        }
                    }
                    return response()->json(['success' => true, 'id' => uniqid()]);
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
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
}
