<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Inventario\Traslado1,App\Models\Inventario\Traslado2,App\Models\Inventario\TipoTraslado,App\Models\Inventario\Producto,App\Models\Inventario\Lote,App\Models\Inventario\Prodbode,App\Models\Inventario\Inventario,App\Models\Inventario\Inventariorollo,App\Models\Inventario\Prodboderollo,App\Models\Inventario\Prodbodelote,App\Models\Inventario\Prodbodevence;
use App\Models\Base\Documentos, App\Models\Base\Sucursal;
use DB,Log,Datatables,Auth;

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
                    $consecutive = $origen->sucursal_traslado + 1;

                    // Traslado 1
                    $traslado->fill($data);
                    $traslado->traslado1_documentos = $documento->id;
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

                        //Maneja Serie
                        if ($producto->producto_maneja_serie == true) {

                            $prodbodelote = Prodbodelote::where('prodbodelote_serie', $producto->id)->where('prodbodelote_saldo', 1)->first();
                            if (!$prodbodelote instanceof Prodbodelote) {
                                DB::rollback();
                                return response()->json(['success' => false,'errors' => 'No es posible recuperar el LOTE,por favor verifique la información ó por favor consulte al administrador']);
                            }
                            $lote = Lote::find($prodbodelote->prodbodelote_lote);
                            if (!$lote instanceof Lote) {
                                DB::rollback();
                                return response()->json(['success' => false,'errors' => 'No es posible recuperar el LOTE,por favor verifique la información ó por favor consulte al administrador']);
                            }
                            // Detalle traslado
                            $detalleTraslado = new Traslado2;
                            $detalleTraslado->fill($item);
                            $detalleTraslado->traslado2_traslado1 = $traslado->id;
                            $detalleTraslado->traslado2_producto = $producto->id;
                            $detalleTraslado->traslado2_lote = $lote->id;
                            $detalleTraslado->traslado2_costo = $producto->producto_costo;
                            $detalleTraslado->save();
                            
                            // Movimiento salidaManejaSerie
                            $movimiento = Inventario::salidaManejaSerie($producto, $origen, $lote);
                            if($movimiento != 'OK') {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => $movimiento]);
                            }

                            // Inventario Movimiento
                            $inventario = Inventario::movimiento($producto, $origen->id, 'TRAS', $traslado->id, 0, 1, $detalleTraslado->traslado2_costo, $detalleTraslado->traslado2_costo);
                            if (!$inventario instanceof Inventario) {
                                DB::rollback();
                                return response()->json(['success' => false,'errors' => $inventario]);
                            }

                            /*
                            * Destino Entrada
                            * Movimiento entradaManejaSerie
                            */
                            $movimiento = Inventario::entradaManejaSerie($producto, $destino, $lote,$item["producto_serie"], $producto->producto_costo);
                            if($movimiento != 'OK') {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => $movimiento]);
                            }

                            $serie = Producto::where('producto_serie', $item["producto_serie"])->first();
                            if(!$serie instanceof Producto) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => 'No es posible recuperar serie, por favor verifique la información ó por favor consulte al administrador']);    
                            }
                            // Inventario
                            $inventario = Inventario::movimiento($serie, $destino->id, 'TRAS', $traslado->id, 1, 0, $detalleTraslado->traslado2_costo, $detalleTraslado->traslado2_costo);
                            if (!$inventario instanceof Inventario) {
                                DB::rollback();
                                return response()->json(['success' => false,'errors '=> $inventario]);
                            }
                        //Maneja Metros   
                        }else if($producto->producto_metrado == true){
                            // ProdBode
                            $result = Prodbode::actualizar($producto, $origen->id, 'S', $item['traslado2_cantidad']);
                            if($result != 'OK') {                                            
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => $result]);
                            }

                            // Inventario
                            $inventario = Inventario::movimiento($producto, $origen->id, 'TRAS', $traslado->id, 0, $item['traslado2_cantidad'], $producto->producto_costo, $producto->producto_costo);
                            if (!$inventario instanceof Inventario) {
                                DB::rollback();
                                return response()->json(['success' => false,'errors' => $inventario]);
                            }

                            $items = isset($item['items']) ? $item['items'] : null;
                            $itemRollo = 0;
                            foreach ($items as $key => $value) 
                            {
                                if($value > 0) {
                                    // Recuperar lote
                                    list($text, $lote) = explode("_", $key);
                                    $prodboderollo = Prodboderollo::find($lote);
                                    if(!$prodboderollo instanceof Prodboderollo){
                                        DB::rollback();
                                        return response()->json(['success'=> false, 'errors'=> 'No es posible encontrar lote , por favor verifique la información ó por favor consulte al administrador']);
                                    }
                                    $lote = Lote::find($prodboderollo->prodboderollo_lote);
                                    if (!$lote instanceof Lote) {
                                        DB::rollback();
                                        return response()->json(['success' => false,'errors' => 'No es posible recuperar el LOTE,por favor verifique la información ó por favor consulte al administrador']);
                                    }
                                    // Prodbode rollo
                                    $prodboderollo = Prodboderollo::actualizar($producto, $origen->id, 'S', $prodboderollo->prodboderollo_item,$lote,$value, $producto->producto_costo);
                                    if(!$prodboderollo instanceof Prodboderollo) {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors'=>$prodboderollo]);
                                    }

                                    // Inventario rollo
                                    $result = Inventariorollo::movimiento($inventario, $prodboderollo, $producto->producto_costo, $producto->producto_costo, 0, $value);
                                    if(!$result instanceof Inventariorollo) {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors' => $result]);
                                    }
                                    
                                    /*
                                    *Entrada
                                    *Sucursal Destino Metros
                                    */
                                    $itemRollo = DB::table('prodboderollo')->where('prodboderollo_serie', $producto->id)->where('prodboderollo_sucursal', $destino->id)->where('prodboderollo_lote', $prodboderollo->prodboderollo_lote)->max('prodboderollo_item');

                                    $itemRollo++;
                                    $prodboderolloIn = Prodboderollo::actualizar($producto, $destino->id, 'E', $itemRollo, $lote, $value, $producto->producto_costo );
                                    if(!$prodboderolloIn instanceof Prodboderollo) {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors'=> $prodboderolloIn]);
                                    }

                                    $result = Inventariorollo::movimiento($inventario, $prodboderolloIn, $producto->producto_costo, $producto->producto_costo, $value, 0 );
                                    if(!$result instanceof Inventariorollo) {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors'=> $result]);
                                    }
                                    // Detalle traslado
                                    $detalleTraslado = new Traslado2;
                                    $detalleTraslado->fill($item);
                                    $detalleTraslado->traslado2_traslado1 = $traslado->id;
                                    $detalleTraslado->traslado2_producto = $producto->id;
                                    $detalleTraslado->traslado2_lote = $prodboderollo->prodboderollo_lote;
                                    $detalleTraslado->traslado2_costo = $producto->producto_costo;
                                    $detalleTraslado->save();
                                }
                            }
                        //Maneja vencimiento
                        }else if($producto->producto_vence == true){

                            // ProdBode
                            $result = Prodbode::actualizar($producto, $origen->id, 'S', $item['traslado2_cantidad']);
                            if($result != 'OK') {                                            
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => $result]);
                            }
                            $items = isset($item['items']) ? $item['items'] : null;

                            foreach ($items as $key => $value) {
                                if ($value > 0) {
                                    list($text, $stockid) = explode("_", $key);

                                    $prodbodevence = prodbodevence::find($stockid);
                                    if (!$prodbodevence instanceof Prodbodevence) {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar PRODBODEVENCE por favor verificar información o consulte con el administrador']);
                                    }
                                    $loteVence = Lote::find($prodbodevence->prodbodevence_lote);
                                    if (!$loteVence instanceof Lote) {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar LOTE por favor verificar información o consulte con el administrador']);
                                    }
                                    $result = Prodbodevence::firstExit($producto, $origen->id, $loteVence ,$value);
                                    if ($result != 'OK') {
                                        DB::rollback();
                                        return response()->json(['success'=> false, 'errors' => $result]);
                                    }
                                    $itemVence = DB::table('prodbodevence')->where('prodbodevence_serie', $producto->id)->where('prodbodevence_sucursal', $destino->id)->where('prodbodevence_lote', $prodbodevence->prodbodevence_lote)->max('prodbodevence_item');

                                    for ($i=0; $i < $value; $i++) { 
                                        $itemVence++;
                                        $prodbodevenceIn = Prodbodevence::actualizar($producto, $destino->id, 'E', $itemVence, $loteVence,1 );
                                        if(!$prodbodevenceIn instanceof Prodbodevence) {
                                            DB::rollback();
                                            return response()->json(['success' => false, 'errors'=> $prodbodevenceIn]);
                                        }
                                    }
                                    // Detalle traslado
                                    $detalleTraslado = new Traslado2;
                                    $detalleTraslado->fill($item);
                                    $detalleTraslado->traslado2_traslado1 = $traslado->id;
                                    $detalleTraslado->traslado2_producto = $producto->id;
                                    $detalleTraslado->traslado2_lote = $loteVence->id;
                                    $detalleTraslado->traslado2_costo = $producto->producto_costo;
                                    $detalleTraslado->save();
                                }
                            }
                        }else{
                            $items = isset($item['items']) ? $item['items'] : null;
                            foreach ($items as $key => $value) 
                            {
                                if($value > 0) {
                                    // Recuperar lote
                                    list($text, $lote) = explode("_", $key);
                                    $prodbodelote = Prodbodelote::find($lote);
                                    if (!$prodbodelote instanceof Prodbodelote) {
                                        DB::rollback();
                                        return response()->json(['success' => false,'errors'=>'No es posible recuperar el LOTE, por favor verifique la información ó por favor consulte al administrador']);
                                    }
                                    $lote = Lote::find($prodbodelote->prodbodelote_lote);
                                    if (!$lote instanceof Lote) {
                                        DB::rollback();
                                        return response()->json(['success' => false,'errors' => 'No es posible recuperar el LOTE,por favor verifique la información ó por favor consulte al administrador']);
                                    }   
                                    // ProdBode
                                    $result = Prodbode::actualizar($producto, $origen->id, 'S', $value);
                                    if($result != 'OK') {                                            
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors'=>$result]);
                                    }

                                    //ProdBodeLote
                                    $result = Prodbodelote::actualizar($producto, $origen->id, $lote,'S', $value);
                                    if($result != 'OK') {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors' => $result]);
                                    }

                                    $inventario = Inventario::movimiento($producto, $origen->id, 'TRAS', $traslado->id, 0, $value, $producto->producto_costo, $producto->producto_costo);
                                    if (!$inventario instanceof Inventario) {
                                        DB::rollback();
                                        return response()->json(['success' => false,'errors'=>'No es posible realizar inventario,por favor verifique la información ó por favor consulte al administrador']);
                                    }

                                    /*
                                    *Entrada producto normal en sucursal destino
                                    */
                                    // Prodbode
                                    $result = Prodbode::actualizar($producto, $destino->id, 'E', $value);
                                    if($result != 'OK') {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors'=> $result]);
                                    }
                                    if($result != 'OK') {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors' => $result]);
                                    }
                                    $result = Prodbodelote::actualizar($producto, $destino->id, $lote,'E',$value);

                                    // Inventario
                                    $inventario = Inventario::movimiento($producto, $destino->id, 'TRAS', $traslado->id, $value, 0,$producto->producto_costo, $producto->producto_costo);
                                    if (!$inventario instanceof Inventario) {
                                        DB::rollback();
                                        return response()->json(['success' => false,'errors' => $inventario]);
                                    } 
                                    // Detalle traslado
                                    $detalleTraslado = new Traslado2;
                                    $detalleTraslado->fill($item);
                                    $detalleTraslado->traslado2_traslado1 = $traslado->id;
                                    $detalleTraslado->traslado2_producto = $producto->id;
                                    $detalleTraslado->traslado2_lote = $lote->id;
                                    $detalleTraslado->traslado2_costo = $producto->producto_costo;
                                    $detalleTraslado->save();
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
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
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
}
