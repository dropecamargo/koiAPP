<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Cartera\Factura1, App\Models\Cartera\Factura2, App\Models\Cartera\Factura3;
use App\Models\Comercial\Pedidoc1,App\Models\Comercial\Pedidoc2;
use App\Models\Inventario\Producto,App\Models\Inventario\SubCategoria,App\Models\Inventario\Lote,App\Models\Inventario\Ajuste2,App\Models\Inventario\Prodbode,App\Models\Inventario\Inventario,App\Models\Inventario\Inventariorollo,App\Models\Inventario\Prodboderollo,App\Models\Inventario\Prodbodelote,App\Models\Inventario\Prodbodevence;
use App\Models\Base\Tercero,App\Models\Base\PuntoVenta,App\Models\Base\Documentos,App\Models\Base\Sucursal, App\Models\Base\Contacto; 
use DB, Log, Datatables,Auth;

class Factura1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Factura1::query();
            $query->select('factura1.*', 'tercero_nit', 'tercero_razonsocial', 'tercero_nombre1', 'tercero_nombre2', 'tercero_apellido1', 'tercero_apellido2', 'puntoventa.puntoventa_prefijo','sucursal.sucursal_nombre',DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            );
            $query->join('tercero','factura1_tercero', '=', 'tercero.id');
            $query->join('puntoventa','factura1_puntoventa', '=', 'puntoventa.id');
            $query->join('sucursal','factura1_sucursal', '=', 'sucursal.id');
            return Datatables::of($query)->make(true);
        }
        return view('cartera.facturas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cartera.facturas.create');
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
            $factura1 = new Factura1;
            if ($factura1->isValid($data)) {
                DB::beginTransaction();
                try {
                    //Validar documentos
                    $documento = Documentos::where('documentos_codigo', Factura1::$default_document)->first();
                    if (!$documento instanceof Documentos) {
                        DB::rollback();
                        return response()->json(['success'=> false, 'errors' => 'No es posible recuperar documentos,por favor verifique la información ó por favor consulte al administrador.']);
                    }
                    // Validar cliente
                    $cliente = Tercero::where('tercero_nit',$request->factura1_tercero)->first();
                    if (!$cliente instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cliente, por favor verifique la información o consulte al administrador']);
                    }
                    // Validar contacto
                    $contacto = Contacto::find($request->factura1_tercerocontacto);
                    if(!$contacto instanceof Contacto) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar contacto, por favor verifique la información o consulte al administrador.']);
                    }

                    // Validar tercero contacto
                    if($contacto->tcontacto_tercero != $cliente->id) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'El contacto seleccionado no corresponde al cliente, por favor seleccione de nuevo el contacto o consulte al administrador.']);
                    }
                    // VAlidar vendedor
                    $vendedor = Tercero::find($request->factura1_vendedor);
                    if (!$vendedor instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar vendedor, por favor verifique la información o consulte al administrador']);
                    }
                    // Validar sucursal
                    $sucursal = Sucursal::find($request->factura1_sucursal);
                    if(!$sucursal instanceof Sucursal) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar sucursal,por favor verifique la información ó por favor consulte al administrador.']);
                    }
                    // Validar punto venta
                    $puntoventa = PuntoVenta::find($request->factura1_puntoventa);
                    if(!$puntoventa instanceof PuntoVenta) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar punto venta,por favor verifique la información ó por favor consulte al administrador.']);
                    }
                    $pedidoc1 = Pedidoc1::where('pedidoc1_sucursal', $sucursal->id)->where('pedidoc1_numero', $request->factura1_pedido)->first();
                    if (!$pedidoc1 instanceof Pedidoc1) {
                        DB:rollback();
                        return response()->json(['success'=> false, 'errors'=>'No es posible recuperar punto venta,por favor verifique la información ó por favor consulte al administrador.']);
                    }
                    // Consecutive punto venta 
                    $consecutive = $puntoventa->puntoventa_numero + 1;

                    // Factura1
                    $factura1->fill($data);
                    $factura1->factura1_sucursal = $sucursal->id;
                    $factura1->factura1_pedidoc1 = $pedidoc1->id;
                    $factura1->factura1_numero = $consecutive;
                    $factura1->factura1_puntoventa = $puntoventa->id;
                    $factura1->factura1_prefijo = $puntoventa->puntoventa_prefijo;
                    $factura1->factura1_documentos = $documento->id;
                    $factura1->factura1_tercero = $cliente->id;
                    $factura1->factura1_tercerocontacto = $contacto->id;
                    $factura1->factura1_vendedor = $vendedor->id;
                    $factura1->factura1_usuario_elaboro = Auth::user()->id;
                    $factura1->factura1_fh_elaboro = date('Y-m-d H:m:s');
                    $factura1->save();
                    foreach ($data['factura2'] as $item) {
                        $producto = Producto::where('producto_serie', $item['producto_serie'])->first();
                        if (!$producto instanceof Producto) {
                            DB::rollback();
                            return response()->json(['success' => false , 'errors' => 'No es posible recuperar producto, por favor verifique la información ó por favor consulte al administrador.']);
                        }
                        //SubCategoria validate
                        $subcategoria = SubCategoria::find($producto->producto_subcategoria);
                        if (!$subcategoria instanceof SubCategoria) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar subcategoria, por favor verifique información o consulte al administrador']);
                        }
                        //prepare detalle2
                        $pedidoc2 = Pedidoc2::where('pedidoc2_pedidoc1', $pedidoc1->id)->where('pedidoc2_producto',$producto->id)->first();
                        if (!$pedidoc2 instanceof Pedidoc2) {
                            DB::rollback();
                            return response()->json(['success'=>false , 'errors'=> 'No es posible recuperar subcategoria, por favor verifique información o consulte al administrador']);
                        }
                        // Maneja serie
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
                            // Detalle factura
                            $factura2 = new Factura2;
                            $factura2->fill($item);
                            $factura2->factura2_factura1 = $factura1->id;
                            $factura2->factura2_producto = $producto->id;
                            $factura2->factura2_subcategoria = $subcategoria->id;
                            $factura2->factura2_margen = $subcategoria->subcategoria_margen_nivel1;
                            $factura2->save();
                            
                            // Movimiento salidaManejaSerie
                            $movimiento = Inventario::salidaManejaSerie($producto, $sucursal, $lote);
                            if($movimiento != 'OK') {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => $movimiento]);
                            }

                            // Inventario
                            $inventario = Inventario::movimiento($producto, $sucursal->id, 'FACT', $factura1->id, 0, $factura2->factura2_cantidad, $factura2->factura2_costo, $factura2->factura2_costo);
                            if (!$inventario instanceof Inventario) {
                                DB::rollback();
                                return response()->json(['success' => false,'errors' => $inventario]);
                            }
                            
                        // Metrado
                        }else if ($producto->producto_metrado == true) {
                            // ProdBode
                            $result = Prodbode::actualizar($producto, $sucursal->id, 'S', $item['factura2_cantidad']);
                            if($result != 'OK') {                                            
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => $result]);
                            }

                            // Inventario
                            $inventario = Inventario::movimiento($producto, $sucursal->id, 'FACT', $factura1->id, 0, $item['factura2_cantidad'], $producto->producto_costo, $producto->producto_costo);
                            if (!$inventario instanceof Inventario) {
                                DB::rollback();
                                return response()->json(['success' => false,'errors' => $inventario]);
                            }

                            $items = isset($item['items']) ? $item['items'] : null;
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
                                    $prodboderollo = Prodboderollo::actualizar($producto, $sucursal->id, 'S', $prodboderollo->prodboderollo_item,$lote,$value, $producto->producto_costo);
                                    if(!$prodboderollo instanceof Prodboderollo) {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors'=>$prodboderollo]);
                                    }

                                    // Inventario rollo
                                    $result = Inventariorollo::movimiento($inventario, $prodboderollo, $item['factura2_costo'], $producto->producto_costo, 0, $value);
                                    if(!$result instanceof Inventariorollo) {
                                        DB::rollback();
                                        return response()->json(['success' => false, 'errors' => $result]);
                                    }
                                    
                                    // Detalle factura
                                    $factura2 = new Factura2;
                                    $factura2->fill($item);
                                    $factura2->factura2_factura1 = $factura1->id;
                                    $factura2->factura2_producto = $producto->id;
                                    $factura2->factura2_subcategoria = $subcategoria->id;
                                    $factura2->factura2_margen = $subcategoria->subcategoria_margen_nivel1;
                                    $factura2->save();
                                }
                            }
                        //Producto vence
                        }else if($producto->producto_vence == true){
                            // ProdBode
                            $result = Prodbode::actualizar($producto, $sucursal->id, 'S', $item['factura2_cantidad']);
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
                                    $result = Prodbodevence::firstExit($producto, $sucursal->id, $loteVence ,$value);
                                    if ($result != 'OK') {
                                        DB::rollback();
                                        return response()->json(['success'=> false, 'errors' => $result]);
                                    }
                                    // Detalle factura
                                    $factura2 = new Factura2;
                                    $factura2->fill($item);
                                    $factura2->factura2_factura1 = $factura1->id;
                                    $factura2->factura2_producto = $producto->id;
                                    $factura2->factura2_subcategoria = $subcategoria->id;
                                    $factura2->factura2_margen = $subcategoria->subcategoria_margen_nivel1;
                                    $factura2->save();
                                }
                            }
                        // Normal
                        }else {
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

                                    $inventario = Inventario::movimiento($producto, $sucursal->id, 'FACT', $factura1->id, 0, $value, $producto->producto_costo, $producto->producto_costo);
                                    if (!$inventario instanceof Inventario) {
                                        DB::rollback();
                                        return response()->json(['success' => false,'errors'=>'No es posible realizar inventario,por favor verifique la información ó por favor consulte al administrador']);
                                    }
                                    // Detalle factura
                                    $factura2 = new Factura2;
                                    $factura2->fill($item);
                                    $factura2->factura2_factura1 = $factura1->id;
                                    $factura2->factura2_producto = $producto->id;
                                    $factura2->factura2_subcategoria = $subcategoria->id;
                                    $factura2->factura2_margen = $subcategoria->subcategoria_margen_nivel1;
                                    $factura2->save();
                                }
                            }
                        }
                    }
                    $factura3 = Factura3::storeFactura3($factura1);
                    if (!$factura3) {
                        DB::rollback();
                        return response()->json(['success'=> false, 'errors'=>'No es posible realizar factura3,por favor verifique la información ó por favor consulte al administrador']);
                    }
                    // Update consecutive puntoventa_numero in PuntoVenta
                    $puntoventa->puntoventa_numero = $consecutive;
                    $puntoventa->save();

                    // Update pedidoc1_factura1 in pedidoc1
                    $pedidoc1->pedidoc1_factura1 = $factura1->id;
                    $pedidoc1->save();
                    DB::commit();
                    return response()->json(['success'=>true , 'id' => $factura1->id]);
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]); 
                }
            }   
            return response()->json(['success' => false, 'errors' => $factura1->errors]);
        }
        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $factura = Factura1::getFactura($id);
        if(!$factura instanceof Factura1) {
            abort(404);
        }
         if($request->ajax()) {
            return response()->json($factura);
        }
        return view('cartera.facturas.show', ['factura' => $factura]);
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
