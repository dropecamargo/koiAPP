<?php

namespace App\Http\Controllers\Cobro;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Cobro\ContactoDeudor, App\Models\Cobro\Deudor;
use DB, Log;

class ContactoDeudorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $detalle = [];
            if( $request->has('deudor_id') ){
                $detalle = ContactoDeudor::where('contactodeudor_deudor', $request->deudor_id)->get();
            }
            return response()->json($detalle);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

            $contactodeudor = new ContactoDeudor;
            if ($contactodeudor->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar tercero
                    $deudor = Deudor::find($request->deudor_id);
                    if(!$deudor instanceof Deudor) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar al deudor, por favor verifique la información o consulte al administrador.']);
                    }

                    // ContactoDeudor
                    $contactodeudor->fill($data);
                    $contactodeudor->contactodeudor_deudor = $deudor->id;
                    $contactodeudor->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true,
                        'id' => $contactodeudor->id,
                        'contactodeudor_nombre' => $contactodeudor->contactodeudor_nombre
                    ]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $contactodeudor->errors]);
        }
        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

            $contactodeudor = ContactoDeudor::findOrFail($id);
            if ($contactodeudor->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Documento
                    $contactodeudor->fill($data);
                    $contactodeudor->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $contactodeudor->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $contactodeudor->errors]);
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
