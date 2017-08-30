<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Inventario\SubCategoria;
use DB, Log, Datatables, Cache;

class SubCategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = SubCategoria::query();
            return Datatables::of($query)->make(true);
        }
        return view('inventario.subcategoria.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventario.subcategoria.create');
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
            $subcategoria = new SubCategoria;
            if ($subcategoria->isValid($data)) {
                DB::beginTransaction();
                try {
                    //SubCategoria
                    $subcategoria->fill($data);
                    $subcategoria->fillBoolean($data);
                    $subcategoria->save();

                    //Forget cache
                    Cache::forget( SubCategoria::$key_cache );

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $subcategoria->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $subcategoria->errors]);
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
        $subcategoria = SubCategoria::findOrFail($id);
        if ($request->ajax()) {
            return response()->json($subcategoria);
        }
        return view('inventario.subcategoria.show', ['subcategoria' => $subcategoria]);   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subcategoria = SubCategoria::findOrFail($id);
        return view('inventario.subcategoria.edit', ['subcategoria' => $subcategoria]);
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
            $subcategoria = SubCategoria::findOrFail($id);
            if ($subcategoria->isValid($data)) {
                DB::beginTransaction();
                try {
                    // SubCategoria
                    $subcategoria->fill($data);
                    $subcategoria->fillBoolean($data);
                    $subcategoria->save();

                    //Forget cache
                    Cache::forget( SubCategoria::$key_cache );
                    
                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $subcategoria->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $subcategoria->errors]);
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
