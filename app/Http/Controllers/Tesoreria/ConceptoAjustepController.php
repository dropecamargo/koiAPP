<?php

namespace App\Http\Controllers\Tesoreria;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Tesoreria\ConceptoAjustep;
use App\Models\Contabilidad\PlanCuenta;
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
            $query->select('conceptoajustep.*','plancuentas_nombre');
            $query->join('plancuentas','conceptoajustep_plancuentas', '=','plancuentas.id');
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
                    // Recuperar cuenta
                    $plancuentas = PlanCuenta::where('plancuentas_cuenta', $request->conceptoajustep_plancuentas)->first();
                    if(!$plancuentas instanceof PlanCuenta){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar plan de cuenta, verifique información ó por favor consulte al administrador.']);
                    }

                    // Valid correctly use the cuenta
                    $result = $plancuentas->validarSubnivelesCuenta();
                    if ($result != 'OK') {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result ]);
                    }

                    // ConceptoAjustep
                    $conceptoajustep->fill($data);
                    $conceptoajustep->fillBoolean($data);
                    $conceptoajustep->conceptoajustep_plancuentas = $plancuentas->id;
                    $conceptoajustep->save();

                    //Forget cache
                    Cache::forget( ConceptoAjustep::$key_cache );
                    // Commit Transaction
                    DB::commit();
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
        $conceptoajustep = ConceptoAjustep::getConcepto($id);
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
                    // Recuperar cuenta
                    $plancuentas = PlanCuenta::where('plancuentas_cuenta', $request->conceptoajustep_plancuentas)->first();
                    if(!$plancuentas instanceof PlanCuenta){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar plan de cuenta, verifique información ó por favor consulte al administrador.']);
                    }
                    
                    // Valid correctly use the cuenta
                    $result = $plancuentas->validarSubnivelesCuenta();
                    if ($result != 'OK') {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result ]);
                    }

                    // ConceptoAjustep
                    $conceptoajustep->fill($data);
                    $conceptoajustep->fillBoolean($data);
                    $conceptoajustep->conceptoajustep_plancuentas = $plancuentas->id;
                    $conceptoajustep->save();

                    //Forget cache
                    Cache::forget( ConceptoAjustep::$key_cache );

                    // Commit Transaction
                    DB::commit();
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
