<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Base\Sucursal, App\Models\Base\Ubicacion;
use App\Models\Inventario\Prodbode, App\Models\Inventario\Producto, App\Models\Inventario\TrasladoUbicacion2;

use Log, DB;

class DetalleTrasladoUbicacionController extends Controller
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
                $detalle = TrasladoUbicacion2::getTrasladoUbicacion2($request->traslado);
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
            $trasladou2 = new TrasladoUbicacion2;
            if ($trasladou2->isValid($data)) {
                try {
                    $sucursal = Sucursal::find($request->sucursal);
                    if (!$sucursal instanceof Sucursal) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar SUCURSAL, por favor verifique la información o consulte al administrador.']);
                    }
                    $origen = null;
                    // Recupero ubicacion de origen
                    if ($request->has('origen')) {
                        $origen = Ubicacion::find($request->origen);
                        if (!$origen instanceof Ubicacion) {
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar UBICACIÓN ORIGEN, por favor verifique la información o consulte al administrador.']);
                        }
                        $origen = $origen->id;
                    }
                    // Recupero ubicacion de destino
                   $destino = Ubicacion::find($request->destino);
                    if (!$destino instanceof Ubicacion) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar UBICACIÓN DESTINO, por favor verifique la información o consulte al administrador.']);
                    }
                    // Valid origen and destino are equals
                    if ($origen == $destino->id ) {
                        return response()->json(['success' => false, 'errors' => "No es posible realizar TRASLADO de $origen->ubicacion_nombre a $destino->ubicacion_nombre, por favor verifique la información o consulte al administrador."]);
                    }

                    // Recupero instancia de producto 
                    $producto = Producto::where('producto_serie', $request->producto_serie)->first();
                    if(!$producto instanceof Producto) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique la información o consulte al administrador.']);
                    }

                    // Validar maneja unidades
                    if(!$producto->producto_unidad) {
                        return response()->json(['success' => false,'errors' => "No es posible realizar movimientos para productos que no manejan unidades"]);
                    }

                    // Valid cantidad de traslado
                    if ($request->get('trasladou2_cantidad') <= 0 ) {
                        return response()->json(['success' => false,'errors' => "No es posible realizar movimientos cantidad no valida, por favor verifique la información ó consulte al administrador"]);
                    }
                    // Valido que esta ubicacion exista en prodbode con producto dentro ella 
                    $prodbode = Prodbode::where('prodbode_sucursal', $sucursal->id)->where('prodbode_serie', $producto->id)->where('prodbode_ubicacion', $origen)->first();
                    if (!$prodbode instanceof Prodbode) {
                        return response()->json(['success' => false,'errors' => "No es posible realizar movimientos en ubicacion de origen $origen->ubicacion_nombre, por favor verifique la información ó consulte al administrador"]);
                    }
                    // Valid type producto 
                    if($producto->producto_maneja_serie){
                        if (!$request->has('trasladou2_cantidad') || $request->trasladou2_cantidad > 1 ||$request->trasladou2_cantidad < 1) {
                            return response()->json(['success'=> false, 'errors' => "La cantidad de salida de {$producto->producto_nombre} debe ser de una unidad"]);
                        }
                    }else{
                        $items = isset($data['items']) ? $data['items'] : null;
                        $cantidadItems = 0.0;
                        foreach ($items as $key => $item) {
                            $cantidadItems += $item;
                        }
                        if ($cantidadItems > $request->trasladou2_cantidad || $cantidadItems < $request->trasladou2_cantidad || $cantidadItems == 0  ) {
                            return response()->json(['success' => false,'errors' => "Cantidad de items de  {$request->producto_nombre} no coincide con el valor de SALIDA, por favor verifique información."]);
                        }
                    }

                    return response()->json(['success' => true, 'id' => uniqid(), 'id_producto'=>$producto->id,'producto_serie'=> $producto->producto_serie,'producto_nombre'=> $producto->producto_nombre]);
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $trasladou2->errors]);
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
