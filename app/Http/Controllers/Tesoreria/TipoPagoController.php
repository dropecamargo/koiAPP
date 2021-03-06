<?php

namespace App\Http\Controllers\Tesoreria;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Tesoreria\TipoPago, App\Models\Base\Documentos;
use DB, Log, Datatables, Cache;

class TipoPagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = TipoPago::query();
            return Datatables::of($query)->make(true);
        }
        return view('tesoreria.tipopago.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tesoreria.tipopago.create');
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
            $tipopago = new TipoPago;
            if ($tipopago->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar documentos
                    if ($request->has('tipopago_documentos')) {
                        $documentos = Documentos::find($request->tipopago_documentos);
                        if (!$documentos instanceof Documentos) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar documentos, por favor verifique información o consulte con el administrador']);
                        }
                        $tipopago->tipopago_documentos = $documentos->id;
                    }

                    // TipoPago
                    $tipopago->fill($data);
                    $tipopago->fillBoolean($data);
                    $tipopago->save();

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget( TipoPago::$key_cache );
                    return response()->json(['success' => true, 'id' =>$tipopago->id]);
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $tipopago->errors]);
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
        $tipopago = TipoPago::getTipoPago($id);
        if ($request->ajax()) {
            return response()->json($tipopago);
        }
        return view('tesoreria.tipopago.show', ['tipopago' => $tipopago]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tipopago = TipoPago::findOrFail($id);
        return view('tesoreria.tipopago.edit', ['tipopago' => $tipopago]);
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
            $tipopago = TipoPago::findOrFail($id);
            if ($tipopago->isValid($data)) {
                DB::beginTransaction();
                try {

                    // Recuperar documentos
                    if ($request->has('tipopago_documentos')) {
                        $documentos = Documentos::find($request->tipopago_documentos);
                        if (!$documentos instanceof Documentos) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar documentos, por favor verifique información o consulte con el administrador']);
                        }
                        $tipopago->tipopago_documentos = $documentos->id;
                    }
                    // TipoPago
                    $tipopago->fill($data);
                    $tipopago->fillBoolean($data);
                    $tipopago->save();

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget( TipoPago::$key_cache );
                    return response()->json(['success' => true, 'id' =>$tipopago->id]);
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $tipopago->errors]);
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
