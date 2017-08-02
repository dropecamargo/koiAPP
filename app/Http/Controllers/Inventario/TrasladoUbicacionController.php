<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Inventario\TrasladoUbicacion1,App\Models\Inventario\TrasladoUbicacion2,App\Models\Inventario\TipoTraslado,App\Models\Inventario\Producto,App\Models\Inventario\Lote,App\Models\Inventario\Prodbode,App\Models\Inventario\Inventario,App\Models\Inventario\Rollo;
use App\Models\Base\Documentos, App\Models\Base\Sucursal, App\Models\Base\Ubicacion;
use DB,Log,Datatables,Auth;

class TrasladoUbicacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = TrasladoUbicacion1::query();
            $query->select('trasladou1.id', 'trasladou1_numero', 'trasladou1_fecha', 'o.ubicacion_nombre as ubicacion_origen', 'd.ubicacion_nombre as ubicacion_destino');   
            $query->join('ubicacion as o', 'trasladou1_origen', '=', 'o.id');
            $query->join('ubicacion as d', 'trasladou1_destino', '=', 'd.id');
            return Datatables::of($query)->make(true);
        }
        return view('inventario.trasladosubicaciones.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventario.trasladosubicaciones.create');
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
            $trasladou = new TrasladoUbicacion1;
            if ($trasladou->isValid($data)) {
                DB::beginTransaction();
                try {
                    
                    //Validar Documentos
                    $documento = Documentos::where('documentos_codigo', TrasladoUbicacion1::$default_document)->first();
                    if(!$documento instanceof Documentos) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar documentos,por favor verifique la información ó por favor consulte al administrador.']);
                    }
                    
                    // Recuperar
                    $sucursal = Sucursal::find($request->trasladou1_sucursal);
                    if(!$sucursal instanceof Sucursal) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar sucursal, por favor verifique la información o consulte al administrador.']);
                    }
                    
                    // Recuperar origen
                    $origen = Ubicacion::find($request->trasladou1_origen);
                    if(!$origen instanceof Ubicacion) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar sucursal origen, por favor verifique la información o consulte al administrador.']);
                    }
                    // Recuperar destino
                    $destino = Ubicacion::find($request->trasladou1_destino);
                    if(!$destino instanceof Ubicacion) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar sucursal destino, por favor verifique la información o consulte al administrador.']);
                    }
                    //Validar tipo traslado
                    $tipotraslado = TipoTraslado::find($request->trasladou1_tipotraslado);
                    if (!$tipotraslado instanceof TipoTraslado) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el tipo de traslado, por favor verifique la información o consulte al administrador']);
                    }

                    // Recuperar consecutivo
                    $consecutive = $sucursal->sucursal_trau + 1;

                    // Traslado 1
                    $trasladou->fill($data);
                    $trasladou->trasladou1_documentos = $documento->id;
                    $trasladou->trasladou1_numero = $consecutive;
                    $trasladou->trasladou1_tipotraslado = $tipotraslado->id;
                    $trasladou->trasladou1_sucursal = $sucursal->id;
                    $trasladou->trasladou1_origen = $origen->id;
                    $trasladou->trasladou1_destino = $destino->id;
                    $trasladou->trasladou1_usuario_elaboro = Auth::user()->id;
                    $trasladou->trasladou1_fh_elaboro = date('Y-m-d H:m:s'); 
                    $trasladou->save();

                    foreach ($data['detalle'] as $item) {

                        $producto = Producto::find($item['id_producto']);
                        if (!$producto instanceof Producto) {
                            DB::rollback();
                            return response()->json(['success' => false,'errors'=>'No es posible recuperar el producto,por favor verifique la información ó por favor consulte al administrador']);
                        }

                        // Detalle traslado
                        $detalleTrasladou = new TrasladoUbicacion2;
                        $detalleTrasladou->fill($item);
                        $detalleTrasladou->trasladou2_trasladou1 = $trasladou->id;
                        $detalleTrasladou->trasladou2_producto = $producto->id;
                        $detalleTrasladou->save();

                        // Detalle traslado Prodbode origen y destino


                        $result = Prodbode::actualizar($producto, $sucursal->id, 'E', $detalleTrasladou->trasladou2_cantidad ,$destino->id);
                        if(!$result instanceof Prodbode) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors'=> $result]);
                        }

                        //Maneja Serie
                        if ($producto->producto_maneja_serie == true) {

                            $lote = Lote::actualizar($producto, $sucursal->id, '', 'S', 1, $origen->id ,$trasladou->trasladou1_fecha, null);
                            if (!$lote instanceof Lote) {
                                dd($lote);
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => $lote]);
                            }
                            $result = Prodbode::actualizar($producto, $sucursal->id, 'S', 1, $lote->lote_ubicacion);
                            if(!$result instanceof Prodbode) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors'=> $result]);
                            }
                            // Inventario
                            $inventario = Inventario::movimiento($producto, $sucursal->id, $origen->id,'TRAU', $trasladou->id, 0, 1, [], [],$producto->producto_costo, $producto->producto_costo,$lote->id, []);
                            if ($inventario != 'OK') {
                                DB::rollback();
                                return response()->json(['success' => false,'errors '=> $inventario]);
                            }
                            /**
                            *Entrada Inventario a ubicacion destino
                            */
                            $lote = Lote::actualizar($producto, $sucursal->id, '', 'E', 1, $destino->id, $trasladou->trasladou1_fecha, null);
                            if (!$lote instanceof Lote) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => 'No es posible recuperar lote, por favor verifique la información ó por favor consulte al administrador']);
                            }
                            // Inventario
                            $inventario = Inventario::movimiento($producto, $sucursal->id, $destino->id,'TRAU', $trasladou->id, 1, 0, [], [],$producto->producto_costo, $producto->producto_costo, $lote->id,[]);
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
                                    $rollo = Rollo::actualizar($producto, $sucursal->id, 'S', $rollo, $trasladou->trasladou1_fecha, $valueItem, $origen->id);
                                    if (!$rollo->success) {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors' => $rollo->error]);
                                    }

                                    $result = Prodbode::actualizar($producto, $sucursal->id, 'S', $valueItem, $rollo->rollo_ubicacion);
                                    if(!$result instanceof Prodbode) {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors'=> $result]);
                                    }
                                    // Inventario
                                    $inventario = Inventario::movimiento($producto, $sucursal->id, $origen->id, 'TRAU', $trasladou->id, 0, 0, [], $rollo->cantidad, $producto->producto_costo, $producto->producto_costo,0,$rollo->rollos);
                                    if ($inventario != 'OK') {
                                        DB::rollback();
                                        return response()->json(['success' => false,'errors '=> $inventario]);
                                    }
                                    /**
                                    * Entrada de rollo ubicacion destino
                                    */
                                    $rolloDestino = Rollo::actualizar($producto, $sucursal->id, 'E', $rollo->rollo_lote, $trasladou->trasladou1_fecha, $valueItem, $destino->id, $rollo->rollo_metros);
                                    if (!$rolloDestino->success) {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors' => $rolloDestino->error]);
                                    }
                                    // Inventario
                                    $inventario = Inventario::movimiento($producto, $sucursal->id, $destino->id,'TRAU', $trasladou->id, 0, 0, $rollo->cantidad, [], $producto->producto_costo, $producto->producto_costo,0,$rollo->rollos);
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
                                    $lote = Lote::actualizar($producto, $sucursal->id, $lote, 'S', $value, $origen->id);
                                    if (!$lote instanceof Lote) {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors' => $lote]);
                                    }

                                    $result = Prodbode::actualizar($producto, $sucursal->id, 'S', $detalleTrasladou->trasladou2_cantidad, $lote->lote_ubicacion);
                                    if(!$result instanceof Prodbode) {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors'=> $result]);
                                    }
                                    // Inventario
                                    $inventario = Inventario::movimiento($producto, $sucursal->id, $origen->id,'TRAU', $trasladou->id, 0, $value, [], [], $producto->producto_costo, $producto->producto_costo,$lote->id,[]);
                                    if ($inventario != 'OK') {
                                        DB::rollback();
                                        return response()->json(['success' => false,'errors '=> $inventario]);
                                    }
                                    /**
                                    *Entrada ubicacion destino
                                    */
                                    $lote = Lote::actualizar($producto, $sucursal->id, $lote->lote_numero, 'E', $value, $destino->id, $trasladou->trasladou1_fecha, $lote->lote_vencimiento);
                                    if (!$lote instanceof Lote) {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors' => $lote]);
                                    }
                                    // Inventario
                                    $inventario = Inventario::movimiento($producto, $sucursal->id, $destino->id,'TRAU', $trasladou->id, $value, 0, [], [], $producto->producto_costo, $producto->producto_costo,$lote->id,[]);
                                    if ($inventario != 'OK') {
                                        DB::rollback();
                                        return response()->json(['success' => false,'errors '=> $inventario]);
                                    }
                                }
                            }
                        }
                    }

                    // Update consecutive sucursal_trau in Sucursal
                    $sucursal->sucursal_trau = $consecutive;
                    $sucursal->save();
                    
                    // Commit Transaction
                    DB::commit();
                    // DB::rollback();
                    // return response()->json(['success' => false, 'errors' => 'TODO OK' ]);
                    return response()->json(['success' => true, 'id' => $trasladou->id ]);
                }catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $trasladou->errors]);
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
        $trasladou = TrasladoUbicacion1::getTrasladoUbicacion($id);
        if(!$trasladou instanceof TrasladoUbicacion1){
            abort(404);
        }

        if ($request->ajax()) {
            return response()->json($trasladou);
        }

        return view('inventario.trasladosubicaciones.show', ['trasladou' => $trasladou]);
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
