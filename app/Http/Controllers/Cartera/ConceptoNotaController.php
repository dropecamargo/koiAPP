<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Contabilidad\PlanCuenta, App\Models\Cartera\ConceptoNota;
use DB, Log, Datatables, Cache;

class ConceptoNotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = ConceptoNota::query();
            return Datatables::of($query)->make(true);
        }
        return view('cartera.conceptonotas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cartera.conceptonotas.create');
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
            $conceptonota = new ConceptoNota;
            if ($conceptonota->isValid($data)) {
                DB::beginTransaction();
                try {

                    //Recuperar Plan cuenta
                    $cuenta = PlanCuenta::find($request->conceptonota_cuenta);
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
                    $conceptonota->fill($data);
                    $conceptonota->fillBoolean($data);
                    $conceptonota->conceptonota_cuenta = $cuenta->id;
                    $conceptonota->save();

                    // Commit Transaction
                    DB::commit();

                    //Forget cache
                    Cache::forget( ConceptoNota::$key_cache );
                    return response()->json(['success' => true, 'id' => $conceptonota->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $conceptonota->errors]);
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
        $conceptonota = ConceptoNota::getConceptoNota($id);
        if ($request->ajax()) {
            return response()->json($conceptonota);
        }
        return view('cartera.conceptonotas.show', ['conceptonota' => $conceptonota]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $conceptonota = ConceptoNota::find($id);
        return view('cartera.conceptonotas.edit', ['conceptonota' => $conceptonota]);
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
            $conceptonota = ConceptoNota::findOrFail($id);
            if ($conceptonota->isValid($data)) {
                DB::beginTransaction();
                try {

                    //Recuperar Plan cuenta
                    $cuenta = PlanCuenta::find($request->conceptonota_cuenta);
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
                    $conceptonota->fill($data);
                    $conceptonota->fillBoolean($data);
                    $conceptonota->conceptonota_cuenta = $cuenta->id;
                    $conceptonota->save();

                    // Commit Transaction
                    DB::commit();

                    //Forget cache
                    Cache::forget( ConceptoNota::$key_cache );
                    return response()->json(['success' => true, 'id' => $conceptonota->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $conceptonota->errors]);
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
