<?php

namespace App\Http\Controllers\Contabilidad;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Contabilidad\Asiento, App\Models\Contabilidad\Asiento2, App\Models\Contabilidad\AsientoNif, App\Models\Contabilidad\AsientoNif2, App\Models\Tesoreria\Facturap1, App\Models\Tesoreria\Facturap2, App\Models\Contabilidad\AsientoMovimiento, App\Models\Contabilidad\PlanCuenta, App\Models\Contabilidad\PlanCuentaNif ,App\Models\Contabilidad\CentroCosto, App\Models\Base\Tercero, App\Models\Production\Ordenp;

use Log, DB;

class DetalleAsientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $detalle = [];
            if($request->has('asiento')) {
                $detalle = Asiento2::getAsiento2($request->asiento);
            }
            return response()->json($detalle);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

            $asiento2 = new Asiento2;
            if ($asiento2->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar asiento
                    $asiento = Asiento::find($request->asiento1_id);
                    if(!$asiento instanceof Asiento) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar asiento, por favor verifique la información del asiento o consulte al administrador.']);
                    }

                    // Recuperar cuenta
                    $objCuenta = PlanCuenta::where('plancuentas_cuenta', $request->plancuentas_cuenta)->first();
                    if(!$objCuenta instanceof PlanCuenta) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador.']);
                    }

                    // Recuperar centro costo
                    $centrocosto = $ordenp = null;
                    if($request->has('asiento2_centro')) {
                        $centrocosto = CentroCosto::find($request->asiento2_centro);
                        if(!$centrocosto instanceof CentroCosto) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar centro costo, por favor verifique la información del asiento o consulte al administrador.']);
                        }
                    }

                    // Recuperar tercero
                    $tercero = Tercero::where('tercero_nit', $request->tercero_nit)->first();
                    if(!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar beneficiario, por favor verifique la información del asiento o consulte al administrador.']);
                    }

                    // Validate asiento2
                    $result = Asiento2::validarAsiento2($request, $objCuenta);
                    if($result != 'OK') {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result]);
                    }

                    $cuenta = [];
                    $cuenta['Cuenta'] = $objCuenta->plancuentas_cuenta;
                    $cuenta['Tercero'] = $request->tercero_nit;
                    $cuenta['Detalle'] = $request->asiento2_detalle;
                    $cuenta['Naturaleza'] = $request->asiento2_naturaleza;
                    $cuenta['CentroCosto'] = $request->asiento2_centro;
                    $cuenta['Base'] = $request->asiento2_base;
                    $cuenta['Credito'] = $request->asiento2_naturaleza == 'C' ? $request->asiento2_valor: 0;
                    $cuenta['Debito'] = $request->asiento2_naturaleza == 'D' ? $request->asiento2_valor: 0;
                    $cuenta['Orden'] = ($ordenp instanceof Ordenp ? $ordenp->id : '');

                    $result = $asiento2->store($asiento, $cuenta);
                    if(!$result->success) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result->error]);
                    }

                    // Insertar movimiento asiento
                    $result = $asiento2->movimiento($request);
                    if(!$result->success) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result->error]);
                    }
                    // Asiento Nif
                    $asientoNif = AsientoNif::where('asienton1_asiento', $asiento->id)->first();
                    $asientoNif2 = null;
                    if ($asientoNif instanceof AsientoNif) {

                        $cuentaNif = PlanCuentaNif::find($objCuenta->plancuentas_equivalente);
                        if ( !$cuentaNif instanceof PlanCuentaNif ) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar cuenta NIF, por favor verifique la información del asiento o consulte al administrador.']);
                        }
                        $cuenta = [];
                        $cuenta['Cuenta'] = $cuentaNif->plancuentasn_cuenta;
                        $cuenta['Tercero'] = $request->tercero_nit;
                        $cuenta['Detalle'] = $request->asiento2_detalle;
                        $cuenta['Naturaleza'] = $request->asiento2_naturaleza;
                        $cuenta['CentroCosto'] = $request->asiento2_centro;
                        $cuenta['Base'] = $request->asiento2_base;
                        $cuenta['Credito'] = $request->asiento2_naturaleza == 'C' ? $request->asiento2_valor: 0;
                        $cuenta['Debito'] = $request->asiento2_naturaleza == 'D' ? $request->asiento2_valor: 0;
                        $cuenta['Orden'] = ($ordenp instanceof Ordenp ? $ordenp->id : '');

                        $asientoNif2 = new AsientoNif2;
                        $result = $asientoNif2->store($asientoNif, $cuenta);
                        if(!$result->success) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $result->error]);
                        }
                    }
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $asiento2->id,
                        'asiento2_cuenta' => $objCuenta->id,
                        'plancuentas_cuenta' => $objCuenta->plancuentas_cuenta,
                        'plancuentas_nombre' => $objCuenta->plancuentas_nombre,
                        'centrocosto_codigo' => ($centrocosto instanceof CentroCosto ? $centrocosto->getCode() : ''),
                        'centrocosto_nombre' => ($centrocosto instanceof CentroCosto ? $centrocosto->centrocosto_nombre : ''),
                        'asiento2_beneficiario' => ($tercero instanceof Tercero ? $tercero->id : ''),
                        'tercero_nit' => ($tercero instanceof Tercero ? $tercero->tercero_nit : ''),
                        'tercero_nombre' => ($tercero instanceof Tercero ? $tercero->getName() : ''),
                        'asiento2_credito' => $asiento2->asiento2_credito,
                        'asiento2_debito' => $asiento2->asiento2_debito,
                        'asiento2_ordenp' => ($ordenp instanceof Ordenp ? $ordenp->id : ''),
                        'ordenp_codigo' => ($ordenp instanceof Ordenp ? "{$ordenp->orden_numero}-".substr($ordenp->orden_ano,-2) : ''),
                        'ordenp_beneficiario' => $request->asiento2_orden_beneficiario
                    ]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error(sprintf('%s -> %s: %s', 'DetalleAsientoController', 'store', $e->getMessage()));
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $asiento2->errors]);
        }
        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            DB::beginTransaction();
            try {

                $asiento2 = Asiento2::find($id);
                if(!$asiento2 instanceof Asiento2){
                    return response()->json(['success' => false, 'errors' => 'No es posible definir beneficiario, por favor verifique la información del asiento o consulte al administrador.']);
                }
                // Si existe asiento NIF
                $asientoNif = AsientoNif::query()->where('asienton1_asiento',$asiento2->asiento2_asiento)->first();
                if ($asientoNif instanceof AsientoNif) {
                    $asientoNif2 = AsientoNif2::query()->where('asienton2_asiento',$asientoNif->id)->where('asienton2_item', $asiento2->asiento2_item)->first();
                    $asientoNif2->delete();
                }

                // Eliminar movimiento
                AsientoMovimiento::where('movimiento_asiento2', $asiento2->id)->delete();

                // Eliminar item asiento2
                $asiento2->delete();

                DB::commit();
                return response()->json(['success' => true]);

            }catch(\Exception $e){
                DB::rollback();
                Log::error(sprintf('%s -> %s: %s', 'DetalleAsientoController', 'destroy', $e->getMessage()));
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }

    /**
     * Evaluate actions detail asiento.
     *
     * @return \Illuminate\Http\Response
     */
    public function evaluate(Request $request)
    {
        // Prepare response
        $response = new \stdClass();
        $response->actions = [];
        $response->success = false;

        // Recuperar plancuentas
        $cuenta = null;
        if($request->has('plancuentas_cuenta')) {
            $cuenta = PlanCuenta::where('plancuentas_cuenta', $request->plancuentas_cuenta)->first();
        }

        if(!$cuenta instanceof PlanCuenta) {
            $response->errors = "No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador.";
            return response()->json($response);
        }

        // Validate asiento2
        $result = Asiento2::validarAsiento2($request, $cuenta);
        if($result != 'OK') {
            $response->errors = $result;
            return response()->json($response);
        }

        $response->success = true;
        return response()->json($response);
    }

    /**
     * Validate actions detail asiento.
     *
     * @return \Illuminate\Http\Response
     */
    public function validation(Request $request)
    {
        // Prepare response
        $response = new \stdClass();
        $response->success = false;
        $response->asiento2_valor = $request->asiento2_valor;

        // Recuperar cuenta
        $cuenta = null;
        if($request->has('plancuentas_cuenta')) {
            $cuenta = PlanCuenta::where('plancuentas_cuenta', $request->plancuentas_cuenta)->first();
        }

        if(!$cuenta instanceof PlanCuenta) {
            $response->errors = 'No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador.';
            return response()->json($response);
        }

        if($request->has('action'))
        {
            switch ($request->action) {
                case 'ordenp':
                    // Valido movimiento ordenp
                    $result = Asiento2::validarOrdenp($request);
                    if($result != 'OK') {
                        $response->errors = $result;
                        return response()->json($response);
                    }
                    $response->success = true;
                    return response()->json($response);
                break;

                case 'facturap':
                    // Valido movimiento facturap
                    $result = Asiento2::validarFacturap($request);
                    if($result != 'OK') {
                        $response->errors = $result;
                        return response()->json($response);
                    }
                    $response->success = true;
                    return response()->json($response);
                break;

                case 'cartera':
                    // Valido movimiento cartera
                    $result = Asiento2::validarFactura($request);
                    if($result != 'OK') {
                        $response->errors = $result;
                        return response()->json($response);
                    }

                    $response->success = true;
                    return response()->json($response);
                break;

                case 'inventario':
                    // Valido movimiento inventario
                    $result = Asiento2::validarInventario($request);
                    if($result->success != true) {
                        $response->errors = $result->errors;
                        return response()->json($response);
                    }

                    // Inventario modifica valor item asiento por el valor del costo del movimiento
                    if(isset($result->asiento2_valor) && $result->asiento2_valor != $request->asiento2_valor){
                        $response->asiento2_valor = $result->asiento2_valor;
                    }

                    $response->success = true;
                    return response()->json($response);
                break;
            }
        }

        $response->errors = 'No es posible definir acción a validar, por favor verifique la información del asiento o consulte al administrador.';
        return response()->json($response);
    }

    /**
     * Display a listing movimientos of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function movimientos(Request $request)
    {
        if ($request->ajax()) {
            $movimientos = [];
            if($request->has('asiento2')) {
                $query = AsientoMovimiento::query();
                $query->select('asientomovimiento.*', 'producto_codigo', 'producto_nombre', 'producto.id as producto_id', 'factura1.*', 'factura1.id as factura1_id', 'sucursal_nombre', 'puntoventa_nombre', 'puntoventa_prefijo', 'factura4_cuota', 'factura4_factura1', 'facturap2_cuota', 'tercero_nit', DB::raw("(CASE WHEN tercero_persona = 'N'
                        THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                                (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                            )
                        ELSE tercero_razonsocial END)
                    AS tercero_nombre"), DB::raw("
                        CASE
                            WHEN productop_3d != 0 THEN
                                    CONCAT(
                                    COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,') 3D(',
                                    COALESCE(orden2_3d_ancho,0), COALESCE(me6.unidadmedida_sigla,''),' x ',
                                    COALESCE(orden2_3d_alto,0), COALESCE(me7.unidadmedida_sigla,''),' x ',
                                    COALESCE(orden2_3d_profundidad,0), COALESCE(me5.unidadmedida_sigla,''),')' )
                            WHEN productop_abierto != 0 AND productop_cerrado != 0 THEN
                                    CONCAT(
                                    COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,') A(',
                                    COALESCE(orden2_ancho,0), COALESCE(me1.unidadmedida_sigla,''),' x ',
                                    COALESCE(orden2_alto,0), COALESCE(me2.unidadmedida_sigla,''), ') C(',
                                    COALESCE(orden2_c_ancho,0), COALESCE(me3.unidadmedida_sigla,''),' x ',
                                    COALESCE(orden2_c_alto,0), COALESCE(me4.unidadmedida_sigla,''),')')
                            WHEN productop_abierto != 0 AND productop_cerrado = 0 THEN
                                    CONCAT(
                                    COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,') A(',
                                    COALESCE(orden2_ancho,0), COALESCE(me1.unidadmedida_sigla,''),' x ',
                                    COALESCE(orden2_alto,0), COALESCE(me2.unidadmedida_sigla,''), ')')
                            WHEN productop_abierto = 0 AND productop_cerrado != 0 THEN
                                    CONCAT(
                                    COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,') C(',
                                    COALESCE(orden2_c_ancho,0), COALESCE(me3.unidadmedida_sigla,''),' x ',
                                    COALESCE(orden2_c_alto,0), COALESCE(me4.unidadmedida_sigla,''),')')
                            ELSE
                                    CONCAT(
                                        COALESCE(productop_nombre,'') ,' (', COALESCE(orden2_referencia,'') ,')' )
                            END AS productop_nombre
                        ")
                    );
                $query->where('movimiento_asiento2', $request->asiento2);
                $query->leftJoin('producto', 'movimiento_producto', '=', 'producto.id');
                $query->leftJoin('sucursal', 'movimiento_sucursal', '=', 'sucursal.id');

                // Factura
                $query->leftJoin('factura1', 'movimiento_factura', '=', 'factura1.id');
                $query->leftJoin('factura4', 'movimiento_factura4', '=', 'factura4.id');
                $query->leftJoin('tercero', 'factura1_tercero', '=', 'tercero.id');
                $query->leftJoin('ordenproduccion2', 'movimiento_ordenp2', '=', 'ordenproduccion2.id');
                $query->leftJoin('puntoventa', 'factura1_puntoventa', '=', 'puntoventa.id');

                // Facturap
                $query->leftJoin('facturap2', 'movimiento_item', '=', 'facturap2.id');

                // Joins producto
                $query->leftJoin('productop', 'orden2_productop', '=', 'productop.id');
                $query->leftJoin('unidadmedida as me1', 'productop_ancho_med', '=', 'me1.id');
                $query->leftJoin('unidadmedida as me2', 'productop_alto_med', '=', 'me2.id');
                $query->leftJoin('unidadmedida as me3', 'productop_c_med_ancho', '=', 'me3.id');
                $query->leftJoin('unidadmedida as me4', 'productop_c_med_alto', '=', 'me4.id');
                $query->leftJoin('unidadmedida as me5', 'productop_3d_profundidad_med', '=', 'me5.id');
                $query->leftJoin('unidadmedida as me6', 'productop_3d_ancho_med', '=', 'me6.id');
                $query->leftJoin('unidadmedida as me7', 'productop_3d_alto_med', '=', 'me7.id');

                $movimientos = $query->get();
            }
            return response()->json($movimientos);
        }
    }
}
