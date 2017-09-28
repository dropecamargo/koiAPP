<?php

namespace App\Http\Controllers\Contabilidad;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB, Log, Datatables, Auth, View, App;

use App\Classes\AsientoNifContableDocumento;

use App\Models\Contabilidad\AsientoNif, App\Models\Contabilidad\AsientoNif2, App\Models\Contabilidad\PlanCuentaNif, App\Models\Base\Tercero, App\Models\Contabilidad\Documento, App\Models\Contabilidad\CentroCosto;

class AsientoNifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = AsientoNif::query();
            $query->select('asienton1.id as id', 'asienton1_numero', 'asienton1_mes', 'asienton1_ano', 'tercero_nit', 'tercero_razonsocial', 'tercero_nombre1', 'tercero_nombre2', 'tercero_apellido1', 'tercero_apellido2', DB::raw("(CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2) ELSE tercero_razonsocial END) as tercero_nombre"), 'asienton1_preguardado');
            $query->join('tercero', 'asienton1.asienton1_beneficiario', '=', 'tercero.id');
            return Datatables::of($query->get())->make(true);
        }
        return view('contabilidad.asientonif.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('contabilidad.asientonif.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        # Code
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $asientoNif = AsientoNif::getAsientoNif($id);
        if(!$asientoNif instanceof AsientoNif){
            abort(404);
        }

        if ($request->ajax()) {
            return response()->json($asientoNif);
        }

        return view('contabilidad.asientonif.show', ['asientoNif' => $asientoNif]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $asientoNif = AsientoNif::findOrFail($id);
        if($asientoNif->asienton1_preguardado == false) {
            return redirect()->route('asientosnif.show', ['asientoNif' => $asientoNif]);
        }

        return view('contabilidad.asientonif.create', ['asientoNif' => $asientoNif]);
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
        if ($request->ajax()) {
            $data = $request->all();

            $asientoNif = AsientoNif::findOrFail($id);
            if ($asientoNif->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Preparar cuentas
                    // Recupero items asiento 2

                    $query = AsientoNif2::query();
                    $query->select('asienton2.*', 'plancuentasn_cuenta', 'plancuentasn_tipo', 'tercero_nit',
                        DB::raw("(CASE WHEN asienton2_credito != 0 THEN 'C' ELSE 'D' END) as asienton2_naturaleza")
                    );
                    $query->join('tercero', 'asienton2_beneficiario', '=', 'tercero.id');
                    $query->join('plancuentasn', 'asienton2_cuenta', '=', 'plancuentasn.id');
                    $query->where('asienton2_asiento', $asientoNif->id);
                    $asientoNif2 = $query->get();

                    $cuentas = [];
                    foreach ($asientoNif2 as $item) {
                        $arCuenta = [];
                        $arCuenta['Id'] = $item->id;
                        $arCuenta['Cuenta'] = $item->plancuentasn_cuenta;
                        $arCuenta['Tercero'] = $item->tercero_nit;
                        $arCuenta['Naturaleza'] = $item->asienton2_naturaleza;
                        $arCuenta['CentroCosto'] = $item->asienton2_centro;
                        $arCuenta['Base'] = $item->asienton2_base;
                        $arCuenta['Credito'] = $item->asienton2_credito;
                        $arCuenta['Debito'] = $item->asienton2_debito;
                        $cuentas[] = $arCuenta;
                    }

                    // Validar Carrito
                    if(!isset($cuentas) || $cuentas == null || !is_array($cuentas) || count($cuentas) == 0) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'Por favor ingrese detalle para el asiento contable.']);
                    }
                    // Creo el objeto para manejar el asiento
                    $objAsiento = new AsientoNifContableDocumento($data, $asientoNif);
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
                    $result = $objAsiento->insertarAsientoNif();
                    if($result != 'OK') {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result]);
                    }

                    // Insertar movimientos asiento
                    foreach ($asientoNif2 as $item) {
                        $result = $item->movimientos();
                        if($result != 'OK') {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $result]);
                        }
                    }

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $asientoNif->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $asientoNif->errors]);
        }
        abort(403);
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
        // $asientoNif = AsientoNif::getAsientoNif($id);
        // if(!$asientoNif instanceof Asiento){
        //     abort(404);
        // }
        // $detalle = AsientoNif2::getAsientoNif2($asientoNif->id);
        // $title = 'Asiento contable';

        // // Export pdf
        // $pdf = App::make('dompdf.wrapper');
        // $pdf->loadHTML(View::make('contabilidad.asientonif.export',  compact('asiento', 'detalle' ,'title'))->render());
        // return $pdf->download(sprintf('%s_%s_%s_%s.pdf', 'asiento', $asientoNif->id, date('Y_m_d'), date('H_m_s')));
    }
}
