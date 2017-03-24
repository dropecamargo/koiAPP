<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB, Log, Datatables, Cache;

use App\Models\Inventario\UnidadNegocio;

class UnidadNegocioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = UnidadNegocio::query();
            return Datatables::of($query)->make(true);
        }
        return view('inventario.unidadesnegocio.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventario.unidadesnegocio.create');
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
            $unidadnegocio = new UnidadNegocio;
            if ($unidadnegocio->isValid($data)) {
                DB::beginTransaction();
                try {
                    // unidad
                    $unidadnegocio->fill($data);
                    $unidadnegocio->fillBoolean($data);
                    $unidadnegocio->save();

                    // Commit Transaction
                    DB::commit();
                    // Forget cache
                    Cache::forget( UnidadNegocio::$key_cache );

                    return response()->json(['success' => true, 'id' => $unidadnegocio->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $unidadnegocio->errors]);
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
        $unidadnegocio = UnidadNegocio::findOrFail($id);
        if ($request->ajax()) {
            return response()->json($unidadnegocio);
        }
        return view('inventario.unidadesnegocio.show', ['unidadnegocio' => $unidadnegocio]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $unidadnegocio = UnidadNegocio::findOrFail($id);
        return view('inventario.unidadesnegocio.edit', ['unidadnegocio' => $unidadnegocio]);
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

            $unidadnegocio = UnidadNegocio::findOrFail($id);
            if ($unidadnegocio->isValid($data)) {
                DB::beginTransaction();
                try {
                    // unidad
                    $unidadnegocio->fill($data);
                    $unidadnegocio->fillBoolean($data);
                    $unidadnegocio->save();

                    // Commit Transaction
                    DB::commit();
                    // Forget cache
                    Cache::forget( UnidadNegocio::$key_cache );

                    return response()->json(['success' => true, 'id' => $unidadnegocio->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $unidadnegocio->errors]);
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
