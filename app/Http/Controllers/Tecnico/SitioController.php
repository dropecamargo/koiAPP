<?php

namespace App\Http\Controllers\Tecnico;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Tecnico\Sitio;
use DB, Log, Cache, Datatables;

class SitioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $query = Sitio::query();
            return Datatables::of($query)->make(true);
        }
        return view('tecnico.sitios.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tecnico.sitios.create');
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

            $sitio = new Sitio;
            if ($sitio->isValid($data)) {
                DB::beginTransaction();
                try {

                    // Sitio
                    $sitio->fill($data);
                    $sitio->fillBoolean($data);
                    $sitio->save();

                    // Commit Transaction
                    DB::commit();
                    
                    //Forget Cache
                    Cache::forget( Sitio::$key_cache );
                    
                    return response()->json(['success' => true, 'id' => $sitio->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $sitio->errors]);
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
        $sitio = Sitio::findOrFail($id);
        if($request->ajax()){
            return response()->json($sitio);
        }
        return view('tecnico.sitios.show',['sitio' => $sitio]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sitio = Sitio::findOrFail($id);
        return view('tecnico.sitios.edit', ['sitio' => $sitio]);
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
            $sitio = Sitio::findOrFail($id);
            if ($sitio->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Sitio
                    $sitio->fill($data);
                    $sitio->fillBoolean($data);
                    $sitio->save();
                    
                    // Commit Transaction
                    DB::commit();
                    
                    return response()->json(['success' => true, 'id' => $sitio->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $sitio->errors]);
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
