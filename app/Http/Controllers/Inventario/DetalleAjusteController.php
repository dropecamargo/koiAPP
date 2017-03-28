<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Inventario\Ajuste2, App\Models\Inventario\Producto, App\Models\Inventario\Ajuste1,App\Models\Inventario\TipoAjuste;

use DB,Log;
class DetalleAjusteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
         $ajusteDetalle = Ajuste2::getAjuste2($request->id);
         return response()->json($ajusteDetalle);
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
        if($request->ajax()){
            $data = $request->all();
            $ajusteDetalle = new Ajuste2;
            if ($ajusteDetalle->isValid($data)) {
            
                try {                      
                    $producto = Producto::where('producto_serie', $request->ajuste2_producto)->first();
                    if(!$producto instanceof Producto){
                        return response()->json(['success'=> false, 'errors'=>'No es posible recuperar producto, por favor consulte al administrador.']);
                    } 
                    //Validar Tipo Ajuste
                    $tipoAjuste = TipoAjuste::where('id', $request->tipoajuste)->first();
                    if (!$tipoAjuste instanceof TipoAjuste) {
                        return response()->json(['success' => false,'errors'=>'No es posible recuperar el tipo ajuste,por favor verifique la información ó por favor consulte al administrador']);
                    } 
                    switch ($tipoAjuste->tipoajuste_tipo) {
                        case 'S':
                            if ($request->get('ajuste2_cantidad_salida') <= 0 && $request->get('ajuste2_costo') == 0) {
                               return response()->json(['success' => false,'errors' => "No es posible realizar $tipoAjuste->tipoajuste_nombre, por favor verifique la información ó consulte al administrador"]);
                            }                     
                            break;

                        case 'E':

                            if(!$producto->producto_unidad){
                                return response()->json(['success' => false,'errors' => "No es posible realizar movimientos para productos que no manejan unidades"]);
                            }
                            
                            if ($request->get('ajuste2_cantidad_entrada') == 0 && $request->get('ajuste2_costo') == 0 ) {
                               return response()->json(['success' => false,'errors' => "No es posible realizar $tipoAjuste->tipoajuste_nombre, por favor verifique la información ó consulte al administrador"]);
                            }
                            if ($producto->producto_maneja_serie == true) {
                                // Producto serie
                                $series = [];
                                for ($item = 1; $item <= $request->ajuste2_cantidad_entrada; $item++) {
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
                                            return response()->json(['success' => false,'errors' => "Ya existe un producto con este número de serie {$serie->producto_codigo}."]);
                                        }
                                    }

                                    $series[] = $request->get("producto_serie_$item");
                                }
                            }elseif ($producto->producto_metrado == true) {
                                // Producto metrado
                                for ($item = 1; $item <= $request->ajuste2_cantidad_entrada; $item++) {
                                    if(!$request->has("itemrollo_metros_$item") || $request->get("itemrollo_metros_$item") <=0) {
                                        $response->errors = "Por favor ingrese valor en metros para el item rollo $item, debe ser mayor a 0.";
                                        return $response;
                                    }
                                }
                            } 
                            break;
                        case 'R':
                            if(($request->has('ajuste2_cantidad_salida')) && ($request->has('ajuste2_cantidad_entrada')) || ((int)($request->ajuste2_costo == 0))) {
                                return response()->json(['success' => false,'errors' => "No es posible realizar $tipoAjuste->tipoajuste_nombre, por favor verifique la información ó consulte al administrador"]);
                            }
                            break;                      
                    }   
                   
                    return response()->json(['success' => true, 'id' => uniqid(), 'id_producto'=>$producto->id,'producto_serie'=> $producto->producto_serie,'producto_nombre'=> $producto->producto_nombre]);
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $ajusteDetalle->errors]);
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
    public function destroy(Request $request, $id)
    {

    }
}
