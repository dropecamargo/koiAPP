<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Inventario\Ajuste1,App\Models\Inventario\TipoAjuste,App\Models\Inventario\Producto,App\Models\Inventario\Lote,App\Models\Inventario\Rollo,App\Models\Inventario\Ajuste2,App\Models\Inventario\Prodbode,App\Models\Inventario\Inventario;

use App\Models\Base\Documentos, App\Models\Base\Sucursal;

use DB, Log, Datatables, Auth, App, View;

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

            // Persistent data filter
            if($request->has('persistent') && $request->persistent) {
                session(['searchajuste_ajuste_tipo' => $request->has('tipo') ? $request->tipo : '']);
                session(['searchajuste_ajuste_sucursal' => $request->has('sucursal') ? $request->sucursal : '']);
                session(['searchajuste_ajuste_fecha' => $request->has('fecha') ? $request->fecha : '']);
            }

            return Datatables::of($query)
                ->filter(function($query) use($request) {

                    // // Sucursal
                    if ($request->has('sucursal')) {
                        $query->where('ajuste1_sucursal', $request->sucursal);
                    }
                    // // Tipo de ajuste
                    if ($request->has('tipo')) {
                        $query->where('ajuste1_tipoajuste', $request->tipo);
                    }
                    // Fecha
                    if ($request->has('fecha')) {
                        $query->where('ajuste1_fecha', $request->fecha);
                    }
                })->make(true);
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
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar sucursal,por favor verifique la información ó por favor consulte al administrador.']);
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
                    $ajuste->ajuste1_numero = $consecutive;
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

                        if ($tipoAjuste->tipoajuste_tipo == 'E') {

                            // Detalle ajuste != Manejaserie
                            if ($producto->producto_maneja_serie != true) {

                                // Costo promedio
                                $costopromedio = $producto->costopromedio($item['ajuste2_costo'], $item['ajuste2_cantidad_entrada']);

                                $ajusteDetalle = new Ajuste2;
                                $ajusteDetalle->fill($item);
                                $ajusteDetalle->ajuste2_costo_promedio = $costopromedio;
                                $ajusteDetalle->ajuste2_ajuste1 = $ajuste->id;
                                $ajusteDetalle->ajuste2_producto = $producto->id;
                                $ajusteDetalle->save();

                                // Prodbode
                                $result = Prodbode::actualizar($producto, $sucursal->id, 'E', $ajusteDetalle->ajuste2_cantidad_entrada, $sucursal->sucursal_defecto);
                                if(!$result instanceof Prodbode) {
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors'=> $result]);
                                }
                            }
                            // Producto maneja serie
                            if ($producto->producto_maneja_serie == true) {

                                // Costo
                                $costo = $item['ajuste2_costo'];

                                for ($i=1; $i <= $item['ajuste2_cantidad_entrada']; $i++) {

                                    //Movimiento entrada maneja serie
                                    $movimiento = Inventario::entradaManejaSerie($producto, $sucursal, $item["producto_serie_$i"], $costo);
                                    if($movimiento != 'OK') {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors' => $movimiento]);
                                    }
                                    // Valido el replicate
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
                                    $ajusteDetalle->ajuste2_costo_promedio = $costo;
                                    $ajusteDetalle->ajuste2_producto = $serie->id;
                                    $ajusteDetalle->save();

                                    $lote = Lote::actualizar($serie, $sucursal->id, $request->ajuste1_lote, 'E', 1, $sucursal->sucursal_defecto, $ajuste->ajuste1_fecha, null);
                                    if (!$lote instanceof Lote) {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar lote, por favor verifique la información ó por favor consulte al administrador']);
                                    }
                                    // Inventario
                                    $inventario = Inventario::movimiento($serie, $sucursal->id, $sucursal->sucursal_defecto,'AJUS', $ajuste->id, 1, 0, [], [], $costo, $costo,$lote->id,[]);
                                    if ($inventario != 'OK') {
                                        DB::rollback();
                                        return response()->json(['success' => false,'errors '=> $inventario]);
                                    }
                                }
                            // Producto Metrado
                            }else if ($producto->producto_metrado == true) {
                                $items = isset($item['items']) ? $item['items'] : null;
                                foreach ($items as $value) {
                                    for ($i=0; $i < $value['rollo_cantidad']; $i++) {
                                        // Individualiza en rollo
                                        $rollo = Rollo::actualizar($producto, $sucursal->id, 'E', $value['rollo_lote'], $ajuste->ajuste1_fecha, $value['rollo_metros'], $sucursal->sucursal_defecto);
                                        if (!$rollo->success) {
                                            DB::rollback();
                                            return response()->json(['success' => false, 'errors' => $rollo]);
                                        }
                                        // Inventario
                                        $inventario = Inventario::movimiento($producto, $sucursal->id, $sucursal->sucursal_defecto,'AJUS', $ajuste->id, 0, 0, $rollo->cantidad,[],$ajusteDetalle->ajuste2_costo, $costopromedio,0,$rollo->rollos);
                                        if ($inventario != 'OK') {
                                            DB::rollback();
                                            return response()->json(['success' => false,'errors '=> $inventario]);
                                        }
                                    }
                                }
                            }else if ($producto->producto_vence == true) {
                                $items = isset($item['items']) ? $item['items'] : null;
                                foreach ($items as $value) {
                                    // Individualiza en lote
                                    $lote = Lote::actualizar($producto, $sucursal->id, $value['lote_numero'], 'E', $value['lote_cantidad'], $sucursal->sucursal_defecto ,$ajuste->ajuste1_fecha, $value['lote_fecha']);
                                    if (!$lote instanceof Lote) {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar lote, por favor verifique la información ó por favor consulte al administrador']);
                                    }
                                    // Inventario
                                    $inventario = Inventario::movimiento($producto, $sucursal->id, $sucursal->sucursal_defecto,'AJUS', $ajuste->id, $value['lote_cantidad'], 0, [], [], $ajusteDetalle->ajuste2_costo, $costopromedio,$lote->id,[]);
                                    if ($inventario != 'OK') {
                                        DB::rollback();
                                        return response()->json(['success' => false,'errors '=> $inventario]);
                                    }
                                }
                            }else{
                                // Individualiza en lote
                                $lote = Lote::actualizar($producto, $sucursal->id, $request->ajuste1_lote, 'E', $ajusteDetalle->ajuste2_cantidad_entrada, $sucursal->sucursal_defecto, $ajuste->ajuste1_fecha);
                                if (!$lote instanceof Lote) {
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar lote, por favor verifique la información ó por favor consulte al administrador']);
                                }
                                // Inventario
                                $inventario = Inventario::movimiento($producto, $sucursal->id, $sucursal->sucursal_defecto,'AJUS', $ajuste->id, $ajusteDetalle->ajuste2_cantidad_entrada, 0, [], [], $ajusteDetalle->ajuste2_costo, $costopromedio,$lote->id,[]);
                                if ($inventario != 'OK') {
                                    DB::rollback();
                                    return response()->json(['success' => false,'errors '=> $inventario]);
                                }
                            }
                        }else if($tipoAjuste->tipoajuste_tipo == 'S'){

                            //Detalle ajuste
                            $ajusteDetalle = new Ajuste2;
                            $ajusteDetalle->fill($item);
                            $ajusteDetalle->ajuste2_costo = $producto->producto_costo;
                            $ajusteDetalle->ajuste2_costo_promedio = $producto->producto_costo;
                            $ajusteDetalle->ajuste2_ajuste1 = $ajuste->id;
                            $ajusteDetalle->ajuste2_producto = $producto->id;
                            $ajusteDetalle->save();

                            if ($producto->producto_maneja_serie == true) {

                                $lote = Lote::actualizar($producto, $sucursal->id, "", 'S', 1, "", $ajuste->ajuste1_fecha, null);
                                if (!$lote instanceof Lote) {
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar lote, por favor verifique la información ó por favor consulte al administrador']);
                                }
                                // Prodbode
                                $result = Prodbode::actualizar($producto, $sucursal->id, 'S', 1, $lote->lote_ubicacion);
                                if(!$result instanceof Prodbode) {
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors'=> $result]);
                                }
                                // Inventario
                                $inventario = Inventario::movimiento($producto, $sucursal->id, $result->prodbode_ubicacion, 'AJUS', $ajuste->id, 0, 1, [], [],$ajusteDetalle->ajuste2_costo, $ajusteDetalle->ajuste2_costo,$lote->id,[]);
                                if ($inventario != 'OK') {
                                    DB::rollback();
                                    return response()->json(['success' => false,'errors '=> $inventario]);
                                }
                            }else if($producto->producto_metrado == true){

                                $items = isset($item['items']) ? $item['items'] : null;
                                foreach ($items as $key => $valueItem) {
                                    if ($valueItem > 0) {
                                        list($text, $rollo) = explode("_", $key);
                                        // Individualiza en rollo --- $rollo hace las veces de lote
                                        $rollo = Rollo::actualizar($producto, $sucursal->id, 'S', $rollo, $ajuste->ajuste1_fecha, $valueItem,"");
                                        if (!$rollo->success) {
                                            DB::rollback();
                                            return response()->json(['success' => false, 'errors' => $rollo->error]);
                                        }

                                        // Prodbode
                                        $result = Prodbode::actualizar($producto, $sucursal->id, 'S', $valueItem, $rollo->rollo_ubicacion);
                                        if(!$result instanceof Prodbode) {
                                            DB::rollback();
                                            return response()->json(['success' => false, 'errors'=> $result]);
                                        }
                                        // Inventario
                                        $inventario = Inventario::movimiento($producto, $sucursal->id, $result->prodbode_ubicacion, 'AJUS', $ajuste->id, 0, 0, [], $rollo->cantidad, $ajusteDetalle->ajuste2_costo, $ajusteDetalle->ajuste2_costo, 0, $rollo->rollos);
                                        if ($inventario != 'OK') {
                                            DB::rollback();
                                            return response()->json(['success' => false,'errors '=> $inventario]);
                                        }
                                    }
                                }
                            }else{
                                $items = isset($item['items']) ? $item['items'] : null;
                                foreach ($items as $key => $value) {
                                    list($text, $lote) = explode("_", $key);

                                    if ($value > 0) {
                                        // Individualiza en lote
                                        $lote = Lote::actualizar($producto, $sucursal->id, $lote, 'S', $value, $sucursal->sucursal_defecto);
                                        if (!$lote instanceof Lote) {
                                            DB::rollback();
                                            return response()->json(['success' => false, 'errors' => $lote]);
                                        }
                                        // Prodbode
                                        $result = Prodbode::actualizar($producto, $sucursal->id, 'S', $value, $lote->lote_ubicacion);
                                        if(!$result instanceof Prodbode) {
                                            DB::rollback();
                                            return response()->json(['success' => false, 'errors'=> $result]);
                                        }
                                        // Inventario
                                        $inventario = Inventario::movimiento($producto, $sucursal->id, $result->prodbode_ubicacion,'AJUS', $ajuste->id, 0, $value, [], [], $ajusteDetalle->ajuste2_costo, $ajusteDetalle->ajuste2_costo,$lote->id,[]);
                                        if ($inventario != 'OK') {
                                            DB::rollback();
                                            return response()->json(['success' => false,'errors '=> $inventario]);
                                        }
                                    }
                                }
                            }
                        }
                    }

                    // Update consecutive sucursal_ajus in Sucursal
                    $sucursal->sucursal_ajus = $consecutive;
                    $sucursal->save();

                    // Commit Transaction
                    // DB::rollback();
                    // return response()->json(['success' => false, 'errors' => 'TODO OK']);
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

    /**
     * Export pdf the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function exportar($id)
    {
        $ajuste = Ajuste1::getAjuste($id);
        if(!$ajuste instanceof Ajuste1) {
            abort(404);
        }
        $detalle = Ajuste2::getAjuste2($ajuste->id);
        $title = sprintf('Ajuste %s', $ajuste->ajuste1_numero);

        // // Export pdf
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML(View::make('inventario.ajustes.exportar.export',  compact('ajuste', 'detalle', 'title'))->render());
        return $pdf->stream(sprintf('%s_%s_%s_%s.pdf', 'ajuste', $ajuste->id, date('Y_m_d'), date('H_m_s')));
    }
    /**
     * Export pdf the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function alistar($id)
    {
        $ajuste = Ajuste1::getAjuste($id);
        if(!$ajuste instanceof Ajuste1) {
            abort(404);
        }
        $inventario = Inventario::getInventory($ajuste->ajuste1_documentos, $ajuste->id);
        $title = sprintf('Alistar ajuste');
        // Export pdf
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('letter', 'landscape');
        $pdf->loadHTML(View::make('inventario.ajustes.exportar.alistar',  compact('inventario', 'ajuste' ,'title'))->render());
        return $pdf->stream(sprintf('%s_%s_%s_%s.pdf', 'inventario', $ajuste->id, date('Y_m_d'), date('H_m_s')));
    }

}
