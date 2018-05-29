<?php

namespace App\Http\Controllers\Tesoreria;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Tesoreria\ConceptoCajaMenor;
use App\Models\Contabilidad\PlanCuenta;
use DB, Log, Cache, Datatables;

class ConceptoCajaMenorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = ConceptoCajaMenor::query();
            return Datatables::of($query)->make(true);
        }
        return view('tesoreria.conceptoscajamenor.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tesoreria.conceptoscajamenor.create');
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
            $conceptocaja = new ConceptoCajaMenor;
            if ($conceptocaja->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Cuenta administrativa
                    $administrativa = PlanCuenta::find($request->conceptocajamenor_administrativo);
                    if (!$administrativa instanceof PlanCuenta) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cuenta de Administración , por favor verifique información o consulte con el administrador']);
                    }
                    // Cuenta de ventas
                    $ventas = PlanCuenta::find($request->conceptocajamenor_ventas);
                    if (!$ventas instanceof PlanCuenta) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cuenta de ventas , por favor verifique información o consulte con el administrador']);
                    }

                    //  Validar novimientos de cuentas
                    $result = $administrativa->validarSubnivelesCuenta();
                    if($result != 'OK') {
                        return response()->json(['success' => false, 'errors' => $result]);
                    }

                    $result = $ventas->validarSubnivelesCuenta();
                    if($result != 'OK') {
                        return response()->json(['success' => false, 'errors' => $result]);
                    }

                    // ConceptoCajaMenor
                    $conceptocaja->fill($data);
                    $conceptocaja->fillBoolean($data);
                    $conceptocaja->conceptocajamenor_administrativo = $administrativa->id;
                    $conceptocaja->conceptocajamenor_ventas = $ventas->id;
                    $conceptocaja->save();

                    // Commit Transaction
                    DB::commit();

                    //Forget cache
                    Cache::forget( ConceptoCajaMenor::$key_cache );
                    return response()->json(['success' => true, 'id' => $conceptocaja->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $conceptocaja->errors]);
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
        $conceptocaja = ConceptoCajaMenor::getConceptoCajaMenor($id);
        if ($request->ajax()) {
            return response()->json($conceptocaja);
        }
        return view('tesoreria.conceptoscajamenor.show', ['conceptocajamenor' => $conceptocaja]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $conceptocaja = ConceptoCajaMenor::findOrFail($id);
        return view('tesoreria.conceptoscajamenor.edit', ['conceptocajamenor' => $conceptocaja]);
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
            $conceptocaja = ConceptoCajaMenor::findOrFail($id);
            if ($conceptocaja->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Cuenta administrativa
                    $administrativa = PlanCuenta::find($request->conceptocajamenor_administrativo);
                    if (!$administrativa instanceof PlanCuenta) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cuenta de Administración , por favor verifique información o consulte con el administrador']);
                    }
                    // Cuenta de ventas
                    $ventas = PlanCuenta::find($request->conceptocajamenor_ventas);
                    if (!$ventas instanceof PlanCuenta) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cuenta de ventas , por favor verifique información o consulte con el administrador']);
                    }

                    //  Validar novimientos de cuentas
                    $result = $administrativa->validarSubnivelesCuenta();
                    if($result != 'OK') {
                        return response()->json(['success' => false, 'errors' => $result]);
                    }

                    $result = $ventas->validarSubnivelesCuenta();
                    if($result != 'OK') {
                        return response()->json(['success' => false, 'errors' => $result]);
                    }

                    // ConceptoCajaMenor
                    $conceptocaja->fill($data);
                    $conceptocaja->fillBoolean($data);
                    $conceptocaja->conceptocajamenor_administrativo = $administrativa->id;
                    $conceptocaja->conceptocajamenor_ventas = $ventas->id;
                    $conceptocaja->save();

                    // Commit Transaction
                    DB::commit();

                    //Forget cache
                    Cache::forget( ConceptoCajaMenor::$key_cache );
                    return response()->json(['success' => true, 'id' => $conceptocaja->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $conceptocaja->errors]);
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
}
