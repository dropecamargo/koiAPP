<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\AsientoContableDocumento, App\Classes\AsientoNifContableDocumento;
use App\Models\Cartera\Devolucion1,App\Models\Cartera\Devolucion2,App\Models\Cartera\Factura1,App\Models\Cartera\Factura2;
use App\Models\Base\Documentos,App\Models\Base\Sucursal,App\Models\Base\Tercero;
use App\Models\Inventario\Producto, App\Models\Inventario\Linea, App\Models\Inventario\Impuesto, App\Models\Inventario\Inventario, App\Models\Inventario\Prodbode, App\Models\Inventario\Lote, App\Models\Inventario\Rollo;
use DB, Log, Datatables,Auth;

class Devolucion1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Devolucion1::query();
            $query->select('devolucion1.*', 'factura1_numero','tercero_nit', 'tercero_razonsocial', 'tercero_nombre1', 'tercero_nombre2', 'tercero_apellido1', 'tercero_apellido2','sucursal.sucursal_nombre',DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            );
            $query->join('tercero','devolucion1_tercero', '=', 'tercero.id');
            $query->join('sucursal','devolucion1_sucursal', '=', 'sucursal.id');
            $query->join('factura1','devolucion1_factura', '=', 'factura1.id');
            $query->orderBy('devolucion1.id', 'desc');
            return Datatables::of($query)->make(true);
        }
        return view('cartera.devoluciones.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cartera.devoluciones.create');
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
            $devolucion1 = new Devolucion1;
            if ($devolucion1->isValid($data)) {
                DB::beginTransaction();
                try {
                    //Validar documentos
                    $documento = Documentos::where('documentos_codigo', Devolucion1::$default_document)->first();
                    if (!$documento instanceof Documentos) {
                        DB::rollback();
                        return response()->json(['success'=> false, 'errors' => 'No es posible recuperar documentos,por favor verifique la información ó por favor consulte al administrador.']);
                    }
                    // Validar sucursal
                    $sucursal = Sucursal::find($request->devolucion1_sucursal);
                    if (!$sucursal instanceof Sucursal) {
                        DB::rollback();
                        return response()->json(['success' => false , 'No es posible recuperar sucursal,por favor verifique la información ó por favor consulte al administrador.']);
                    }
                    // Validar factura1
                    $factura1 = Factura1::where('factura1_sucursal',$sucursal->id)->where('factura1_numero',$request->devolucion1_factura1)->first();
                    if (!$factura1 instanceof Factura1) {
                        DB::rollback();
                        return response()->json(['success'=> false, 'errors' => 'No es posible recuperar factura,por favor verifique la información ó por favor consulte al administrador.']);
                    }
                    // Validar cliente
                    $cliente = Tercero::where('tercero_nit',$request->devolucion1_tercero)->first();
                    if (!$cliente instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cliente, por favor verifique la información o consulte al administrador']);
                    }
                    // Consecutive sucursal
                    $consecutive = $sucursal->sucursal_devo + 1;

                    $devolucion1->fill($data);
                    $devolucion1->devolucion1_documentos = $documento->id;
                    $devolucion1->devolucion1_sucursal = $sucursal->id;
                    $devolucion1->devolucion1_numero = $consecutive;
                    $devolucion1->devolucion1_tercero = $cliente->id;
                    $devolucion1->devolucion1_factura = $factura1->id;
                    $devolucion1->devolucion1_usuario_elaboro = Auth::user()->id;
                    $devolucion1->devolucion1_fh_elaboro = date('Y-m-d H:i:s');
                    $devolucion1->save();

                    // Reference fields
                    $iva = $bruto = $descuento = $total = 0;
                    $cuentas = [];
                    $factura2 = Factura2::where('factura2_factura1', $factura1->id)->get();
                    foreach ($factura2 as $value) {
                        // Concateno request
                        $cantidad = "devolucion2_cantidad_$value->id";
                        if ($request->$cantidad > 0) {
                            // Producto
                            $producto = Producto::find($value->factura2_producto);
                            if (!$producto instanceof Producto) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique la información ó por favor consulte al administrador.']);
                            }
                            // Linea validate
                            $linea = Linea::find($producto->producto_linea);
                            if ( !$linea instanceof Linea ) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => 'No es posible recuperar linea, por favor verifique información o consulte al administrador']);
                            }
                            // Impuesto validate
                            $impuesto = Impuesto::find($producto->producto_impuesto);
                            if ( !$linea instanceof Linea ) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => 'No es posible recuperar impuesto, por favor verifique información o consulte al administrador']);
                            }
                            // Devolucion2
                            $devolucion2 = new Devolucion2;
                            $result = $devolucion2->store($value, $producto->id, $devolucion1->id, $request->$cantidad);
                            if ( $result != 'OK' ) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => $result ]);
                            }
                            // Iva, Bruto, Descuento, Total (Devolcion1)
                            $factor = $devolucion2->devolucion2_iva / 100;
                            if ($devolucion2->devolucion2_precio > 0) {
                                $iva += $devolucion2->devolucion2_precio * $factor * $devolucion2->devolucion2_cantidad;
                                $bruto += $devolucion2->devolucion2_precio * $devolucion2->devolucion2_cantidad;
                            }else{
                                $iva += $devolucion2->devolucion2_costo * $factor * $devolucion2->devolucion2_cantidad;
                                $bruto += $devolucion2->devolucion2_costo * $devolucion2->devolucion2_cantidad;
                            }
                            $descuento += $devolucion2->devolucion2_descuento;
                            $total += ($bruto + $iva) - $descuento;

                            // Detalle asiento
                            $cuentas[] = $devolucion1->asientoCuentas($cliente, $linea->linea_venta, 'D', $bruto);
                            $cuentas[] = $devolucion1->asientoCuentas($cliente, $impuesto->impuesto_cuenta, 'D', $iva, $bruto - $devolucion2->devolucion2_descuento );
                            if ($devolucion2->devolucion2_descuento > 0) {
                                $cuentas[] = $factura1->asientoCuentas($cliente, $linea->linea_venta, 'C', $factura2->devolucion2_descuento);
                            }

                            // Inventario
                            $inventario = Inventario::where('inventario_documentos',$factura1->factura1_documentos)->where('inventario_id_documento',$factura1->id)->where('inventario_serie', $producto->id)->where('inventario_sucursal', $sucursal->id)->first();
                            if (!$inventario instanceof Inventario) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => 'No es posible recuperar inventario, por favor verifique la información ó por favor consulte al administrador.']);
                            }
                            if ($producto->producto_maneja_serie == true) {
                                // Prodbode
                                $result = Prodbode::actualizar($producto, $sucursal->id, 'E', 1, $sucursal->sucursal_defecto);
                                if(!$result instanceof Prodbode) {
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors'=> $result]);
                                }
                                // lote
                                $lote = Lote::find($inventario->inventario_lote);
                                if (!$lote instanceof Lote) {
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar lote, por favor verifique la información ó por favor consulte al administrador']);
                                }
                                $lote->lote_saldo = 1;
                                $lote->save();
                                // Inventario
                                $inventario = Inventario::movimiento($producto, $sucursal->id, $sucursal->sucursal_defecto,'DEVO', $devolucion1->id, 1, 0, [], [], $value->factura2_costo, $value->factura2_costo, $lote->id,[]);
                                if ($inventario != 'OK') {
                                    DB::rollback();
                                    return response()->json(['success' => false,'errors '=> $inventario]);
                                }
                            }else if ($producto->producto_metrado == true){
                                // Prodbode metros
                                $result = Prodbode::actualizar($producto, $sucursal->id, 'E', $request->$cantidad, $sucursal->sucursal_defecto);
                                if(!$result instanceof Prodbode) {
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors'=> $result]);
                                }
                                // Recupero rollo de table inventario
                                $rollo = Rollo::find($inventario->inventario_rollo);
                                if (!$rollo instanceof Rollo) {
                                    DB::rollback();
                                  return response()->json(['success' => false, 'errors' => 'No es posible recuperar rollo, por favor verifique la información ó por favor consulte al administrador']);
                                }
                                // Rollo
                                $rollo = Rollo::actualizar($producto, $sucursal->id, 'E', $rollo->rollo_lote, $devolucion1->devolucion1_fh_elaboro, $request->$cantidad, $sucursal->sucursal_defecto);
                                if (!$rollo->success) {
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors' => $rollo->error]);
                                }
                                // Inventario
                                $inventario = Inventario::movimiento($producto, $sucursal->id, $sucursal->sucursal_defecto,'DEVO', $factura1->id, 0, 0,$rollo->cantidad, [],$value->factura2_costo, $value->factura2_costo,0,$rollo->rollos);
                                if ($inventario != 'OK') {
                                    DB::rollback();
                                    return response()->json(['success' => false,'errors '=> $inventario]);
                                }
                            }else{
                                // Prodbode
                                $result = Prodbode::actualizar($producto, $sucursal->id, 'E', $request->$cantidad, $sucursal->sucursal_defecto);
                                if(!$result instanceof Prodbode) {
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors'=> $result]);
                                }
                                // lote
                                $lote = Lote::find($inventario->inventario_lote);
                                if (!$lote instanceof Lote) {
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar lote, por favor verifique la información ó por favor consulte al administrador']);
                                }
                                $lote->lote_saldo = $lote->lote_saldo + $request->$cantidad;
                                $lote->save();
                                // Inventario
                                $inventario = Inventario::movimiento($producto, $sucursal->id, $sucursal->sucursal_defecto,'DEVO', $devolucion1->id, $request->$cantidad, 0, [], [], $value->factura2_costo, $value->factura2_costo, $lote->id,[]);
                                if ($inventario != 'OK') {
                                    DB::rollback();
                                    return response()->json(['success' => false,'errors'=> $inventario]);
                                }
                            }
                        }
                    }
                    // Update saldo cuota 1 de factura 3
                    $devolucion2 = Devolucion2::doCalculate($devolucion1,$factura1);
                    if ($devolucion2 != 'OK') {
                        DB::rollback();
                        return response()->json(['success' => false,'errors'=> $devolucion2]);
                    }

                    // Calculos totales devolucion1
                    $devolucion1->devolucion1_bruto = $bruto;
                    $devolucion1->devolucion1_iva = $iva;
                    $devolucion1->devolucion1_descuento = $descuento;
                    $devolucion1->devolucion1_total = $total;

                    // Preparando asiento
                    $encabezado = $devolucion1->encabezadoAsiento($cliente);
                    $cuentas[] = $devolucion1->asientoCuentas($cliente, session('empresa')->empresa_cuentacartera, 'C');
                    // Creo el objeto para manejar el asiento
                    $objAsiento = new AsientoContableDocumento($encabezado->data);
                    if($objAsiento->asiento_error) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $objAsiento->asiento_error]);
                    }
                    // Preparar asiento
                    $result = $objAsiento->asientoCuentas($cuentas);
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
                        $result = $objAsientoNif->asientoCuentas($cuentas);
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
                        // Recuperar el Id del asiento y guardar en la devolucion
                        $devolucion1->devolucion1_asienton = $objAsientoNif->asientoNif->id;
                    }
                    $devolucion1->devolucion1_asiento = $objAsiento->asiento->id;
                    $devolucion1->save();

                    // Update consecutive sucursal_devo in Sucursal
                    $sucursal->sucursal_devo = $consecutive;
                    $sucursal->save();

                    DB::commit();
                    return response()->json(['success' => true, 'id' => $devolucion1->id ]);
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $devolucion1->errors]);
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
        $devolucion1 = Devolucion1::getDevolucion($id);
        if(!$devolucion1 instanceof Devolucion1) {
            abort(404);
        }
         if($request->ajax()) {
            return response()->json($devolucion1);
        }
        return view('cartera.devoluciones.show', ['devolucion' => $devolucion1]);
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
