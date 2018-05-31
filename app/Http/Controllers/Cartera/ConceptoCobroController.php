<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Cartera\ConceptoCob, App\Models\Contabilidad\PlanCuenta;
use DB, Log, Datatables, Cache;

class ConceptoCobroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = ConceptoCob::query();
            return Datatables::of($query)->make(true);
        }
        return view('cartera.conceptocobros.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cartera.conceptocobros.create');
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
            $data =  $request->all();
            $conceptocobro = new ConceptoCob;
            if ($conceptocobro->isValid($data)) {
                DB::beginTransaction();
                try {
                    //Recuperar Plan cuenta
                    $cuenta = PlanCuenta::find($request->conceptocob_cuenta);
                    if(!$cuenta instanceof PlanCuenta) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar plan de cuenta, verifique información ó por favor consulte al administrador.']);
                    }

                    // Validando Sub Niveles
                    $result = $cuenta->validarSubnivelesCuenta();
                    if ($result != 'OK') {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result ]);
                    }

                    // Concepto Cobro
                    $conceptocobro->fill($data);
                    $conceptocobro->fillBoolean($data);
                    $conceptocobro->conceptocob_cuenta= $cuenta->id;
                    $conceptocobro->save();

                    // Commit Transaction
                    DB::commit();

                    //Forget cache
                    Cache::forget( ConceptoCob::$key_cache );
                    return response()->json(['success' => true, 'id' => $conceptocobro->id]);
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $conceptocobro->errors]);
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
        $conceptocobro = ConceptoCob::getConcepto($id);
        if ($request->ajax()) {
            return response()->json($conceptocobro);
        }
        return view('cartera.conceptocobros.show', ['conceptocobro' => $conceptocobro]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $conceptocobro = ConceptoCob::findOrFail($id);
        return view('cartera.conceptocobros.edit', ['conceptocobro' => $conceptocobro]);
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
            $conceptocobro = ConceptoCob::findOrFail($id);
            if ($conceptocobro->isValid($data)) {
                DB::beginTransaction();
                try {
                    //Recuperar Plan cuenta
                    $cuenta = PlanCuenta::find($request->conceptocob_cuenta);
                    if(!$cuenta instanceof PlanCuenta) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar plan de cuenta, verifique información ó por favor consulte al administrador.']);
                    }

                    // Validando Sub Niveles
                    $result = $cuenta->validarSubnivelesCuenta();
                    if ($result != 'OK') {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result ]);
                    }

                    // Concepto Cobro
                    $conceptocobro->fill($data);
                    $conceptocobro->fillBoolean($data);
                    $conceptocobro->conceptocob_cuenta= $cuenta->id;
                    $conceptocobro->save();

                    // Commit Transaction
                    DB::commit();

                    //Forget cache
                    Cache::forget( ConceptoCob::$key_cache );
                    return response()->json(['success' => true, 'id' => $conceptocobro->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $conceptocobro->errors]);
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
