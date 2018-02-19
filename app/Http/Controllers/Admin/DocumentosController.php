<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Base\Documentos, App\Models\Tesoreria\TipoPago;
use DB, Log, Cache, Datatables;

class DocumentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $query = Documentos::query();
            return Datatables::of($query)->make(true);
        }
        return view('admin.documento.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.documento.create');
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
            $documentos = new Documentos;
            if ($documentos->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Documento
                    $documentos->fill($data);
                    $documentos->save();

                    // Commit Transaction
                    DB::commit();

                    //Forget cache
                    Cache::forget( Documentos::$key_cache );
                    return response()->json(['success' => true, 'id' => $documentos->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $documentos->errors]);
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
        $documentos = Documentos::findOrFail($id);
        if ($request->ajax()) {
            return response()->json($documentos);
        }
        return view('admin.documento.show', ['documentos' => $documentos]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $documentos = Documentos::findOrFail($id);
        return view('admin.documento.edit', ['documentos' => $documentos]);
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
            $documentos = Documentos::findOrFail($id);
            if ($documentos->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Documento
                    $documentos->fill($data);
                    $documentos->save();

                    // Commit Transaction
                    DB::commit();

                    //Forget cache
                    Cache::forget( Documentos::$key_cache );
                    return response()->json(['success' => true, 'id' => $documentos->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $documentos->errors]);
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

    /**
     * Evaluate actions detail asiento.
     *
     * @return \Illuminate\Http\Response
     */

    public function evaluate(Request $request)
    {
        // Prepare response
        $response = new \stdClass();
        $response->action = "";
        $response->success = false;

        if ($request->has('call')) {
            if ($request->call == 'ajustep') {
                $documentos = Documentos::find($request->ajustep2_documentos_doc);
                if (!$documentos instanceof Documentos) {
                    $response->errors = "No es posible recuperar documento, verifique información ó por favor consulte al administrador.";
                }
                if ($documentos->documentos_codigo == 'FPRO') {
                    $action = 'modalFacturaProveedor';
                    $response->action = $action;
                    $response->success = true;
                }
            }
            if ($request->call == 'egreso') {
                $tipopago = TipoPago::getTipoPago($request->egreso2_tipopago);
                if (!$tipopago instanceof TipoPago) {
                    $response->errors = "No es posible recuperar documento, verifique información ó por favor consulte al administrador.";
                }
                if ($tipopago->documentos_codigo == 'FPRO') {
                    $action = 'modalFacturaProveedor';
                    $response->action = $action;
                    $response->success = true;
                }
            }
        }
        return response()->json($response);
    }
}
