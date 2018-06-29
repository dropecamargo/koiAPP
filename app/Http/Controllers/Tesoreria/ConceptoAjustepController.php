<?php

namespace App\Http\Controllers\Tesoreria;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Tesoreria\ConceptoAjustep, App\Models\Contabilidad\PlanCuenta;
use DB, Log, Cache, Datatables;

class ConceptoAjustepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = ConceptoAjustep::query();
            return Datatables::of($query)->make(true);
        }
        return view('tesoreria.conceptosajustep.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tesoreria.conceptosajustep.create');
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
            $conceptoajustep = new ConceptoAjustep;
            if ($conceptoajustep->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar Plan Cuentas
                    $cuenta = PlanCuenta::find($request->conceptoajustep_cuenta);
                    if (!$cuenta instanceof PlanCuenta) {
                        DB::rollback();
                        return response()->json(['success' => false , 'errors' => 'No es posible recuperar plan de cuenta, verifique información ó por favor consulte al administrador.']);
                    }

                    // Validando Sub Niveles
                    $result = $cuenta->validarSubnivelesCuenta();
                    if ($result != 'OK') {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result ]);
                    }

                    // ConceptoAjustep
                    $conceptoajustep->fill($data);
                    $conceptoajustep->fillBoolean($data);
                    $conceptoajustep->conceptoajustep_cuenta = $cuenta->id;
                    $conceptoajustep->save();

                    // Commit Transaction
                    DB::commit();

                    //Forget cache
                    Cache::forget( ConceptoAjustep::$key_cache );

                    return response()->json(['success' => true, 'id' => $conceptoajustep->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $conceptoajustep->errors]);
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
        $conceptoajustep = ConceptoAjustep::getConcepto($id);
        if ($request->ajax()) {
            return response()->json($conceptoajustep);
        }
        return view('tesoreria.conceptosajustep.show', ['conceptoajustep' => $conceptoajustep]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $conceptoajustep = ConceptoAjustep::findOrFail($id);
        return view('tesoreria.conceptosajustep.edit', ['conceptoajustep' => $conceptoajustep]);
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
            $conceptoajustep = ConceptoAjustep::findOrFail($id);
            if ($conceptoajustep->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar Plan Cuentas
                    $cuenta = PlanCuenta::find($request->conceptoajustep_cuenta);
                    if (!$cuenta instanceof PlanCuenta) {
                        DB::rollback();
                        return response()->json(['success' => false , 'errors' => 'No es posible recuperar plan de cuenta, verifique información ó por favor consulte al administrador.']);
                    }

                    // Validando Sub Niveles
                    $result = $cuenta->validarSubnivelesCuenta();
                    if ($result != 'OK') {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result ]);
                    }

                    // ConceptoAjustep
                    $conceptoajustep->fill($data);
                    $conceptoajustep->fillBoolean($data);
                    $conceptoajustep->conceptoajustep_cuenta = $cuenta->id;
                    $conceptoajustep->save();

                    // Commit Transaction
                    DB::commit();

                    //Forget cache
                    Cache::forget( ConceptoAjustep::$key_cache );

                    return response()->json(['success' => true, 'id' => $conceptoajustep->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $conceptoajustep->errors]);
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
