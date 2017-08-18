<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Inventario\Entrada1,App\Models\Inventario\Entrada2,App\Models\Inventario\Producto;
use App\Models\Tesoreria\Facturap1;
use App\Models\Base\Sucursal;
use DB,Log;

class EntradaDetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $entrada = [] ;
            if ($request->has('facturap1')) {
                $facturap = Facturap1::find($request->facturap1);
                if (!$facturap instanceof Facturap1) {
                    return response()->json(['success' => false, 'errors' => 'NO es posible recuperar factura proveedor, por favor consulte con el administrador']);
                }
                $entrada = Entrada2::getEntrada2($facturap->facturap1_entrada1);
            }
            return response()->json($entrada);
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
            $entrada2 = new Entrada2;
            if ($entrada2->isValid($data)) {
                try {
                    // Recuperar producto
                    $producto = Producto::where('producto_serie', $request->producto_serie)->first();
                    if(!$producto instanceof Producto){
                        return response()->json(['success'=> false, 'errors'=>'No es posible recuperar producto, por favor consulte al administrador.']);
                    }

                    // Validar maneja unidades
                    if(!$producto->producto_unidad) {
                        return response()->json(['success' => false,'errors' => "No es posible realizar movimientos para productos que no manejan unidades"]);
                    }

                    if ($request->get('entrada2_cantidad') == 0 || $request->get('entrada2_costo') == 0 ) {
                       return response()->json(['success' => false,'errors' => "No es posible realizar $tipoAjuste->tipoajuste_nombre, por favor verifique la información ó consulte al administrador"]);
                    }
                    if ($producto->producto_maneja_serie == true) {
                        // Producto serie
                        $series = [];
                        for ($item = 1; $item <= $request->entrada2_cantidad; $item++) {
                            if(!$request->has("producto_serie_$item") || $request->get("producto_serie_$item") == '') {
                                return response()->json(['success' => false,'errors' => "Por favor ingrese serie para el item $item."]);
                            }

                            // Validar series ingresadas repetidas
                            if(in_array($request->get("producto_serie_$item"), $series)){
                                return response()->json(['success' => false,'errors' => "No es posible registrar dos números de serie iguales"]);  
                            }

                            // Validar serie
                            $serie = Producto::where('producto_serie', $request->get("producto_serie_$item"))->first();
                            if($serie instanceof Producto) {
                                // Si ya existe serie validamos prodbode en cualquier sucursal, serie unica
                                $existencias = DB::table('prodbode')->where('prodbode_serie', $serie->id)->sum('prodbode_cantidad');
                                if($existencias > 0) {
                                    return response()->json(['success' => false,'errors' => "Ya existe un producto con este número de serie {$serie->producto_serie}."]);
                                }
                            }

                            $series[] = $request->get("producto_serie_$item");
                        }
                    }else if ($producto->producto_metrado == true) {
                        // Producto metrado
                        $items = isset($data['items']) ? $data['items'] : null;
                        $metradoItem = 0;
                        foreach ($items as $key => $item) {
                            $metradoItem += $item['rollo_metros'] * $item['rollo_cantidad'];
                        }
                        
                        if ($metradoItem != $request->entrada2_cantidad) {
                            return response()->json(['success' => false,'errors' => "Metraje debe ser igual a la cantidad de ({$request->entrada2_cantidad}) METROS ingresada anteriormente, por favor verifique información."]);
                        }

                    }else if($producto->producto_vence == true){
                        $items = isset($data['items']) ? $data['items'] : null;
                        $numUnidades = 0;
                        $lotes = [];
                        foreach ($items as $key => $item) {
                            $numUnidades += $item['lote_cantidad'];
                        }

                        if ($numUnidades != $request->entrada2_cantidad) {
                            return response()->json(['success' => false,'errors' => "Unidades debe ser igual a la cantidad ({$request->entrada2_cantidad}) ingresada anteriormente, por favor verifique información."]);
                        }
                    } 
                    return response()->json(['success' => true, 'id' => uniqid(), 'id_producto'=>$producto->id,'producto_serie'=> $producto->producto_serie,'producto_nombre'=> $producto->producto_nombre ]);
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $entrada2->errors]);
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
