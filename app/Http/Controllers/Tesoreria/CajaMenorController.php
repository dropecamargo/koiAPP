<?php

namespace App\Http\Controllers\Tesoreria;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Classes\AsientoContableDocumento, App\Classes\AsientoNifContableDocumento;
use App\Models\Tesoreria\CajaMenor1, App\Models\Tesoreria\CajaMenor2, App\Models\Tesoreria\ConceptoCajaMenor, App\Models\Base\Tercero, App\Models\Base\Documentos, App\Models\Base\Regional, App\Models\Contabilidad\PlanCuenta, App\Models\Contabilidad\CentroCosto;
use App\Models\Cartera\CuentaBanco;
use DB, Log, Datatables, Auth, App, View;

class CajaMenorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = CajaMenor1::query();
            $query->select('cajamenor1.*','regional_nombre', 'cuentabanco_nombre', 'tercero_nit', DB::raw("(CASE WHEN tercero_persona = 'N'
                        THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                                (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                            )
                        ELSE tercero_razonsocial END)
                    AS tercero_nombre") );
            $query->join('cuentabanco','cajamenor1_cuentabanco','=','cuentabanco.id');
            $query->join('regional','cajamenor1_regional','=','regional.id');
            $query->join('tercero', 'cajamenor1_tercero', '=', 'tercero.id');

            // Persistent data filter
            if($request->has('persistent') && $request->persistent) {
                session(['searchcajamenor_tercero' => $request->has('nit') ? $request->nit : '']);
                session(['searchcajamenor_regional' => $request->has('regional') ? $request->regional : '']);
                session(['searchcajamenor_numero' => $request->has('numero') ? $request->numero : '']);
            }
            return Datatables::of($query)
                ->filter(function($query) use($request) {
                    // Tercero Nit
                    if ($request->has('nit')) {
                        $query->where('tercero_nit', $request->nit);
                    }
                    // Regional
                    if ($request->has('regional')) {
                        $query->where('cajamenor1_regional', $request->regional);
                    }
                    // Número de caja menor
                    if ($request->has('numero')) {
                        $query->where('cajamenor1_numero', $request->numero);
                    }
            })->make(true);
        }
        return view('tesoreria.cajasmenores.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tesoreria.cajasmenores.create');
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
            $cajaMenor1 = new CajaMenor1;
            if ($cajaMenor1->isValid($data)) {
                DB::beginTransaction();
                try {
                    // /Recuperando Documento CM
                    $documento = Documentos::where('documentos_codigo', CajaMenor1::$default_document)->first();
                    if(!$documento instanceof Documentos) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar documentos,por favor verifique la información ó por favor consulte al administrador.']);
                    }

                    // Recuperando Tercero - Empleado
                    $tercero = Tercero::where('tercero_nit', $request->cajamenor1_tercero)->first();
                    if(!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar empleado, verifique información ó por favor consulte al administrador.']);
                    }

                    // Cuenta Bancaria
                    $cuentabanco = CuentaBanco::find($request->cajamenor1_cuentabanco);
                    if(!$cuentabanco instanceof CuentaBanco) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar la cuenta, verifique información ó por favor consulte al administrador.']);
                    }

                    //  Recuperando Regional
                    $regional = Regional::find($request->cajamenor1_regional);
                    if(!$regional instanceof Regional) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar regional, verifique información ó por favor consulte al administrador.']);
                    }

                    // Consecutive
                    $consecutive = $regional->regional_cm + 1;

                    // CajaMenor1
                    $cajaMenor1->fill($data);
                    $cajaMenor1->cajamenor1_regional = $regional->id;
                    $cajaMenor1->cajamenor1_numero = $consecutive;
                    $cajaMenor1->cajamenor1_tercero = $tercero->id;
                    $cajaMenor1->cajamenor1_documentos = $documento->id;
                    $cajaMenor1->cajamenor1_cuentabanco = $cuentabanco->id;
                    $cajaMenor1->cajamenor1_usuario_elaboro = Auth::user()->id;
                    $cajaMenor1->cajamenor1_fh_elaboro = date('Y-m-d H:m:s');
                    $cajaMenor1->save();

                    foreach ($data['detalle'] as $item) {
                        // Concepto Caja
                        $conceptoCaja = ConceptoCajaMenor::find($item['cajamenor2_conceptocajamenor']);
                        if(!$conceptoCaja instanceof ConceptoCajaMenor) {
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar concepto de caja menor, verifique información ó por favor consulte al administrador.']);
                        }
                        // Plan Cuentas
                        $cuenta = PlanCuenta::find($item['cajamenor2_cuenta']);
                        if(!$cuenta instanceof PlanCuenta) {
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar plan cuenta, verifique información ó por favor consulte al administrador.']);
                        }
                        // Centro de Costo
                        $centroCosto = CentroCosto::find($item['cajamenor2_centrocosto']);
                        if(!$centroCosto instanceof CentroCosto) {
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar centro de costo, verifique información ó por favor consulte al administrador.']);
                        }
                        //Recuperar Tercero - Cliente
                        $cliente = Tercero::where('tercero_nit', $item['cajamenor2_tercero'])->first();
                        if(!$cliente instanceof Tercero) {
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar el cliente, verifique información ó por favor consulte al administrador.']);
                        }
                        // Caja Menor 2
                        $cajaMenor2 = new CajaMenor2;
                        $cajaMenor2->fill($item);
                        $cajaMenor2->cajamenor2_cajamenor1 = $cajaMenor1->id;
                        $cajaMenor2->cajamenor2_conceptocajamenor = $conceptoCaja->id;
                        $cajaMenor2->cajamenor2_tercero = $cliente->id;
                        $cajaMenor2->cajamenor2_cuenta = $cuenta->id;
                        $cajaMenor2->cajamenor2_centrocosto = $centroCosto->id;
                        $cajaMenor2->save();

                        // Preparando detalle asiento
                        $result = $cajaMenor1->detalleAsiento($cajaMenor2, $cliente, $cuenta, $centroCosto);
                        if(!is_array($result)){
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $result]);
                        }
                        $detalle[] = $result;
                    }
                    // Encabezado Asiento
                    $encabezado = $cajaMenor1->encabezadoAsiento($tercero, $cuentabanco);
                    if(!is_object($encabezado)){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $encabezado]);
                    }

                    $detalle[] = $encabezado->cuenta;

                    // Creo el objeto para manejar el asiento
                    $objAsiento = new AsientoContableDocumento($encabezado->data);
                    if($objAsiento->asiento_error) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $objAsiento->asiento_error]);
                    }
                    // Preparar asiento
                    $result = $objAsiento->asientoCuentas($detalle);
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
                        $result = $objAsientoNif->asientoCuentas($detalle);
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
                        // Recuperar el Id del asiento y guardar en la factura
                        $cajaMenor1->cajamenor1_asienton = $objAsientoNif->asientoNif->id;
                    }

                    $cajaMenor1->cajamenor1_asiento = $objAsiento->asiento->id;
                    $cajaMenor1->save();

                    // Update consecutive regional_cm in Regional
                    $regional->regional_cm = $consecutive;
                    $regional->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $cajaMenor1->id]);
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $cajaMenor1->errors]);
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

        $cajaMenor1 = CajaMenor1::getCajaMenor($id);
        if ($request->ajax()) {
            return response()->json($cajaMenor1);
        }
        return view('tesoreria.cajasmenores.show', ['cajaMenor1' => $cajaMenor1]);
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
