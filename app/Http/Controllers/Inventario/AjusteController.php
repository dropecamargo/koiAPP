<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Classes\AsientoContableDocumento, App\Classes\AsientoNifContableDocumento;
use App\Models\Inventario\Ajuste1, App\Models\Inventario\Ajuste2, App\Models\Inventario\TipoAjuste, App\Models\Inventario\Producto ,App\Models\Inventario\Lote, App\Models\Inventario\Rollo, App\Models\Inventario\Prodbode, App\Models\Inventario\Inventario, App\Models\Inventario\Linea, App\Models\Base\Documentos, App\Models\Base\Sucursal;
use DB, Log, Datatables, Auth, App, View,Excel;

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
            $query->orderBy('ajuste1.id', 'desc');
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

                    $sucursal = Sucursal::find($request->ajuste1_sucursal);
                    if(!$sucursal instanceof Sucursal) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar sucursal,por favor verifique la información ó por favor consulte al administrador.']);
                    }

                    //Validar Tipo Ajuste
                    $tipoajuste = TipoAjuste::find($request->ajuste1_tipoajuste);
                     if (!$tipoajuste instanceof TipoAjuste) {
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
                    $ajuste->ajuste1_tipoajuste = $tipoajuste->id;
                    $ajuste->ajuste1_usuario_elaboro = Auth::user()->id;
                    $ajuste->ajuste1_fh_elaboro = date('Y-m-d H:m:s');
                    $ajuste->save();

                    // Detalle ajuste
                    $naturaleza = "";
                    $naturalezaCuadre = "";
                    if ($tipoajuste->tipoajuste_tipo == "E") {
                        $naturaleza = 'D';
                        $naturalezaCuadre = 'C';
                    }elseif ($tipoajuste->tipoajuste_tipo == "S") {
                        $naturaleza = 'C';
                        $naturalezaCuadre = 'D';
                    }
                    $detalleAsiento = [];
                    $total = 0;
                    foreach ($data['ajuste2'] as $item) {
                        // Producto
                        $producto = Producto::find( $item['id_producto'] );
                        if (!$producto instanceof Producto) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar el producto, por favor verifique la información o consulte al administrador']);
                        }
                        // Linea
                        $linea = Linea::find($producto->producto_linea);
                        if (!$linea instanceof Linea) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar linea de producto, por favor verifique la información o consulte al administrador']);
                        }

                        if( !in_array($producto->tipoproducto->tipoproducto_codigo, explode(',', $tipoajuste->getTypesProducto()->tipoajuste_tipoproducto) ) ){
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'El tipo de ajuste no es valido, por favor verifique la información o consulte al administrador']);
                        }

                        if ($tipoajuste->tipoajuste_tipo == 'E' || $item['ajuste2_cantidad_entrada'] > 0) {
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
                        }else if($tipoajuste->tipoajuste_tipo == 'S' || $item['ajuste2_cantidad_salida'] > 0){
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
                        $total += $ajusteDetalle->ajuste2_costo;
                        if (!empty($naturaleza)) {
                            $detalleAsiento[] = $ajuste->detalleAsiento($naturaleza,$linea->linea_cuenta, $ajusteDetalle->ajuste2_costo);
                        }
                    }
                    if (!empty($naturalezaCuadre)) {
                        $detalleAsiento[] = $ajuste->detalleAsiento($naturalezaCuadre,$tipoajuste->tipoajuste_cuenta, $total);
                        $encabezado = $ajuste->encabezadoAsiento();
                        if(!is_object($encabezado)){
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $encabezado]);
                        }
                        //Creo el objeto para manejar el asiento
                        $objAsiento = new AsientoContableDocumento($encabezado->data);
                        if($objAsiento->asiento_error) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $objAsiento->asiento_error]);
                        }
                        // Preparar asiento
                        $result = $objAsiento->asientoCuentas($detalleAsiento);
                        if($result != 'OK'){
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $result]);
                        }

                        // Insertar asiento
                        $result = $objAsiento->insertarAsiento();
                        if($result != 'OK') {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $result]);
                        }
                        // AsientoNif
                        if (!empty($encabezado->dataNif)) {
                            // Creo el objeto para manejar el asiento
                            $objAsientoNif = new AsientoNifContableDocumento($encabezado->dataNif);
                            if($objAsientoNif->asientoNif_error) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => $objAsiento->asientoNif_error]);
                            }

                            // Preparar asiento
                            $result = $objAsientoNif->asientoCuentas($detalleAsiento);
                            if($result != 'OK'){
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => $result]);
                            }

                            // Insertar asiento
                            $result = $objAsientoNif->insertarAsientoNif();
                            if($result != 'OK') {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => $result]);
                            }
                            // Recuperar el Id del asiento
                            $ajuste->ajuste1_asienton = $objAsientoNif->asientoNif->id;
                        }
                        $ajuste->ajuste1_asiento = $objAsiento->asiento->id;
                        $ajuste->save();
                    }
                    // Update consecutive sucursal_ajus in Sucursal
                    $sucursal->sucursal_ajus = $consecutive;
                    $sucursal->save();

                    // Commit Transaction
                    DB::commit();
                    // return response()->json(['success' => false, 'errors' => 'TODO OK']);
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
        $title = sprintf('Ajuste N° %s', $ajuste->ajuste1_numero);

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
    /**
     * Import data ajustes.
     *
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        if( isset($request->file) ){
            // Validator type file
            if ($request->file->getClientMimeType() !== 'text/csv' )
                return response()->json(['success' => false, 'errors' => "Por favor, seleccione un archivo .csv."]);
            // Begin Transaction
            DB::beginTransaction();
            try {
                //Validar Documentos
                $documento = Documentos::where('documentos_codigo', Ajuste1::$default_document)->first();
                if(!$documento instanceof Documentos) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar documentos,por favor verifique la información ó por favor consulte al administrador.']);
                }

                $sucursal = Sucursal::find($request->import_sucursal);
                if(!$sucursal instanceof Sucursal) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar sucursal,por favor verifique la información ó por favor consulte al administrador.']);
                }

                //Validar Tipo Ajuste
                $tipoajuste = TipoAjuste::whereRaw("tipoajuste_sigla = 'IDE'")->first();
                 if (!$tipoajuste instanceof TipoAjuste) {
                    DB::rollback();
                    return response()->json(['success' => false,'errors'=>'No es posible recuperar el tipo ajuste,por favor verifique la información ó por favor consulte al administrador']);
                }

                // Consecutive
                $consecutive = $sucursal->sucursal_ajus+ 1;

                // Ajuste1
                $ajuste = new Ajuste1;
                $ajuste->ajuste1_fecha = date('Y-m-d');
                $ajuste->ajuste1_documentos = $documento->id;
                $ajuste->ajuste1_sucursal = $sucursal->id;
                $ajuste->ajuste1_numero = $consecutive;
                $ajuste->ajuste1_tipoajuste = $tipoajuste->id;
                $ajuste->ajuste1_usuario_elaboro = Auth::user()->id;
                $ajuste->ajuste1_fh_elaboro = date('Y-m-d H:m:s');
                $ajuste->ajuste1_observaciones = "Observaciones importando datos desde excel";
                $ajuste->save();

                // Ajuste2 - Excel
                $excel = Excel::load($request->file)->get();
                foreach ($excel as $row) {
                    $producto = Producto::where( 'producto_serie', $row->producto_serie )->first();
                    if (!$producto instanceof Producto) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => "No es posible recuperar el producto $row->producto_serie , por favor verifique la información o consulte al administrador"]);
                    }

                    if( !in_array($producto->tipoproducto->tipoproducto_codigo, explode(',', $tipoajuste->getTypesProducto()->tipoajuste_tipoproducto) ) ){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'El tipo de ajuste no es valido, por favor verifique la información o consulte al administrador']);
                    }

                    if ($row->cantidad_entrada > 0) {

                        // Detalle ajuste != Manejaserie
                        if ($producto->producto_maneja_serie != true) {

                            // Costo promedio
                            $costopromedio = $producto->costopromedio($row->costo, $row->cantidad_entrada);

                            $ajusteDetalle = new Ajuste2;
                            $ajusteDetalle->ajuste2_cantidad_entrada = $row->cantidad_entrada;
                            $ajusteDetalle->ajuste2_costo = $row->costo;
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
                            $costo = $row->costo;

                            //Movimiento entrada maneja serie
                            $movimiento = Inventario::entradaManejaSerie($producto, $sucursal, $row->serie, $row->costo);
                            if($movimiento != 'OK') {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => $movimiento]);
                            }
                            // Valido el replicate
                            $serie = Producto::where('producto_serie', $row->serie)->first();
                            if(!$serie instanceof Producto) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => 'No es posible recuperar serie, por favor verifique la información ó por favor consulte al administrador']);
                            }

                            // Detalle ajuste
                            $ajusteDetalle = new Ajuste2;
                            $ajusteDetalle->ajuste2_cantidad_entrada = 1;
                            $ajusteDetalle->ajuste2_costo = $row->costo;
                            $ajusteDetalle->ajuste2_costo_promedio = $costopromedio;
                            $ajusteDetalle->ajuste2_ajuste1 = $ajuste->id;
                            $ajusteDetalle->ajuste2_producto = $serie->id;
                            $ajusteDetalle->save();

                            $lote = Lote::actualizar($serie, $sucursal->id, $row->lote, 'E', 1, $sucursal->sucursal_defecto, $ajuste->ajuste1_fecha, null);
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
                        // Producto Metrado
                        }else if ($producto->producto_metrado == true) {
                            for ($i=0; $i < $row->rollo; $i++) {
                                // Individualiza en rollo
                                $rollo = Rollo::actualizar($producto, $sucursal->id, 'E', $row->lote, $ajuste->ajuste1_fecha, $row->cantidad_entrada, $sucursal->sucursal_defecto);
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
                        }else if ($producto->producto_vence == true) {
                            // Individualiza en lote
                            $lote = Lote::actualizar($producto, $sucursal->id, $row->lote, 'E', $row->cantidad_entrada, $sucursal->sucursal_defecto ,$ajuste->ajuste1_fecha, $row->vence);
                            if (!$lote instanceof Lote) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => 'No es posible recuperar lote, por favor verifique la información ó por favor consulte al administrador']);
                            }
                            // Inventario
                            $inventario = Inventario::movimiento($producto, $sucursal->id, $sucursal->sucursal_defecto,'AJUS', $ajuste->id, $row->cantidad_entrada, 0, [], [], $ajusteDetalle->ajuste2_costo, $costopromedio,$lote->id,[]);
                            if ($inventario != 'OK') {
                                DB::rollback();
                                return response()->json(['success' => false,'errors '=> $inventario]);
                            }
                        }else{
                            // Individualiza en lote
                            $lote = Lote::actualizar($producto, $sucursal->id, $row->lote, 'E', $ajusteDetalle->ajuste2_cantidad_entrada, $sucursal->sucursal_defecto, $ajuste->ajuste1_fecha);
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
                    }
                }
                // Update consecutive sucursal_ajus in Sucursal
                $sucursal->sucursal_ajus = $consecutive;
                $sucursal->save();

                // Commit Transaction
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
            return response()->json(['success'=> true, 'msg'=> 'Importación de datos exitosa', 'destination' => 'ajustes' ]);
        }
        return response()->json(['success' => false, 'errors' => "Por favor, seleccione un archivo."]);
    }
}
