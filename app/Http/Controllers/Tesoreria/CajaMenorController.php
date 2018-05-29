<?php

namespace App\Http\Controllers\Tesoreria;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Tesoreria\CajaMenor1, App\Models\Tesoreria\CajaMenor2, App\Models\Tesoreria\ConceptoCajaMenor, App\Models\Base\Tercero, App\Models\Base\Documentos, App\Models\Base\Regional, App\Models\Contabilidad\PlanCuenta, App\Models\Contabilidad\CentroCosto;
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
            return Datatables::of($query)->make(true);
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
                    $cajaMenor1->cajamenor1_usuario_elaboro = Auth::user()->id;
                    $cajaMenor1->cajamenor1_fh_elaboro = date('Y-m-d H:m:s');
                    // Falta valores Double
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
                        $cajaMenor2->cajamenor2_cajamenor1 = $cajaMenor1->id;
                        $cajaMenor2->cajamenor2_conceptocajamenor = $conceptoCaja->id;
                        $cajaMenor2->cajamenor2_tercero = $cliente->id;
                        $cajaMenor2->cajamenor2_cuenta = $cuenta->id;
                        $cajaMenor2->cajamenor2_centrocosto = $centroCosto->id;
                        // Falta valores Double
                        $cajaMenor2->save();
                    }
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
