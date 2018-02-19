<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Inventario\TipoProducto;
use DB, Log, Datatables, Cache;

class TipoProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $query = TipoProducto::query();
            return Datatables::of($query)->make(true);
        }
        return view('inventario.tipoproducto.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventario.tipoproducto.create');
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

            $tipoproducto = new TipoProducto;
            if ($tipoproducto->isValid($data)) {
                DB::beginTransaction();
                try {
                    // TipoProducto
                    $tipoproducto->fill($data);
                    $tipoproducto->fillBoolean($data);
                    $tipoproducto->save();

                    // Commit Transaction
                    DB::commit();

                    //Forget cache
                    Cache::forget( TipoProducto::$key_cache );
                    return response()->json(['success' => true, 'id' => $tipoproducto->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $tipoproducto->errors]);
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
        $tipoproducto = TipoProducto::findOrFail($id);
        if ($request->ajax()) {
            return response()->json($tipoproducto);
        }
        return view('inventario.tipoproducto.show', ['tipoproducto' => $tipoproducto]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tipoproducto = TipoProducto::findOrFail($id);
        return view('inventario.tipoproducto.edit', ['tipoproducto' => $tipoproducto]);
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

            $tipoproducto = TipoProducto::findOrFail($id);
            if ($tipoproducto->isValid($data)) {
                DB::beginTransaction();
                try {
                    // TipoProducto
                    $tipoproducto->fill($data);
                    $tipoproducto->fillBoolean($data);
                    $tipoproducto->save();

                    // Commit Transaction
                    DB::commit();

                    //Forget cache
                    Cache::forget( TipoProducto::$key_cache );
                    return response()->json(['success' => true, 'id' => $tipoproducto->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $tipoproducto->errors]);
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
