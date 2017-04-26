<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Cartera\Conceptosrc;
use App\Models\Base\Documentos;
use App\Models\Contabilidad\PlanCuenta;
use DB, Log, Cache, Datatables;

class ConceptosrcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Conceptosrc::query();
            $query->select('conceptosrc.*', 'plancuentas_nombre', 'documentos_nombre');
            $query->join('plancuentas', 'conceptosrc_plancuentas', '=', 'plancuentas.id');
            $query->join('documentos', 'conceptosrc_documentos', '=', 'documentos.id');
            return Datatables::of($query)->make(true);
        }
        return view('cartera.conceptosrc.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cartera.conceptosrc.create');
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
            $conceptosrc = new Conceptosrc;
            if ($conceptosrc->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar cuenta
                    $plancuentas = PlanCuenta::where('plancuentas_cuenta', $request->conceptosrc_plancuentas)->first();
                    if(!$plancuentas instanceof PlanCuenta){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar plan de cuenta, verifique información ó por favor consulte al administrador.']);
                    }

                    $documentos = Documentos::find($request->conceptosrc_documentos);
                    if(!$documentos instanceof Documentos){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar documento, verifique información ó por favor consulte al administrador.']);
                    }

                    // conceptosrc
                    $conceptosrc->fill($data);
                    $conceptosrc->fillBoolean($data);
                    $conceptosrc->conceptosrc_plancuentas = $plancuentas->id;
                    $conceptosrc->conceptosrc_documentos = $documentos->id;
                    $conceptosrc->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $conceptosrc->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $conceptosrc->errors]);
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
        $conceptosrc = Conceptosrc::getConceptosrc($id);
        if ($request->ajax()) {
            return response()->json($conceptosrc);
        }
        return view('cartera.conceptosrc.show', ['conceptosrc' => $conceptosrc]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $conceptosrc = Conceptosrc::getConceptosrc($id);
        return view('cartera.conceptosrc.edit', ['conceptosrc' => $conceptosrc]);
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
            $conceptosrc = Conceptosrc::findOrFail($id);
            if ($conceptosrc->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar cuenta
                    $plancuentas = PlanCuenta::where('plancuentas_cuenta', $request->conceptosrc_plancuentas)->first();
                    if(!$plancuentas instanceof PlanCuenta){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar plan de cuenta, verifique información ó por favor consulte al administrador.']);
                    }

                    $documentos = Documentos::find($request->conceptosrc_documentos);
                    if(!$documentos instanceof Documentos){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar documento, verifique información ó por favor consulte al administrador.']);
                    }

                    // conceptosrc
                    $conceptosrc->fill($data);
                    $conceptosrc->fillBoolean($data);
                    $conceptosrc->conceptosrc_plancuentas = $plancuentas->id;
                    $conceptosrc->conceptosrc_documentos = $documentos->id;
                    $conceptosrc->save();;

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $conceptosrc->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $conceptosrc->errors]);
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
