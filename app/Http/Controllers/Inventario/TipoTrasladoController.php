<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Inventario\TipoTraslado;

use DB, Log, Datatables, Cache;

class TipoTrasladoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of(TipoTraslado::query())->make(true);
        }
        return view('inventario.tipostraslados.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventario.tipostraslados.create');
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
            $tipotraslado = new TipoTraslado;
            if ($tipotraslado->isValid($data)) {
                DB::beginTransaction();
                try {
                    //tipo traslado
                    $tipotraslado->fill($data);
                    $tipotraslado->fillBoolean($data);
                    $tipotraslado->save();

                    // Forget cache
                    Cache::forget( TipoTraslado::$key_cache );

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $tipotraslado->id]);
                } catch (\Exception $e) {

                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]); 
                }
            }
            return response()->json(['success' => false, 'errors' => $tipotraslado->errors]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $tipotraslado = TipoTraslado::findOrFail($id);
        if ($request->ajax()) {
            return response()->json($tipotraslado);
        }
        return view('inventario.tipostraslados.show',['tipotraslado' => $tipotraslado]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tipotraslado = TipoTraslado::findOrFail($id);
        return view('inventario.tipostraslados.edit',['tipotraslado' => $tipotraslado]);
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
            $tipotraslado = TipoTraslado::findOrFail($id);
            if ($tipotraslado->isValid($data)) {
                DB::beginTransaction();
                try {
                    //tipotraslado
                    $tipotraslado->fill($data);
                    $tipotraslado->fillBoolean($data);
                    $tipotraslado->save();

                    // Forget cache
                    Cache::forget( TipoTraslado::$key_cache );
                    
                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $tipotraslado->id]);
                } catch (\Exception $e) {

                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]); 
                }
            }
            return response()->json(['success' => false, 'errors' => $tipotraslado->errors]);
        }
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
