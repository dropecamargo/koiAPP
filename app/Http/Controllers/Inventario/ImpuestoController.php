<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Inventario\Impuesto;
use DB, Log, Datatables, Cache;

class ImpuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Impuesto::query();
            return Datatables::of($query)->make(true);
        }
        return view('inventario.impuesto.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventario.impuesto.create');
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

            $impuesto = new Impuesto;
            if ($impuesto->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Impuestos
                    $impuesto->fill($data);
                    $impuesto->fillBoolean($data);
                    $impuesto->save();

                    // Commit Transaction
                    DB::commit();
                    //Forget cache
                    Cache::forget( Impuesto::$key_cache );

                    return response()->json(['success' => true, 'id' => $impuesto->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $impuesto->errors]);
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
        $impuesto = Impuesto::findOrFail($id);
        if ($request->ajax()) {
            return response()->json($impuesto);
        }
        return view('inventario.impuesto.show', ['impuesto' => $impuesto]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $impuesto = Impuesto::findOrFail($id);
        return view('inventario.impuesto.edit', ['impuesto' => $impuesto]);
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
            $impuesto = Impuesto::findOrFail($id);
            if ($impuesto->isValid($data)) {
                DB::beginTransaction();
                try {
                    // marca
                    $impuesto->fill($data);
                    $impuesto->fillBoolean($data);
                    $impuesto->save();
                    // Commit Transaction
                    DB::commit();
                    
                    return response()->json(['success' => true, 'id' => $impuesto->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $impuesto->errors]);
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
