<?php

namespace App\Http\Controllers\Tecnico;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Tecnico\TipoOrden;

use DB, Log, Cache,Datatables;

class TipoOrdenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            $query = TipoOrden::query();
            return Datatables::of($query)->make(true);
        }
        return view('tecnico.tipoorden.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tecnico.tipoorden.create');
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

            $tipoorden = new TipoOrden;
            if ($tipoorden->isValid($data)) {
                DB::beginTransaction();
                try {
                    // tipoorden
                    $tipoorden->fill($data);
                    $tipoorden->fillBoolean($data);
                    $tipoorden->save();

                    //Forget Cache
                    Cache::forget( TipoOrden::$key_cache );

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $tipoorden->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $tipoorden->errors]);
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
        $tipoorden = TipoOrden::findOrFail($id);
        if ($request->ajax()) {
            return response()->json($tipoorden);
        }
        return view('tecnico.tipoorden.show', ['tipoorden' => $tipoorden]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tipoorden = TipoOrden::findOrFail($id);
        return view('tecnico.tipoorden.edit', ['tipoorden' => $tipoorden]);
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
            $tipoorden = TipoOrden::findOrFail($id);
            if ($tipoorden->isValid($data)) {
                DB::beginTransaction();
                try {
                    // tipoorden
                    $tipoorden->fill($data);
                    $tipoorden->fillBoolean($data);
                    $tipoorden->save();

                    //Forget Cache
                    Cache::forget( TipoOrden::$key_cache );
                    
                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $tipoorden->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $tipoorden->errors]);
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
