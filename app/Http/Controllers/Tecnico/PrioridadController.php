<?php

namespace App\Http\Controllers\Tecnico;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Tecnico\Prioridad;
use DB, Log, Datatables,Cache;

class PrioridadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $query = Prioridad::query();
            return Datatables::of($query)->make(true);
        }
        return view('tecnico.prioridad.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tecnico.prioridad.create');
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

            $prioridad = new Prioridad;
            if ($prioridad->isValid($data)) {
                DB::beginTransaction();
                try {
                    // prioridads
                    $prioridad->fill($data);
                    $prioridad->fillBoolean($data);
                    $prioridad->save();

                    // Commit Transaction
                    DB::commit();

                    //Forget Cache
                    Cache::forget( Prioridad::$key_cache );
                    return response()->json(['success' => true, 'id' => $prioridad->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $prioridad->errors]);
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
        $prioridad = Prioridad::findOrFail($id);
        if($request->ajax()){
            return response()->json($prioridad);
        }
        return view('tecnico.prioridad.show',['prioridad' => $prioridad]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $prioridad = Prioridad::findOrFail($id);
        return view('tecnico.prioridad.edit', ['prioridad' => $prioridad]);
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
            $prioridad = Prioridad::findOrFail($id);
            if ($prioridad->isValid($data)) {
                DB::beginTransaction();
                try {
                    // prioridad
                    $prioridad->fill($data);
                    $prioridad->fillBoolean($data);
                    $prioridad->save();

                    // Commit Transaction
                    DB::commit();

                    //Forget Cache
                    Cache::forget( Prioridad::$key_cache );
                    return response()->json(['success' => true, 'id' => $prioridad->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $prioridad->errors]);
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
