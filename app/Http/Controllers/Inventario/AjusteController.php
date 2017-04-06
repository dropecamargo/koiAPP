<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Inventario\Ajuste1,App\Models\Inventario\TipoAjuste,App\Models\Inventario\Producto,App\Models\Inventario\Lote,App\Models\Inventario\Ajuste2,App\Models\Inventario\Prodbode,App\Models\Inventario\Inventario,App\Models\Inventario\Inventariorollo,App\Models\Inventario\Prodboderollo,App\Models\Inventario\Prodbodelote;
use App\Models\Base\Documentos, App\Models\Base\Sucursal;

use DB,Log,Datatables,Auth;
class AjusteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $query = Ajuste1::query();
            $query->select('ajuste1.*', 'sucursal_nombre', 'tipoajuste_nombre');
            $query->join('tipoajuste', 'ajuste1.ajuste1_tipoajuste','=','tipoajuste.id');
            $query->join('sucursal', 'ajuste1.ajuste1_sucursal','=','sucursal.id');
            return Datatables::of($query)->make(true);
        }

        return view('inventario.ajustes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventario.ajustes.create');
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
            $ajuste = new Ajuste1;
            if ($ajuste->isValid($data)) {
                DB::beginTransaction();
                try {
                    //Validar Documentos
                    $documento = Documentos::where('documentos_codigo', Ajuste1::$default_document)->first();
                    if(!$documento instanceof Documentos) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar documentos,por favor verifique la información ó por favor consulte al administrador.']);
                    }
                    $sucursal = Sucursal::where('id', $request->ajuste1_sucursal)->first();
                    if(!$sucursal instanceof Sucursal) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar documentos,por favor verifique la información ó por favor consulte al administrador.']);
                    }
                    //Validar Tipo Ajuste
                    $tipoAjuste = TipoAjuste::where('id', $request->ajuste1_tipoajuste)->first();
                    if (!$tipoAjuste instanceof TipoAjuste) {
                        DB::rollback();
                        return response()->json(['success' => false,'errors'=>'No es posible recuperar el tipo ajuste,por favor verifique la información ó por favor consulte al administrador']);
                    }   

                    // Consecutive
                    $consecutive = $sucursal->sucursal_ajus+ 1;
                    
                    // Ajuste 1
                    $ajuste->fill($data);
                    $ajuste->ajuste1_documentos = $documento->id;
                    $ajuste->ajuste1_sucursal = $sucursal->id;
                    $ajuste->ajuste1_tipoajuste = $tipoAjuste->id;
                    $ajuste->ajuste1_usuario_elaboro = Auth::user()->id;
                    $ajuste->ajuste1_fh_elaboro = date('Y-m-d H:m:s'); 
                    $ajuste->save();

                    // Detalle ajuste
                    foreach ($data['ajuste2'] as $item) {

                        $producto = Producto::find($item['id_producto']);
                        if (!$producto instanceof Producto) {
                            DB::rollback();
                            return response()->json(['success' => false,'errors'=>'No es posible recuperar el producto,por favor verifique la información ó por favor consulte al administrador']);
                        }

                        // Costo promedio
                        $costopromedio = 0;

                        // Entrada
                        if ($tipoAjuste->tipoajuste_tipo == 'E') {

                            // Define nombre del lote
                            $nameLote = Ajuste1:: $default_document.$ajuste->id;
                            $lote = new Lote;
                            $lote->lote_nombre = $nameLote;
                            $lote->lote_fecha = date('Y-m-d H:m:s');
                            // $lote->lote_fecha = '';
                            $lote->save();

                            // Costo promedio
                            $costopromedio = $producto->costopromedio($item['ajuste2_costo'], $item['ajuste2_cantidad_entrada']);

                            // Detalle ajuste
                            if ($producto->producto_maneja_serie != true) {
                                $ajusteDetalle = new Ajuste2;
                                $ajusteDetalle->fill($item);
                                $ajusteDetalle->ajuste2_costo_promedio = $costopromedio;
                                $ajusteDetalle->ajuste2_ajuste1 = $ajuste->id;
                                $ajusteDetalle->ajuste2_producto = $producto->id;
                                $ajusteDetalle->ajuste2_lote = $lote->id;
                                $ajusteDetalle->save();

                                // Prodbode
                                $result = Prodbode::actualizar($producto, $sucursal->id, 'E', $ajusteDetalle->ajuste2_cantidad_entrada);
                                if($result != 'OK') {
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors'=> $result]);
                                }

                                // Inventario
                                $inventario = Inventario::movimiento($producto, $sucursal->id, 'AJUS', $ajuste->id, $ajusteDetalle->ajuste2_cantidad_entrada, 0, $ajusteDetalle->ajuste2_costo, $costopromedio);
                                if (!$inventario instanceof Inventario) {
                                    DB::rollback();
                                    return response()->json(['success' => false,'errors' => $inventario]);
                                } 
                            }

                            // Maneja serie
                            if ($producto->producto_maneja_serie == true) {

                                // Costo promedio
                                $costopromedio = $item['ajuste2_costo'];

                                for ($i=1; $i <= $item['ajuste2_cantidad_entrada']; $i++) 
                                {
                                    // Movimiento entradaManejaSerie
                                    $movimiento = Inventario::entradaManejaSerie($producto, $sucursal, $lote,$item["producto_serie_$i"], $costopromedio);
                                    if($movimiento != 'OK') {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors' => $movimiento]);
                                    }

                                    $serie = Producto::where('producto_serie', $item["producto_serie_$i"])->first();
                                    if(!$serie instanceof Producto) {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar serie, por favor verifique la información ó por favor consulte al administrador']);    
                                    }


                                    // Detalle ajuste
                                    $ajusteDetalle = new Ajuste2;
                                    $ajusteDetalle->fill($item);
                                    $ajusteDetalle->ajuste2_ajuste1 = $ajuste->id;
                                    $ajusteDetalle->ajuste2_cantidad_entrada = 1;
                                    $ajusteDetalle->ajuste2_costo_promedio = $costopromedio;
                                    $ajusteDetalle->ajuste2_lote = $lote->id;
                                    $ajusteDetalle->ajuste2_producto = $serie->id;
                                    $ajusteDetalle->save();

                                    // Inventario
                                    $inventario = Inventario::movimiento($serie, $sucursal->id, 'AJUS', $ajuste->id, 1, 0, $costopromedio, $costopromedio);
                                    if (!$inventario instanceof Inventario) {
                                        DB::rollback();
                                        return response()->json(['success' => false,'errors '=> $inventario]);
                                    }
                                }

                            // Metrado
                            }else if ($producto->producto_metrado == true) {                                
                                // Item rollo
                                $itemRollo = DB::table('prodboderollo')->where('prodboderollo_serie', $producto->id)->where('prodboderollo_sucursal', $sucursal->id)->where('prodboderollo_lote', $lote)->max('prodboderollo_item');
                                
                                $items = isset($item['items']) ? $item['items'] : null;
                                foreach ($items as $key => $value) {
                                    if ($value > 0) {

                                        $itemRollo++;
                                        $prodboderollo = Prodboderollo::actualizar($producto, $sucursal->id, 'E', $itemRollo, $lote, $value, $costopromedio );
                                        if(!$prodboderollo instanceof Prodboderollo) {
                                            DB::rollback();
                                            return response()->json(['success' => false, 'errors'=> $prodboderollo]);
                                        }

                                        $result = Inventariorollo::movimiento($inventario, $prodboderollo, $item['ajuste2_costo'], $value, 0, $costopromedio );
                                        if(!$result instanceof Inventariorollo) {
                                            DB::rollback();
                                            return response()->json(['success' => false, 'errors'=> $result]);
                                        }
                                    }
                                }

                            // Normal
                            }else {
                                // ProdBodeLote
                                $result = Prodbodelote::actualizar($producto, $sucursal->id, $lote,'E',$ajusteDetalle->ajuste2_cantidad_entrada);
                                if($result != 'OK') {
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors' => $result]);
                                }
                            }

                        // Salida
                        }else if ($tipoAjuste->tipoajuste_tipo == 'S') {
                            
                            // Maneja serie
                            if ($producto->producto_maneja_serie == true) {

                                $prodbodelote = Prodbodelote::where('prodbodelote_serie', $producto->id)->where('prodbodelote_saldo', 1)->first();
                                if (!$prodbodelote instanceof Prodbodelote) {
                                    DB::rollback();
                                    return response()->json(['success' => false,'errors' => 'No es posible recuperar el LOTE,por favor verifique la información ó por favor consulte al administrador']);
                                }
                                $lote = Lote::find($prodbodelote->prodbodelote_lote);
                                // Detalle ajuste
                                $ajusteDetalle = new Ajuste2;
                                $ajusteDetalle->fill($item);
                                $ajusteDetalle->ajuste2_costo = $producto->producto_costo;
                                $ajusteDetalle->ajuste2_costo_promedio = $producto->producto_costo;
                                $ajusteDetalle->ajuste2_ajuste1 = $ajuste->id;
                                $ajusteDetalle->ajuste2_lote = $lote->id;
                                $ajusteDetalle->ajuste2_producto = $producto->id;
                                $ajusteDetalle->save();
                                
                                // Movimiento entradaManejaSerie
                                $movimiento = Inventario::salidaManejaSerie($producto, $sucursal, $lote);
                                if($movimiento != 'OK') {
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors' => $movimiento]);
                                }

                                // Inventario
                                $inventario = Inventario::movimiento($producto, $sucursal->id, 'AJUS', $ajuste->id, 0, $ajusteDetalle->ajuste2_cantidad_salida, $ajusteDetalle->ajuste2_costo, $ajusteDetalle->ajuste2_costo);
                                if (!$inventario instanceof Inventario) {
                                    DB::rollback();
                                    return response()->json(['success' => false,'errors' => $inventario]);
                                }
                            // Metrado
                            }else if ($producto->producto_metrado == true) {
                                // ProdBode
                                $result = Prodbode::actualizar($producto, $sucursal->id, 'S', $item['ajuste2_cantidad_salida']);
                                if($result != 'OK') {                                            
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors'=>"$result"]);
                                }

                                // Inventario
                                $inventario = Inventario::movimiento($producto, $sucursal->id, 'AJUS', $ajuste->id, 0, $item['ajuste2_cantidad_salida'], $producto->producto_costo, $producto->producto_costo);
                                if (!$inventario instanceof Inventario) {
                                    DB::rollback();
                                    return response()->json(['success' => false,'errors' => $inventario]);
                                }

                                $items = isset($item['items']) ? $item['items'] : null;
                                foreach ($items as $key => $value) 
                                {
                                    if($value > 0) {
                                        // Recuperar lore
                                        list($text, $lote) = explode("_", $key);
                                        $prodboderollo = Prodboderollo::find($lote);
                                        if(!$prodboderollo instanceof Prodboderollo){
                                            DB::rollback();
                                            return response()->json(['success'=> false, 'errors'=> 'No es posible encontrar lote , por favor verifique la información ó por favor consulte al administrador']);
                                        }
                                        $lote = Lote::find($prodboderollo->prodboderollo_lote);
                                        // Prodbode rollo
                                        $prodboderollo = Prodboderollo::actualizar($producto, $sucursal->id, 'S', $prodboderollo->prodboderollo_item,$lote,$value, $producto->producto_costo);
                                        if(!$prodboderollo instanceof Prodboderollo) {
                                            DB::rollback();
                                            return response()->json(['success' => false, 'errors'=>$prodboderollo]);
                                        }

                                        // Inventario rollo
                                        $result = Inventariorollo::movimiento($inventario, $prodboderollo, $item['ajuste2_costo'], $producto->producto_costo, 0, $value);
                                        if(!$result instanceof Inventariorollo) {
                                            DB::rollback();
                                            return response()->json(['success' => false, 'errors' => $result]);
                                        }
                                        
                                        // Detalle ajuste
                                        $ajusteDetalle = new Ajuste2;
                                        $ajusteDetalle->ajuste2_ajuste1 = $ajuste->id;
                                        $ajusteDetalle->ajuste2_cantidad_salida = $value;
                                        $ajusteDetalle->ajuste2_costo = $producto->producto_costo;
                                        $ajusteDetalle->ajuste2_costo_promedio = $producto->producto_costo;
                                        $ajusteDetalle->ajuste2_producto = $producto->id;
                                        $ajusteDetalle->ajuste2_lote = $prodboderollo->prodboderollo_lote;
                                        $ajusteDetalle->save();
                                    }
                                }

                            // Normal
                            }else {
                                $items = isset($item['items']) ? $item['items'] : null;
                                foreach ($items as $key => $value) 
                                {
                                    if($value > 0) {
                                        // Recuperar lore
                                        list($text, $lote) = explode("_", $key);
                                        $prodbodelote = prodbodelote::find($lote);
                                        if (!$prodbodelote instanceof Prodbodelote) {
                                            DB::rollback();
                                            return response()->json(['success' => false,'errors'=>'No es posible recuperar el LOTE, por favor verifique la información ó por favor consulte al administrador']);
                                        }
                                        $lote = Lote::find($prodbodelote->prodbodelote_lote);
                                        // ProdBode
                                        $result = Prodbode::actualizar($producto, $sucursal->id, 'S', $value);
                                        if($result != 'OK') {                                            
                                            DB::rollback();
                                            return response()->json(['success' => false, 'errors'=>$result]);
                                        }

                                        //ProdBodeLote
                                        $result = Prodbodelote::actualizar($producto, $sucursal->id, $lote,'S', $value);
                                        if($result != 'OK') {
                                            DB::rollback();
                                            return response()->json(['success' => false, 'errors' => $result]);
                                        }

                                        $inventario = Inventario::movimiento($producto, $sucursal->id, 'AJUS', $ajuste->id, 0, $value, $producto->producto_costo, $producto->producto_costo);
                                        if (!$inventario instanceof Inventario) {
                                            DB::rollback();
                                            return response()->json(['success' => false,'errors'=>'No es posible realizar inventario,por favor verifique la información ó por favor consulte al administrador']);
                                        }

                                        $ajusteDetalle = new Ajuste2;
                                        $ajusteDetalle->ajuste2_ajuste1 = $ajuste->id;
                                        $ajusteDetalle->ajuste2_cantidad_salida = $value;
                                        $ajusteDetalle->ajuste2_costo = $producto->producto_costo;
                                        $ajusteDetalle->ajuste2_costo_promedio = $producto->producto_costo;
                                        $ajusteDetalle->ajuste2_producto = $producto->id;
                                        $ajusteDetalle->ajuste2_lote = $lote->id;
                                        $ajusteDetalle->save();
                                    }
                                }
                            }

                        }else{
                            DB::rollback();
                            return response()->json(['success' => false,'errors'=>'No es posible definir movitmiento tipo ajuste, por favor verifique la información ó por favor consulte al administrador']);
                        }
                    }

                    // Update consecutive sucursal_ajus in Sucursal
                    $sucursal->sucursal_ajus = $consecutive;
                    $sucursal->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $ajuste->id]);
                }catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $ajuste->errors]);
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
        $ajuste = Ajuste1::getAjuste($id);
        if(!$ajuste instanceof Ajuste1) {
            abort(404);
        }
         if($request->ajax()) {
            return response()->json($ajuste);
        }
        return view('inventario.ajustes.show', ['ajuste1' => $ajuste]);
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
    public function update(Request $request)
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
