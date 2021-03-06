<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Cartera\Conceptosrc, App\Models\Cartera\ConceptoNota, App\Models\Base\Documentos, App\Models\Contabilidad\PlanCuenta;
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
            $query->select('conceptosrc.*', 'documentos_nombre');
            $query->leftJoin('documentos', 'conceptosrc_documentos', '=', 'documentos.id');
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
                    if ($request->has('conceptosrc_documentos')) {
                        $documentos = Documentos::find($request->conceptosrc_documentos);
                        if(!$documentos instanceof Documentos){
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar documento, verifique información ó por favor consulte al administrador.']);
                        }
                        $conceptosrc->conceptosrc_documentos = $documentos->id;
                    }
                    //Recuperar Plan cuenta
                    $cuenta = PlanCuenta::find($request->conceptosrc_cuenta);
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
                    // conceptosrc
                    $conceptosrc->fill($data);
                    $conceptosrc->fillBoolean($data);
                    $conceptosrc->conceptosrc_cuenta = $cuenta->id;
                    $conceptosrc->save();

                    // Commit Transaction
                    DB::commit();

                    //Forget cache
                    Cache::forget( Conceptosrc::$key_cache );
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
                    if ($request->has('conceptosrc_documentos')) {
                        $documentos = Documentos::find($request->conceptosrc_documentos);
                        if(!$documentos instanceof Documentos){
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar documento, verifique información ó por favor consulte al administrador.']);
                        }
                        $conceptosrc->conceptosrc_documentos = $documentos->id;
                    }

                    //Recuperar Plan cuenta
                    $cuenta = PlanCuenta::find($request->conceptosrc_cuenta);
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
                    // conceptosrc
                    $conceptosrc->fill($data);
                    $conceptosrc->fillBoolean($data);
                    $conceptosrc->conceptosrc_cuenta = $cuenta->id;
                    $conceptosrc->save();

                    // Commit Transaction
                    DB::commit();

                    //Forget cache
                    Cache::forget( Conceptosrc::$key_cache );
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

    public function evaluate(Request $request)
    {
        // Prepare response
        $response = new \stdClass();
        $response->action = "";
        $response->success = false;

        if($request->has('call')){

            if($request->call == 'recibo'){
                $conceptosrc = Conceptosrc::getConceptosrc($request->recibo2_conceptosrc);
                if (!$conceptosrc instanceof Conceptosrc) {
                    $response->errors = "No es posible recuperar concepto, verifique información ó por favor consulte al administrador.";
                }

                if($conceptosrc->documentos_codigo == 'FACT'){
                    $action = 'modalCartera';
                    $response->action = $action;
                    $response->success = true;
                }else if ($conceptosrc->documentos_codigo == 'CHD'){
                    $action = 'modalChequesDevueltos';
                    $response->action = $action;
                    $response->success = true;
                }else if($conceptosrc->documentos_codigo == 'ANTI'){
                    $action = 'modalAnticipos';
                    $response->action = $action;
                    $response->success = true;
                }else{
                    $response->success = false;
                }
            }
            if($request->call == 'chposfechado'){
                $conceptosrc = Conceptosrc::getConceptosrc($request->chposfechado2_conceptosrc);
                if (!$conceptosrc instanceof Conceptosrc) {
                    $response->errors = "No es posible recuperar concepto, verifique información ó por favor consulte al administrador.";
                }

                if($conceptosrc->documentos_codigo == 'FACT'){
                    $action = 'modalCartera';
                    $response->action = $action;
                    $response->success = true;
                }else{
                    $response->success = false;
                }
            }

            if($request->call == 'ajustesc'){
                $documentos = Documentos::find($request->ajustec2_documentos_doc);
                if (!$documentos instanceof Documentos) {
                    $response->errors = "No es posible recuperar documento, verifique información ó por favor consulte al administrador.";
                }

                if( $documentos->documentos_codigo == 'FACT' ){
                    $action = 'modalCartera';
                    $response->action = $action;
                    $response->success = true;
                }else if ( $documentos->documentos_codigo == 'CHD' ){
                    $action = 'modalChequesDevueltos';
                    $response->action = $action;
                    $response->success = true;
                }else if($documentos->documentos_codigo == 'ANTI'){
                   $action = 'modalAnticipos';
                    $response->action = $action;
                    $response->success = true;
                }else{
                    $response->success = false;
                }
            }

            if($request->call == 'nota'){
                $documentos = Documentos::find($request->nota2_documentos_doc);
                if (!$documentos instanceof Documentos) {
                    $response->errors = "No es posible recuperar documento, verifique información ó por favor consulte al administrador.";
                }
                if ($documentos->documentos_codigo == 'FACT') {
                    $action = 'modalCartera';
                    $response->action = $action;
                    $response->success = true;
                }else if( $documentos->documentos_codigo == 'CHD' ){
                    $action = 'modalChequesDevueltos';
                    $response->action = $action;
                    $response->success = true;
                }else if($documentos->documentos_codigo == 'ANTI'){
                    $action = 'modalAnticipos';
                    $response->action = $action;
                    $response->success = true;
                }else{
                    $response->success = false;
                }
            }
        }
        return response()->json($response);
    }
}
