<?php

namespace App\Http\Controllers\Tecnico;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Tecnico\Solicitante;
use DB, Log, Datatables,Cache;

class SolicitanteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $query = Solicitante::query();
            return Datatables::of($query)->make(true);
        }
        return view('tecnico.solicitante.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tecnico.solicitante.create');
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
            $solicitante = new Solicitante;
            if ($solicitante->isValid($data)) {
                DB::beginTransaction();
                try {
                    // solicitantes
                    $solicitante->fill($data);
                    $solicitante->fillBoolean($data);
                    $solicitante->save();

                    // Commit Transaction
                    DB::commit();

                    //Forget Cache
                    Cache::forget( Solicitante::$key_cache );
                    return response()->json(['success' => true, 'id' => $solicitante->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $solicitante->errors]);
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
        $solicitante = Solicitante::findOrFail($id);
        if($request->ajax()){
            return response()->json($solicitante);
        }
        return view('tecnico.solicitante.show',['solicitante' => $solicitante]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $solicitante = Solicitante::findOrFail($id);
        return view('tecnico.solicitante.edit', ['solicitante' => $solicitante]);
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
            $solicitante = Solicitante::findOrFail($id);
            if ($solicitante->isValid($data)) {
                DB::beginTransaction();
                try {
                    // solicitante
                    $solicitante->fill($data);
                    $solicitante->fillBoolean($data);
                    $solicitante->save();

                    // Commit Transaction
                    DB::commit();

                    //Forget Cache
                    Cache::forget( Solicitante::$key_cache );
                    return response()->json(['success' => true, 'id' => $solicitante->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $solicitante->errors]);
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
