<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB, Log, Datatables;

use App\Models\Base\TipoActividad;

class TipoActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $query = TipoActividad::query();
            return Datatables::of($query)->make(true);
        }
        return view('admin.tiposactividad.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tiposactividad.create');
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
            $tipoactividad = new TipoActividad;
            if ($tipoactividad->isValid($data)) {
                DB::beginTransaction();
                try {
                    // tipoactividad
                    $tipoactividad->fill($data);
                    $tipoactividad->fillBoolean($data);
                    $tipoactividad->save();

                    // Commit Transaction
                    DB::commit();

                    return response()->json(['success' => true, 'id' => $tipoactividad->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $tipoactividad->errors]);
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
        $tipoactividad = TipoActividad::findOrFail($id);
        if ($request->ajax()) {
            return response()->json($tipoactividad);
        } 
        return view('admin.tiposactividad.show', ['tipoactividad' => $tipoactividad]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tipoactividad = TipoActividad::findOrFail($id);
        return view('admin.tiposactividad.edit', ['tipoactividad' => $tipoactividad]);
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
            $tipoactividad = TipoActividad::findOrFail($id);
            if ($tipoactividad->isValid($data)) {
                DB::beginTransaction();
                try {
                    // tipoactividad
                    $tipoactividad->fill($data);
                    $tipoactividad->fillBoolean($data);
                    $tipoactividad->save();

                    // Commit Transaction
                    DB::commit();

                    return response()->json(['success' => true, 'id' => $tipoactividad->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $tipoactividad->errors]);
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
