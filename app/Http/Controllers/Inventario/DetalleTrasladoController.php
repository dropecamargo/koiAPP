<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Base\Sucursal;
use App\Models\Inventario\Producto, App\Models\Inventario\Traslado2;

use Log, DB;

class DetalleTrasladoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $detalle = [];
            if($request->has('traslado')) {
                $query = Traslado2::query();
                $query->select('producto.id', 'traslado2_cantidad', 'traslado2_costo', 'producto_serie', 'producto_nombre');
                $query->join('producto', 'traslado2_producto', '=', 'producto.id');
                $query->where('traslado2_traslado1', $request->traslado);
                $detalle = $query->get();
            }
            return response()->json($detalle);
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
            $traslado2 = new Traslado2;
            if ($traslado2->isValid($data)) {
                try {
                    $origen = Sucursal::find($request->sucursal);
                    if (!$origen instanceof Sucursal) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar SUCURSAL DE ORIGEN, por favor verifique la información o consulte al administrador.']);
                    }
                    $destino = Sucursal::find($request->destino);
                    if (!$destino instanceof Sucursal) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar SUCURSAL DESTINO, por favor verifique la información o consulte al administrador.']);
                    }
                    if ($origen->id == $destino->id ) {
                        return response()->json(['success' => false, 'errors' => "No es posible realizar TRASLADO de $origen->sucursal_nombre a $destino->sucursal_nombre, por favor verifique la información o consulte al administrador."]);
                    }
                    $producto = Producto::where('producto_serie', $request->producto_serie)->first();
                    if(!$producto instanceof Producto) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique la información o consulte al administrador.']);
                    }

                    // Validar maneja unidades
                    if(!$producto->producto_unidad) {
                        return response()->json(['success' => false,'errors' => "No es posible realizar movimientos para productos que no manejan unidades"]);
                    }

                    if ($request->get('traslado2_cantidad') <= 0 ) {
                        return response()->json(['success' => false,'errors' => "No es posible realizar movimientos cantidad no valida, por favor verifique la información ó consulte al administrador"]);
                    }
                    if($producto->producto_maneja_serie){
                        if (!$request->has('traslado2_cantidad') || $request->traslado2_cantidad > 1 ||$request->traslado2_cantidad < 1) {
                            return response()->json(['success'=> false, 'errors' => "La cantidad de salida de {$producto->producto_nombre} debe ser de una unidad"]);
                        }
                    }else{
                        $items = isset($data['items']) ? $data['items'] : null;
                        $cantidadItems = 0.0;
                        foreach ($items as $key => $item) {
                            $cantidadItems += $item;
                        }
                        if ($cantidadItems > $request->traslado2_cantidad || $cantidadItems < $request->traslado2_cantidad || $cantidadItems == 0  ) {
                            return response()->json(['success' => false,'errors' => "Cantidad de items de  {$request->producto_nombre} no coincide con el valor de SALIDA, por favor verifique información."]);
                        }
                    }
                    
                    return response()->json(['success' => true, 'id' => uniqid(), 'id_producto'=>$producto->id,'producto_serie'=> $producto->producto_serie,'producto_nombre'=> $producto->producto_nombre]);
                }catch(\Exception $e){
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }

            return response()->json(['success' => false, 'errors' => $traslado2->errors]);
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
        //
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
