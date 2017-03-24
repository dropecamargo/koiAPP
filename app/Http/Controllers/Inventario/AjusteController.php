<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Inventario\Ajuste1,App\Models\Inventario\TipoAjuste,App\Models\Inventario\Ajuste2,App\Models\Inventario\Inventario,App\Models\Inventario\Prodbode, App\Models\Inventario\Prodbodelote,App\Models\Inventario\Producto;
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

                        $ajusteDetalle = new Ajuste2;
                    $ajuste2 = isset($data['ajuste2']) ? $data['ajuste2'] : null;
     
                    $lote = Ajuste1:: $default_document.$ajuste->id;
                    foreach ($ajuste2 as $item) 
                    {   
                        $producto = Producto::where('id', $item['id_producto'] )->first();
                        if (!$producto instanceof Producto) {
                            DB::rollback();
                            return response()->json(['success' => false,'errors'=>'No es posible recuperar el producto,por favor verifique la información ó por favor consulte al administrador']);
                        }
                        
                        $ajusteDetalle->ajuste2_ajuste1 = $ajuste->id;
                        $ajusteDetalle->fill($item);
                        $ajusteDetalle->ajuste2_lote = $lote;
                        $ajusteDetalle->ajuste2_producto = $item['id_producto'];
                        $ajusteDetalle->save();

                        $costo = 0 ; 
                        if ($tipoAjuste->tipoajuste_tipo == 'E') {
                            
                            // Costo promedio
                            $costopromedio = $producto->costopromedio($ajusteDetalle->ajuste2_costo, $ajusteDetalle->ajuste2_cantidad_entrada);
                            $costo = $ajusteDetalle->ajuste2_costo / $ajusteDetalle->ajuste2_cantidad_entrada;

                            //ProdBode
                            $result = Prodbode::actualizar($producto, $sucursal->id,'E', $ajusteDetalle->ajuste2_cantidad_entrada);
                            if($result != 'OK') {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors'=>"$result"]);
                            }

                            //ProdBodeLote
                            $result = Prodbodelote::actualizar($producto,$sucursal->id,'E',$ajusteDetalle->ajuste2_cantidad_entrada,$lote);
                                if($result != 'OK') {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors'=>"$result"]);
                            }

                            // //ProdBodeRollo
                            // if ($producto->producto_metrado == true) {

                            //     $item = DB::table('prodboderollo')->where('prodboderollo_serie', $producto->id)->where('prodboderollo_sucursal', $sucursal->id)->where('prodboderollo_lote',$lote)->max('prodboderollo_item');
                            //     $item++;
                            //     // $costometrado = $ajusteDetalle->ajuste2_costo / $ajusteDetalle->ajuste2_cantidad_entrada; 
                            //     $result = Prodboderollo::actualizar($producto,$sucursal->id,'E', $item);

                            //     if($result != 'OK') {
                            //         DB::rollback();
                            //         return response()->json(['success' => false, 'errors'=>"$result"]);
                            //     }
                            // }

                            // Inventario
                            $inventario = Inventario::movimiento($producto, $sucursal->id,'AJUS',$ajuste->id,$ajusteDetalle->ajuste2_cantidad_entrada,0,$costo,$costopromedio);
                            if (!$inventario instanceof Inventario) {
                            DB::rollback();
                            return response()->json(['success' => false,'errors'=>'No es posible realizar inventario,por favor verifique la información ó por favor consulte al administrador']);
                            }

                        }else{
                            $costo = $ajusteDetalle->ajuste2_costo / $ajusteDetalle->ajuste2_cantidad_salida;   
                            //ProdBode
                            $result = Prodbode::actualizar($producto, $sucursal->id,'S', $ajusteDetalle->ajuste2_cantidad_salida);

                            if($result != 'OK') {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors'=>"$result"]);
                            }

                            //ProdBodeLote
                            $result = Prodbodelote::actualizar($producto,$sucursal->id,'S',$ajusteDetalle->ajuste2_cantidad_salida,$lote);
                            if($result != 'OK') {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors'=>"$result"]);
                            }
                           // Inventario
                            $inventario = Inventario::movimiento($producto, $sucursal->id,'AJUS',$ajuste->id,0,$ajusteDetalle->ajuste2_cantidad_salida,$costo,0);
                            if (!$inventario instanceof Inventario) {
                                DB::rollback();
                                return response()->json(['success' => false,'errors'=>'No es posible realizar inventario,por favor verifique la información ó por favor consulte al administrador']);
                            }
                        }

                    }
                     //Update sucursal_ajus in Sucursal
                    $sucursal->sucursal_ajus = $consecutive;
                    $sucursal->save();

                    // Commit Transaction
                    DB::rollback();
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
        $ajuste = Ajuste1::getAjuste($id); 
        if(!$ajuste instanceof Ajuste1) {
            abort(404);
        }


        return view('inventario.ajustes.edit', ['ajuste1' => $ajuste]); 
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
        if($request->ajax()){
            $data = $request->all();
            $ajuste = Ajuste1::findOrFail($id);
            if ($ajuste->isValid($data)) {
                DB::beginTransaction();
                try {

                    //Validar Documentos
                    $documento = Documentos::where('documentos_codigo', Ajuste1::$default_document)->first();
                    if(!$documento instanceof Documentos) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar documentos, por favor consulte al administrador.']);
                    }
                    //Validar Tipo Ajuste
                    $tipoAjuste = tipoAjuste::where()->first();
                    if (!$tipoAjuste instanceof tipoAjuste) {
                        DB::rollback();
                        return response()->json(['success' => false,'errors'=>'No es posible recuperar el tipo ajuste, por favor consulte al administrador']);
                    }

                    $ajuste->fill();
                    $ajuste->ajuste1_documentos = $documento->id;
                    $ajuste->ajuste1_usuario_elaboro = Auth::user()->id;
                    $ajuste->ajuste1_fh_elaboro = date('Y-m-d H:m:s'); 

                   
                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $ajuste->id]);
                } catch (\Exception $e) {
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
