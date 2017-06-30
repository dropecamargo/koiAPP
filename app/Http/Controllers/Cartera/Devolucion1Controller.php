<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Cartera\Devolucion1,App\Models\Cartera\Devolucion2,App\Models\Cartera\Factura1,App\Models\Cartera\Factura2;
use App\Models\Base\Documentos,App\Models\Base\Sucursal,App\Models\Base\Tercero;
use App\Models\Inventario\Producto, App\Models\Inventario\Inventario, App\Models\Inventario\Prodbode, App\Models\Inventario\Lote, App\Models\Inventario\Rollo;
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
            $query->select('devolucion1.*', 'tercero_nit', 'tercero_razonsocial', 'tercero_nombre1', 'tercero_nombre2', 'tercero_apellido1', 'tercero_apellido2','sucursal.sucursal_nombre',DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            );
            $query->join('tercero','devolucion1_tercero', '=', 'tercero.id');
            $query->join('sucursal','devolucion1_sucursal', '=', 'sucursal.id');
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
                            // Devolucion2
                            $devolucion2 = new Devolucion2;
                            $result = $devolucion2->store($value, $producto->id, $devolucion1->id, $request->$cantidad);
                            if ( $result != 'OK' ) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => $result ]);
                            }
                            // Inventario
                            $inventario = Inventario::where('inventario_documentos',$factura1->factura1_documentos)->where('inventario_id_documento',$factura1->id)->where('inventario_serie', $producto->id)->where('inventario_sucursal', $sucursal->id)->first();
                            if (!$inventario instanceof Inventario) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => 'No es posible recuperar inventario, por favor verifique la información ó por favor consulte al administrador.']);
                            }
                            if ($producto->producto_maneja_serie == true) {
                                // Prodbode
                                $result = Prodbode::actualizar($producto, $sucursal->id, 'E', 1);
                                if($result != 'OK') {
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

                                // Inventario
                                $inventario = Inventario::movimiento($producto, $sucursal->id, 'DEVO', $devolucion1->id, 1, 0, 0, 0, $value->factura2_costo, $value->factura2_costo, $lote->id);
                                if (!$inventario instanceof Inventario) {
                                    DB::rollback();
                                    return response()->json(['success' => false,'errors '=> $inventario]);
                                }
                            }else if ($producto->producto_metrado == true){
                                // Prodbode metros
                                $result = Prodbode::actualizar($producto, $sucursal->id, 'E', $request->$cantidad);
                                if($result != 'OK') {
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors'=> $result]);
                                }
                                // Rollo
                                $rollo = Rollo::find($inventario->inventario_rollo);
                                if (!$rollo instanceof Rollo) {
                                    DB::rollback();
                                  return response()->json(['success' => false, 'errors' => 'No es posible recuperar rollo, por favor verifique la información ó por favor consulte al administrador']);
                                }
                                $rollo->rollo_saldo = ($rollo->rollo_saldo + $request->$cantidad);  
                                // Inventario
                                $inventario = Inventario::movimiento($producto, $sucursal->id, 'DEVO', $devolucion1->id, 0, 0, $request->$cantidad, 0, $value->factura2_costo, $value->factura2_costo, $rollo->id);
                                if (!$inventario instanceof Inventario) {
                                    DB::rollback();
                                    return response()->json(['success' => false,'errors '=> $inventario]);
                                }
                            }else{
                                // Prodbode
                                $result = Prodbode::actualizar($producto, $sucursal->id, 'E', $request->$cantidad);
                                if($result != 'OK') {
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors'=> $result]);
                                }
                                // lote
                                $lote = Lote::find($inventario->inventario_lote);
                                if (!$lote instanceof Lote) {
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar lote, por favor verifique la información ó por favor consulte al administrador']);
                                }
                                $lote->lote_saldo = $request->$cantidad;

                                // Inventario
                                $inventario = Inventario::movimiento($producto, $sucursal->id, 'DEVO', $devolucion1->id, $request->$cantidad, 0, 0, 0, $value->factura2_costo, $value->factura2_costo, $lote->id);
                                if (!$inventario instanceof Inventario) {
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
