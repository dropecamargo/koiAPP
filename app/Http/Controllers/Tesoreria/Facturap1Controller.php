<?php

namespace App\Http\Controllers\Tesoreria;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Tesoreria\Facturap1,App\Models\Tesoreria\Facturap2,App\Models\Tesoreria\Facturap3,App\Models\Tesoreria\TipoProveedor,App\Models\Tesoreria\TipoGasto,App\Models\Tesoreria\ReteFuente;
use App\Models\Inventario\Entrada1, App\Models\Inventario\Impuesto;
use App\Models\Contabilidad\ActivoFijo;
use App\Models\Base\Tercero,App\Models\Base\Documentos,App\Models\Base\Regional;
use DB, Log, Datatables, Cache;

class Facturap1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Facturap1::query();
            $query->select('facturap1.*', 'regional_nombre',
                DB::raw("
                    CONCAT(
                        (CASE WHEN tercero_persona = 'N'
                            THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                                (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                            )
                            ELSE tercero_razonsocial
                        END)
                    ) AS tercero_nombre"
                ));
            $query->join('tercero', 'facturap1_tercero', '=', 'tercero.id');
            $query->join('regional', 'facturap1_regional', '=', 'regional.id');


            // Persistent data filter
            if($request->has('persistent') && $request->persistent) {
                session(['searchfacturap_tercero' => $request->has('tercero_nit') ? $request->tercero_nit : '']);
                session(['searchfacturap_tercero_nombre' => $request->has('tercero_nombre') ? $request->tercero_nombre : '']);
                session(['searchfacturap_factura' => $request->has('factura') ? $request->factura : '']);
                session(['searchfacturap_fecha' => $request->has('facturap_fecha') ? $request->facturap_fecha : '']);
            }

            return Datatables::of($query)
                ->filter(function ($query) use ($request){
                    // Referencia 
                    if($request->has('factura')){
                        $query->whereRaw("facturap1_factura LIKE '%{$request->factura}%'");
                    }

                    // Fecha 
                    if($request->has('facturap_fecha')){
                        $query->whereRaw("facturap1_fecha LIKE '%{$request->facturap_fecha}%'");
                    }

                    // Documento Tercero
                    if($request->has('tercero_nit')) {
                        $query->whereRaw("tercero_nit LIKE '%{$request->tercero_nit}%'");
                    }
                })
                ->make(true);
        }
        return view('tesoreria.facturap.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tesoreria.facturap.create');
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
            $facturap1 = new Facturap1;
            if ($facturap1->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recupero instanci de tercero
                    $tercero = Tercero::where('tercero_nit', $request->facturap1_tercero)->first();
                    if (!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cliente, por favor verifique la información o consulte al administrador']);
                    }

                    // Recupero regional
                    $regional = Regional::find($request->facturap1_regional);
                    if (!$regional instanceof Regional) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar regional, por favor verifique la información o consulte al administrador']);
                    }
                    // Recupero documentos
                    $documentos = Documentos::where('documentos_codigo', Facturap1::$default_document)->first();
                    if (!$documentos instanceof Documentos) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar documentos, por favor verifique la información o consulte al administrador']);
                    }
                    // Recupero Tipo de Proveedor
                    $tipoproveedor = TipoProveedor::find($request->facturap1_tipoproveedor);
                    if (!$tipoproveedor instanceof TipoProveedor) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el tipo de proveedor, por favor verifique la información o consulte al administrador']);
                    }
                    // Recupero Tipo gasto
                    $tipogasto = TipoGasto::find($request->facturap1_tipogasto);
                    if (!$tipogasto instanceof TipoGasto) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el tipo de gasto, por favor verifique la información o consulte al administrador']);
                    }
                    // Consecutive
                    $consecutive = $regional->regional_fpro + 1;

                    $facturap1->fill($data);
                    $facturap1->facturap1_documentos = $documentos->id;
                    $facturap1->facturap1_tercero = $tercero->id;
                    $facturap1->facturap1_regional = $regional->id;
                    $facturap1->facturap1_numero = $consecutive;
                    $facturap1->facturap1_tipoproveedor = $tipoproveedor->id;
                    $facturap1->facturap1_tipogasto = $tipogasto->id;
                    $facturap1->facturap1_base = ($request->facturap1_subtotal - $request->facturap1_descuento);

                    $facturap1->save();

                    // Facturap2
                    $facturap2 = isset($data['facturap2']) ? $data['facturap2'] : null;
                    foreach ($facturap2 as $item) {
                        $facturapDetalle = new Facturap2;
                        if (!empty($item['facturap2_impuesto'])) {
                            $impuesto = Impuesto::find($item['facturap2_impuesto']);
                            if (!$impuesto instanceof Impuesto) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => 'No es posible recuperar impuesto, por favor verifique la información o consulte al administrador']);
                            }
                            $facturapDetalle->facturap2_base = $facturapDetalle->calculateBase($facturap1, $impuesto->impuesto_porcentaje);
                            $facturapDetalle->facturap2_impuesto = $impuesto->id;
                            $facturapDetalle->facturap2_porcentaje = $impuesto->impuesto_porcentaje;
                        }
                        if (!empty($item['facturap2_retefuente']) ) {
                            // Recupero tercero para saber tipo de persona
                            $tercero = Tercero::find($facturap1->facturap1_tercero);
                            if (!$tercero instanceof Tercero) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => 'No es posible recuperar tercero, por favor verifique la información o consulte al administrador']);

                            }
                            $retefuente = ReteFuente::find($item['facturap2_retefuente']);
                            if (!$retefuente instanceof ReteFuente) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => 'No es posible recuperar retefuente, por favor verifique la información o consulte al administrador']);
                            }
                            $porcentage = ($tercero->tercero_persona == 'N') ? $retefuente->retefuente_tarifa_natural : $retefuente->retefuente_tarifa_juridico;
                            $facturapDetalle->facturap2_base = $facturapDetalle->calculateBase($facturap1, $porcentage);
                            $facturapDetalle->facturap2_retefuente = $retefuente->id;
                            $facturapDetalle->facturap2_porcentaje = $porcentage;
                        }
                        $facturapDetalle->facturap2_facturap1 = $facturap1->id;
                        $facturapDetalle->save();
                    }
                    // Calculate totalize 
                    $facturap1->calculateTotal();

                    // Facturap3
                    $facturap3 = Facturap3::storeFacturap3($facturap1);
                    if (!$facturap3) {
                        DB::rollback();
                        return response()->json(['success'=> false, 'errors'=>'No es posible realizar factura proveedor3,por favor verifique la información ó por favor consulte al administrador']);
                    }

                    // Activo fijo
                    $activosfijos = isset($data['activosfijos']) ? $data['activosfijos'] : [];
                    $activofijo = ActivoFijo::store($facturap1, $activosfijos);
                    if (!$activofijo->success) {
                        DB::rollback();
                        return response()->json(['success'=> false, 'errors'=> $activofijo->errors]);
                    }
                     
                    // Inventario
                    $entrada1 = isset($data['entrada1']) ? $data['entrada1'] : null;
                    $entrada2 = isset($data['entrada2']) ? $data['entrada2'] : null;
                    
                    if (!empty($entrada1) && !empty($entrada1)) {
                        $entrada = Entrada1::store($facturap1, $entrada1, $entrada2);
                        if (!$entrada->success) {
                            DB::rollback();
                            return response()->json(['success'=> false, 'errors'=> $entrada->errors]);
                        }
                    }
                    // Update consecutive regional_fpro
                    $regional->regional_fpro = $consecutive;
                    $regional->save();

                    // Commit
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $facturap1->id ]);
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $facturap1->errors ]);
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
        $facturap1 = Facturap1::getFacturap($id);
        if ($request->ajax()) {
            return response()->json($facturap1);
        }
        return view('tesoreria.facturap.show', ['facturap1' => $facturap1]);
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
     * Validate tercero name factura.
     *
     * @return \Illuminate\Http\Response
     */
    public function validation(Request $request)
    {
        // Recupero instancia de tercero
        $tercero = Tercero::where('tercero_nit', $request->tercero)->first();
        if (!$tercero instanceof Tercero) {
            DB::rollback();
            return response()->json(['success' => false, 'errors' => 'No es posible recuperar cliente, por favor verifique la información o consulte al administrador']);
        }
        // Valido nombre factura
        $nameFactura = Facturap1::where('facturap1_tercero', $tercero->id)->where('facturap1_factura', $request->factura)->first();
        if ($nameFactura instanceof Facturap1) {
            DB::rollback();
            return response()->json(['success' => false, 'errors' => "El proveedor ". $tercero->getName() ." ya tiene una factura registrada con el nombre de $request->facturap1_factura, por favor verifique la información o consulte al administrador"]);
        }

        return response()->json(['success' => true]);
    }
}
