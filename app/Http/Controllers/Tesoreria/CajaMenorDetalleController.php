<?php

namespace App\Http\Controllers\Tesoreria;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Tesoreria\CajaMenor1, App\Models\Tesoreria\CajaMenor2, App\Models\Tesoreria\ConceptoCajaMenor, App\Models\Base\Tercero, App\Models\Contabilidad\PlanCuenta, App\Models\Contabilidad\CentroCosto;
use Log, DB;
class CajaMenorDetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $cajaMenor2 = [];
            if($request->has('cajamenor')) {
                $cajaMenor2 = CajaMenor2::getCajaMenor2($request->cajamenor);
            }
            return response()->json($cajaMenor2);
        }
        abort(404);
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
            $cajaMenor2 = new CajaMenor2;
            if ($cajaMenor2->isValid($data)) {
                DB::beginTransaction();
                try {
                    // CajaMenor1
                    $cajaMenor1 = CajaMenor1::find($request->cajamenor1);
                    if (!$cajaMenor1 instanceof CajaMenor1) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar caja menor, verifique información ó por favor consulte al administrador.']);
                    }
                    // Concepto Caja
                    $conceptoCaja = ConceptoCajaMenor::find($request->cajamenor2_conceptocajamenor);
                    if(!$conceptoCaja instanceof ConceptoCajaMenor) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar concepto de caja menor, verifique información ó por favor consulte al administrador.']);
                    }
                    // Plan Cuentas
                    $cuenta = PlanCuenta::find($request->cajamenor2_cuenta);
                    if(!$cuenta instanceof PlanCuenta) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar plan cuenta, verifique información ó por favor consulte al administrador.']);
                    }
                    // Centro de Costo
                    $centroCosto = CentroCosto::find($request->cajamenor2_centrocosto);
                    if(!$centroCosto instanceof CentroCosto) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar centro de costo, verifique información ó por favor consulte al administrador.']);
                    }
                    //Recuperar Tercero
                    $tercero = Tercero::where('tercero_nit', $request->cajamenor2_tercero)->first();
                    if(!$tercero instanceof Tercero) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el cliente, verifique información ó por favor consulte al administrador.']);
                    }

                    // Calculate valor
                    $valor = $request->cajamenor2_subtotal + $request->cajamenor2_iva - ($request->cajamenor2_retefuente + $request->cajamenor2_reteica + $request->cajamenor2_reteiva);

                    $cajaMenor2->fill($data);
                    $cajaMenor2->cajamenor2_cajamenor1 = $cajaMenor1->id;
                    $cajaMenor2->cajamenor2_conceptocajamenor = $conceptoCaja->id;
                    $cajaMenor2->cajamenor2_tercero = $tercero->id;
                    $cajaMenor2->cajamenor2_cuenta = $cuenta->id;
                    $cajaMenor2->cajamenor2_centrocosto = $centroCosto->id;
                    $cajaMenor2->save();

                    DB::commit();
                    return response()->json(['success' => true, 'id' => $cajaMenor2->id, 'plancuentas_nombre' => $cuenta->plancuentas_nombre, 'plancuentas_cuenta' => $cuenta->plancuentas_cuenta, 'centrocosto_codigo' => $centroCosto->centrocosto_codigo, 'centrocosto_nombre' => $centroCosto->centrocosto_nombre, 'conceptocajamenor_nombre' => $conceptoCaja->conceptocajamenor_nombre, 'cajamenor2_valor' => $valor]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $cajaMenor2->errors]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                $cajaMenor2 = CajaMenor2::find($id);
                if(!$cajaMenor2 instanceof CajaMenor2){
                    return response()->json(['success' => false, 'errors' => 'No es recuperar item del detalle, por favor verifique la información del asiento o consulte al administrador.']);
                }

                // Eliminar item asiento2
                $cajaMenor2->delete();

                DB::commit();
                return response()->json(['success' => true]);
            }catch(\Exception $e){
                DB::rollback();
                Log::error(sprintf('%s -> %s: %s', 'CajaMenorDetalleController', 'destroy', $e->getMessage()));
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
