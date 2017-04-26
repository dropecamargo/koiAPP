<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Cartera\MedioPago;
use DB, Log, Cache, Datatables;
    
class MedioPagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = MedioPago::query();
            return Datatables::of($query)->make(true);
        }
        return view('cartera.mediopagos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cartera.mediopagos.create');
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
            $mediopago = new MedioPago;
            if ($mediopago->isValid($data)) {
                DB::beginTransaction();
                try {
                    // MedioPago
                    $mediopago->fill($data);
                    $mediopago->fillBoolean($data);
                    $mediopago->save();

                    //Forget cache
                    Cache::forget( MedioPago::$key_cache );
                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $mediopago->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $mediopago->errors]);
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
        $mediopago = MedioPago::findOrFail($id);
        if ($request->ajax()) {
            return response()->json($mediopago);
        }
        return view('cartera.mediopagos.show', ['mediopago' => $mediopago]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mediopago = MedioPago::findOrFail($id);
        return view('cartera.mediopagos.edit', ['mediopago' => $mediopago]);
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
            $mediopago = MedioPago::findOrFail($id);
            if ($mediopago->isValid($data)) {
                DB::beginTransaction();
                try {
                    // MedioPago
                    $mediopago->fill($data);
                    $mediopago->fillBoolean($data);
                    $mediopago->save();

                    //Forget cache
                    Cache::forget( MedioPago::$key_cache );
                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $mediopago->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $mediopago->errors]);
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
