<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Cartera\ConceptoAjustec;
use App\Models\Contabilidad\PlanCuenta;
use DB, Log, Cache, Datatables;

class ConceptoAjustecController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = ConceptoAjustec::query();
            $query->select('conceptoajustec.*','plancuentas_nombre');
            $query->join('plancuentas','conceptoajustec_plancuentas', '=','plancuentas.id');
            return Datatables::of($query)->make(true);
        }
        return view('cartera.conceptosajustec.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cartera.conceptosajustec.create');
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
            $conceptoajustec = new ConceptoAjustec;
            if ($conceptoajustec->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar cuenta
                    $plancuentas = PlanCuenta::where('plancuentas_cuenta', $request->conceptoajustec_plancuentas)->first();
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

                    // ConceptoAjustec
                    $conceptoajustec->fill($data);
                    $conceptoajustec->fillBoolean($data);
                    $conceptoajustec->conceptoajustec_plancuentas = $plancuentas->id;
                    $conceptoajustec->save();

                    //Forget cache
                    Cache::forget( ConceptoAjustec::$key_cache );
                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $conceptoajustec->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $conceptoajustec->errors]);
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
        $conceptoajustec = ConceptoAjustec::getConcepto($id);
        if ($request->ajax()) {
            return response()->json($conceptoajustec);
        }
        return view('cartera.conceptosajustec.show', ['conceptoajustec' => $conceptoajustec]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $conceptoajustec = ConceptoAjustec::getConcepto($id);
        return view('cartera.conceptosajustec.edit', ['conceptoajustec' => $conceptoajustec]);
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
            $conceptoajustec = ConceptoAjustec::findOrFail($id);
            if ($conceptoajustec->isValid($data)) {
                DB::beginTransaction();
                try {

                    // Recuperar cuenta
                    $plancuentas = PlanCuenta::where('plancuentas_cuenta', $request->conceptoajustec_plancuentas)->first();
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
                    // ConceptoAjustec
                    $conceptoajustec->fill($data);
                    $conceptoajustec->fillBoolean($data);
                    $conceptoajustec->save();

                    //Forget cache
                    Cache::forget( ConceptoAjustec::$key_cache );
                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $conceptoajustec->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $conceptoajustec->errors]);
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
