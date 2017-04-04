<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Inventario\Ajuste1,App\Models\Inventario\TipoAjuste,App\Models\Inventario\Ajuste2,App\Models\Inventario\Inventario,App\Models\Inventario\Inventariorollo,App\Models\Inventario\Prodbode,App\Models\Inventario\Prodboderollo, App\Models\Inventario\Prodbodelote,App\Models\Inventario\Producto;
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
                    $consecutive = $sucursal->sucursal_ajus+ 1;
                    $ajuste->fill($data);
                    $ajuste->ajuste1_documentos = $documento->id;
                    $ajuste->ajuste1_sucursal = $sucursal->id;
                    $ajuste->ajuste1_tipoajuste = $tipoAjuste->id;
                    $ajuste->ajuste1_usuario_elaboro = Auth::user()->id;
                    $ajuste->ajuste1_fh_elaboro = date('Y-m-d H:m:s'); 
                    $ajuste->save();

                    
                    $ajuste2 = isset($data['ajuste2']) ? $data['ajuste2'] : null;
     
                    $lote = Ajuste1:: $default_document.$ajuste->id;
                    if ($tipoAjuste->tipoajuste_tipo == 'E'){
                        foreach ($ajuste2 as $item) 
                        {   
                            $producto = Producto::where('id', $item['id_producto'] )->first();
                            if (!$producto instanceof Producto) {
                                DB::rollback();
                                return response()->json(['success' => false,'errors'=>'No es posible recuperar el producto,por favor verifique la información ó por favor consulte al administrador']);
                            }
                            $costo = 0 ; 

                            if ($producto->producto_maneja_serie != true) {
                                $ajusteDetalle = new Ajuste2;
                                $costopromedio = $producto->costopromedio($item['ajuste2_costo'], $item['ajuste2_cantidad_entrada']);
                                $ajusteDetalle->ajuste2_costo_promedio = $costopromedio;
                                $ajusteDetalle->ajuste2_ajuste1 = $ajuste->id;
                                $ajusteDetalle->fill($item);
                                $ajusteDetalle->ajuste2_lote = $lote;
                                $ajusteDetalle->ajuste2_producto = $item['id_producto'];
                                $ajusteDetalle->ajsute2_fecha_lote = date('Y-m-d H:m:s');

                                $ajusteDetalle->save();
                            }
                            // Costo promedio
                            $costopromedio = $producto->costopromedio($item['ajuste2_costo'], $item['ajuste2_cantidad_entrada']);
                            $costo = $item['ajuste2_costo'] / $item['ajuste2_cantidad_entrada'];

                            if ($producto->producto_maneja_serie == true) {
                                for ($i=1; $i <= $item['ajuste2_cantidad_entrada']; $i++) {
                                    // crea producto
                                    $serie = $producto->serie($item["producto_serie_$i"]);
                                    if(!$serie instanceof Producto) {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors'=>"$serie"]);
                                    }
                                    $costopromedio = $serie->costopromedio($item['ajuste2_costo'], $item['ajuste2_cantidad_entrada']);

                                    $ajusteDetalle = new Ajuste2;
                                    $ajusteDetalle->ajuste2_ajuste1 = $ajuste->id;
                                    $ajusteDetalle->fill($item);
                                    $ajusteDetalle->ajuste2_cantidad_entrada = 1;
                                    $ajusteDetalle->ajuste2_costo_promedio = $costopromedio;
                                    $ajusteDetalle->ajsute2_fecha_lote = date('Y-m-d H:m:s');
                                    $ajusteDetalle->ajuste2_lote = $lote;
                                    $ajusteDetalle->ajuste2_producto = $serie->id;
                                    $ajusteDetalle->save();
                                    //ProdBode
                                    $result = Prodbode::actualizar($serie, $sucursal->id,'E', 1);
                                    if($result != 'OK') {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors'=>"$result"]);
                                    }
                                    //ProdBodeLote
                                    $result = Prodbodelote::actualizar($serie,$sucursal->id,'E',1,1,$lote);
                                    if($result != 'OK') {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors'=>"$result"]);
                                    }
                                    // Inventario
                                    $inventario = Inventario::movimiento($serie, $sucursal->id,'AJUS',$ajuste->id,$ajusteDetalle->ajuste2_cantidad_entrada,0,$ajusteDetalle->ajuste2_costo,$ajusteDetalle->ajuste2_costo);
                                    if (!$inventario instanceof Inventario) {
                                    DB::rollback();
                                    return response()->json(['success' => false,'errors'=>'No es posible realizar inventario,por favor verifique la información ó por favor consulte al administrador']);
                                    }
                                }
                            }elseif ($producto->producto_metrado == true) {
                                $result = Prodbode::actualizar($producto, $sucursal->id,'E', $ajusteDetalle->ajuste2_cantidad_entrada);
                                if($result != 'OK') {
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors'=>"$result"]);
                                }
                                // Inventario
                                $inventario = Inventario::movimiento($producto, $sucursal->id,'AJUS',$ajuste->id,$ajusteDetalle->ajuste2_cantidad_entrada,0,$ajusteDetalle->ajuste2_costo,$costopromedio);
                                if (!$inventario instanceof Inventario) {
                                DB::rollback();
                                return response()->json(['success' => false,'errors'=>'No es posible realizar inventario,por favor verifique la información ó por favor consulte al administrador']);
                                }

                                $items = isset($item['items']) ? $item['items'] : null;
                                foreach ($items as $key => $value) {
                                    $prodboderollo = Prodboderollo::actualizar($producto,$sucursal->id,'E',$value,$costopromedio,$lote );
                                    if(!$prodboderollo instanceof Prodboderollo) {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors'=>"$result"]);
                                    }
                                    $result = Inventariorollo::movimiento($inventario,$prodboderollo,$item['ajuste2_costo'],$value,0,$costopromedio );
                                    if(!$result instanceof Inventariorollo) {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors'=>"$result"]);
                                    }
                                }

                            }else{

                               //ProdBode
                                $result = Prodbode::actualizar($producto, $sucursal->id,'E',$ajusteDetalle->ajuste2_cantidad_entrada);
                                if($result != 'OK') {
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors'=>"$result"]);
                                }
                                //ProdBodeLote
                                $result = Prodbodelote::actualizar($producto,$sucursal->id,'E',$ajusteDetalle->ajuste2_cantidad_entrada,$ajusteDetalle->ajuste2_cantidad_entrada,$lote);
                                if($result != 'OK') {
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors'=>"$result"]);
                                }
                                // Inventario
                                $inventario = Inventario::movimiento($producto, $sucursal->id,'AJUS',$ajuste->id,$ajusteDetalle->ajuste2_cantidad_entrada,0,$ajusteDetalle->ajuste2_costo,$ajusteDetalle->ajuste2_costo);
                                if (!$inventario instanceof Inventario) {
                                DB::rollback();
                                return response()->json(['success' => false,'errors'=>'No es posible realizar inventario,por favor verifique la información ó por favor consulte al administrador']);
                                }
                            }
                        }
                    }else{
                        //salidas
                        foreach ($ajuste2 as $item) 
                        {   
                            $producto = Producto::where('id', $item['id_producto'] )->first();
                            if (!$producto instanceof Producto) {
                                DB::rollback();
                                return response()->json(['success' => false,'errors'=>'No es posible recuperar el producto,por favor verifique la información ó por favor consulte al administrador']);
                            }

                            if ($producto->producto_maneja_serie == true) {
                                $productolote = Prodbodelote::where('prodbodelote_serie', $producto->id)->get();
                                if ($productolote instanceof Prodbodelote) {
                                    DB::rollback();
                                    return response()->json(['success' => false,'errors'=>'No es posible recuperar el LOTE,por favor verifique la información ó por favor consulte al administrador']);
                                }
                                foreach ($productolote as $value) {
                                    $ajusteDetalle = new Ajuste2;
                                    $ajusteDetalle->ajuste2_ajuste1 = $ajuste->id;
                                    $ajusteDetalle->fill($item);
                                    $ajusteDetalle->ajuste2_cantidad_salida = 1;
                                    $ajusteDetalle->ajuste2_producto = $producto->id;
                                    $ajusteDetalle->ajsute2_fecha_lote = $value->prodbodelote_fecha_lote;
                                    $ajusteDetalle->ajuste2_lote = $value->prodbodelote_lote;
                                    $ajusteDetalle->save();
                                    //ProdBode
                                    $result = Prodbode::actualizar($producto, $sucursal->id,'S', 1);
                                    if($result != 'OK') {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors'=>"$result"]);
                                    }
                                    //ProdBodeLote
                                    $result = Prodbodelote::actualizar($producto,$sucursal->id,'S',1,1,$value->prodbodelote_lote);
                                    if($result != 'OK') {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors'=>"$result"]);
                                    }
                                    // Inventario
                                    $inventario = Inventario::movimiento($producto, $sucursal->id,'AJUS',$ajuste->id,0,$ajusteDetalle->ajuste2_cantidad_salida,$ajusteDetalle->ajuste2_costo,$ajusteDetalle->ajuste2_costo);
                                    if (!$inventario instanceof Inventario) {
                                    DB::rollback();
                                    return response()->json(['success' => false,'errors'=>'No es posible realizar inventario,por favor verifique la información ó por favor consulte al administrador']);
                                    }
                                    
                                }
                       
                            }elseif($producto->producto_metrado == true){
                                
                                $ajusteDetalle = new Ajuste2;
                                $ajusteDetalle->ajuste2_ajuste1 = $ajuste->id;
                                $ajusteDetalle->fill($item);
                                $ajusteDetalle->ajuste2_cantidad_salida = $item['ajuste2_cantidad_salida'];
                                $ajusteDetalle->ajuste2_producto = $producto->id;
                                // $ajusteDetalle->ajsute2_fecha_lote = date('Y-m-d H:m:s');
                                // $ajusteDetalle->ajuste2_lote = $lote;
                                $ajusteDetalle->save();

                                $result = Prodbode::actualizar($producto, $sucursal->id,'S', $ajusteDetalle->ajuste2_cantidad_salida);
                                if($result != 'OK') {
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors'=>"$result"]);
                                }
                                // Inventario
                                $inventario = Inventario::movimiento($producto, $sucursal->id,'AJUS',$ajuste->id,0,$ajusteDetalle->ajuste2_cantidad_salida,$ajusteDetalle->ajuste2_costo,$ajusteDetalle->ajuste2_costo);
                                if (!$inventario instanceof Inventario) {
                                DB::rollback();
                                return response()->json(['success' => false,'errors'=>'No es posible realizar inventario,por favor verifique la información ó por favor consulte al administrador']);
                                }

                                $items = isset($item['items']) ? $item['items'] : null;
                                foreach ($items as $key => $value) {
                                    $prodboderollo_id = explode("_", $key);
                                    $lote = Prodboderollo::find($prodboderollo_id[1]);
                                    if(!$lote instanceof Prodboderollo){
                                        DB::rollback();
                                        return response()->json(['success'=> false, 'errors'=> 'No es posible encontrar lote , por favor verifique la información ó por favor consulte al administrador']);
                                    }
                                    $prodboderollo = Prodboderollo::actualizar($producto,$sucursal->id,'S',$value,$item['ajuste2_costo'],$lote->prodboderollo_lote);
                                    if(!$prodboderollo instanceof Prodboderollo) {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors'=>"$result"]);
                                    }
                                    $result = Inventariorollo::movimiento($inventario,$prodboderollo,$item['ajuste2_costo'],0,$value,$item['ajuste2_costo'] );
                                    if(!$result instanceof Inventariorollo) {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors'=>"No es posible realizar Inventario en rollo $result"]);
                                    }
                                }
                            }else{
                                $productolote = Prodbodelote::where('prodbodelote_serie', $producto->id)->get();
                                if ($productolote instanceof Prodbodelote) {
                                    DB::rollback();
                                    return response()->json(['success' => false,'errors'=>'No es posible recuperar el LOTE,por favor verifique la información ó por favor consulte al administrador']);
                                }
                                $ajusteDetalle = new Ajuste2;
                                $ajusteDetalle->ajuste2_ajuste1 = $ajuste->id;
                                $ajusteDetalle->fill($item);
                                $ajusteDetalle->ajuste2_cantidad_salida = $item['ajuste2_cantidad_salida'];
                                $ajusteDetalle->ajuste2_producto = $producto->id;
                                $ajusteDetalle->ajsute2_fecha_lote = $productolote->prodbodelote_fecha_lote;
                                $ajusteDetalle->ajuste2_lote = $productolote->prodbodelote_lote;
                                $ajusteDetalle->save();
                                foreach ($productolote as $value) {
                                    if ($item["item_{$value->id}"] > 0) {
                                        //ProdBode
                                        $result = Prodbode::actualizar($producto, $sucursal->id,'S',$ajusteDetalle->ajuste2_cantidad_salida);
                                        if($result != 'OK') {
                                            DB::rollback();
                                            return response()->json(['success' => false, 'errors'=>"$result"]);
                                        }
                                        //ProdBodeLote
                                        $result = Prodbodelote::actualizar($producto,$sucursal->id,'S',$item["item_{$value->id}"],$item["item_{$value->id}"],$value->prodbodelote_lote);
                                        if($result != 'OK') {
                                            DB::rollback();
                                            return response()->json(['success' => false, 'errors'=>"$result"]);
                                        }
                                        // Inventario
                                        $inventario = Inventario::movimiento($producto, $sucursal->id,'AJUS',$ajuste->id,0,$item["item_{$value->id}"],$ajusteDetalle->ajuste2_costo,$ajusteDetalle->ajuste2_costo);
                                        if (!$inventario instanceof Inventario) {
                                        DB::rollback();
                                        return response()->json(['success' => false,'errors'=>'No es posible realizar inventario,por favor verifique la información ó por favor consulte al administrador']);
                                        }
                                    }
                                }
                            }
                        }    
                    }    
                    //Update sucursal_ajus in Sucursal
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
