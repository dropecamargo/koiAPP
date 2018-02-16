<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Inventario\Traslado1,App\Models\Inventario\Traslado2,App\Models\Inventario\TipoTraslado,App\Models\Inventario\Producto,App\Models\Inventario\Lote,App\Models\Inventario\Prodbode,App\Models\Inventario\Inventario,App\Models\Inventario\Rollo;
use App\Models\Base\Documentos, App\Models\Base\Sucursal;
use DB,Log,Datatables,Auth, App, View;

class TrasladoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Traslado1::query();
            $query->select('traslado1.id', 'traslado1_numero', 'traslado1_fecha', 'o.sucursal_nombre as sucursa_origen', 'd.sucursal_nombre as sucursa_destino');
            $query->join('sucursal as o', 'traslado1_origen', '=', 'o.id');
            $query->join('sucursal as d', 'traslado1_destino', '=', 'd.id');
            $query->orderBy('traslado1_fecha', 'desc');
            return Datatables::of($query)->make(true);
        }
        return view('inventario.traslados.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventario.traslados.create');
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
            $traslado = new Traslado1;
            if ($traslado->isValid($data)) {
                DB::beginTransaction();
                try {

                    //Validar Documentos
                    $documento = Documentos::where('documentos_codigo', Traslado1::$default_document)->first();
                    if(!$documento instanceof Documentos) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar documentos,por favor verifique la información ó por favor consulte al administrador.']);
                    }

                    // Recuperar origen
                    $origen = Sucursal::find($request->traslado1_sucursal);
                    if(!$origen instanceof Sucursal) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar sucursal origen, por favor verifique la información o consulte al administrador.']);
                    }

                    // Recuperar destino
                    $destino = Sucursal::find($request->traslado1_destino);
                    if(!$destino instanceof Sucursal) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar sucursal destino, por favor verifique la información o consulte al administrador.']);
                    }
                    //Validar tipo traslado
                    $tipotraslado = TipoTraslado::find($request->traslado1_tipotraslado);
                    if (!$tipotraslado instanceof TipoTraslado) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el tipo de traslado, por favor verifique la información o consulte al administrador']);
                    }

                    // Recuperar consecutivo
                    $consecutive = $origen->sucursal_tras + 1;

                    // Traslado 1
                    $traslado->fill($data);
                    $traslado->traslado1_documentos = $documento->id;
                    $traslado->traslado1_numero = $consecutive;
                    $traslado->traslado1_tipotraslado = $tipotraslado->id;
                    $traslado->traslado1_origen = $origen->id;
                    $traslado->traslado1_destino = $destino->id;
                    $traslado->traslado1_usuario_elaboro = Auth::user()->id;
                    $traslado->traslado1_fh_elaboro = date('Y-m-d H:m:s');
                    $traslado->save();

                    foreach ($data['detalle'] as $item) {
                        $producto = Producto::find($item['id_producto']);
                        if (!$producto instanceof Producto) {
                            DB::rollback();
                            return response()->json(['success' => false,'errors'=>'No es posible recuperar el producto,por favor verifique la información ó por favor consulte al administrador']);
                        }

                        // Detalle traslado
                        $detalleTraslado = new Traslado2;
                        $detalleTraslado->fill($item);
                        $detalleTraslado->traslado2_traslado1 = $traslado->id;
                        $detalleTraslado->traslado2_producto = $producto->id;
                        $detalleTraslado->traslado2_costo = $producto->producto_costo;
                        $detalleTraslado->save();

                        // Detalle traslado Prodbode origen y destino

                        $result = Prodbode::actualizar($producto, $destino->id, 'E', $detalleTraslado->traslado2_cantidad ,$destino->sucursal_defecto);
                        if(!$result instanceof Prodbode) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors'=> $result]);
                        }

                        //Maneja Serie
                        if ($producto->producto_maneja_serie == true) {

                            $lote = Lote::actualizar($producto, $origen->id, '', 'S', 1, "" ,$traslado->traslado1_fecha, null);
                            if (!$lote instanceof Lote) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => $lote]);
                            }
                            // Salida de prodbode
                            $result = Prodbode::actualizar($producto, $origen->id, 'S', 1, $lote->lote_ubicacion);
                            if(!$result instanceof Prodbode) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors'=> $result]);
                            }
                            // Inventario
                            $inventario = Inventario::movimiento($producto, $origen->id, $lote->lote_ubicacion,'TRAS', $traslado->id, 0, 1, [], [],$detalleTraslado->traslado2_costo, $detalleTraslado->traslado2_costo,$lote->id,[]);
                            if ($inventario != 'OK') {
                                DB::rollback();
                                return response()->json(['success' => false,'errors '=> $inventario]);
                            }
                            /**
                            *Entrada Inventario a sucursal destino
                            */
                            $lote = Lote::actualizar($producto, $destino->id, '', 'E', 1, $destino->sucursal_defecto, $traslado->traslado1_fecha, null);
                            if (!$lote instanceof Lote) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => 'No es posible recuperar lote, por favor verifique la información ó por favor consulte al administrador']);
                            }
                            // Inventario
                            $inventario = Inventario::movimiento($producto, $destino->id, $destino->sucursal_defecto,'TRAS', $traslado->id, 1, 0, [], [],$detalleTraslado->traslado2_costo, $detalleTraslado->traslado2_costo, $lote->id,[]);
                            if ($inventario != 'OK') {
                                DB::rollback();
                                return response()->json(['success' => false,'errors '=> $inventario]);
                            }
                        //Maneja Metros
                        }else if($producto->producto_metrado == true){
                            $items = isset($item['items']) ? $item['items'] : null;
                            foreach ($items as $key => $valueItem) {
                                if ($valueItem > 0) {

                                    list($text, $rollo) = explode("_", $key);

                                    // Individualiza en rollo --- $rollo hace las veces de lote
                                    $rollo = Rollo::actualizar($producto, $origen->id, 'S', $rollo, $traslado->traslado1_fecha, $valueItem, "");
                                    if (!$rollo->success) {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors' => $rollo->error]);
                                    }
                                    // Salida de prodbode
                                    $result = Prodbode::actualizar($producto, $origen->id, 'S', $valueItem, $rollo->rollo_ubicacion);
                                    if(!$result instanceof Prodbode) {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors'=> $result]);
                                    }
                                    // Inventario
                                    $inventario = Inventario::movimiento($producto, $origen->id, $rollo->rollo_ubicacion, 'TRAS', $traslado->id, 0, 0, [], $rollo->cantidad, $detalleTraslado->traslado2_costo, $detalleTraslado->traslado2_costo,0,$rollo->rollos);
                                    if ($inventario != 'OK') {
                                        DB::rollback();
                                        return response()->json(['success' => false,'errors '=> $inventario]);
                                    }
                                    /**
                                    * Entrada de rollo sucursal destino
                                    */
                                    $rolloDestino = Rollo::actualizar($producto, $destino->id, 'E', $rollo->rollo_lote, $traslado->traslado1_fecha, $valueItem, $destino->sucursal_defecto, $rollo->rollo_metros);
                                    if (!$rolloDestino->success) {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors' => $rolloDestino->error]);
                                    }
                                    // Inventario
                                    $inventario = Inventario::movimiento($producto, $destino->id, $destino->sucursal_defecto,'TRAS', $traslado->id, 0, 0, $rollo->cantidad, [], $detalleTraslado->traslado2_costo, $detalleTraslado->traslado2_costo,0,$rollo->rollos);
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
                                    $lote = Lote::actualizar($producto, $origen->id, $lote, 'S', $value, "");
                                    if (!$lote instanceof Lote) {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors' => $lote]);
                                    }
                                    // Salida de prodbode
                                    $result = Prodbode::actualizar($producto, $origen->id, 'S', $value, $lote->lote_ubicacion);
                                    if(!$result instanceof Prodbode) {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors'=> $result]);
                                    }
                                    // Inventario
                                    $inventario = Inventario::movimiento($producto, $origen->id, $lote->lote_ubicacion,'TRAS', $traslado->id, 0, $value, [], [], $detalleTraslado->traslado2_costo, $detalleTraslado->traslado2_costo,$lote->id,[]);
                                    if ($inventario != 'OK') {
                                        DB::rollback();
                                        return response()->json(['success' => false,'errors '=> $inventario]);
                                    }

                                    /**
                                    *Entrada sucursal destino
                                    */

                                    $lote = Lote::actualizar($producto, $destino->id, $lote->lote_numero, 'E', $value, $destino->sucursal_defecto, $traslado->traslado1_fecha, $lote->lote_vencimiento);
                                    if (!$lote instanceof Lote) {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors' => $lote]);
                                    }
                                    // Inventario
                                    $inventario = Inventario::movimiento($producto, $destino->id, $destino->sucursal_defecto,'TRAS', $traslado->id, $value, 0, [], [], $detalleTraslado->traslado2_costo, $detalleTraslado->traslado2_costo,$lote->id,[]);
                                    if ($inventario != 'OK') {
                                        DB::rollback();
                                        return response()->json(['success' => false,'errors '=> $inventario]);
                                    }
                                }
                            }
                        }
                    }
                    // Update consecutive sucursal_tras in Sucursal origen
                    $origen->sucursal_tras = $consecutive;
                    $origen->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $traslado->id ]);
                }catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $traslado->errors]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $traslado = Traslado1::getTraslado($id);
        if(!$traslado instanceof Traslado1){
            abort(404);
        }

        if ($request->ajax()) {
            return response()->json($traslado);
        }

        return view('inventario.traslados.show', ['traslado' => $traslado]);
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

    /**
     * Export pdf the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function exportar($id)
    {
        $traslado = Traslado1::getTraslado($id);
        if(!$traslado instanceof Traslado1) {
            abort(404);
        }
        $detalle = Traslado2::getTraslado2($traslado->id);
        $title = sprintf('Traslado N° %s', $traslado->traslado1_numero);

        // Export pdf
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML(View::make('inventario.traslados.export',  compact('traslado', 'detalle', 'title'))->render());
        return $pdf->stream(sprintf('%s_%s_%s_%s.pdf', 'traslado', $traslado->id, date('Y_m_d'), date('H_m_s')));
    }
}
