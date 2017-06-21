<?php

namespace App\Http\Controllers\Tecnico;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Tecnico\ConceptoTecnico;
use DB, Log, Datatables, Cache;

class ConceptoTecController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = ConceptoTecnico::query();
            return Datatables::of($query)->make(true);
        }
        return view('tecnico.conceptostecnico.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tecnico.conceptostecnico.create');
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
            $data =  $request->all();
            $conceptotecnico = new ConceptoTecnico;
            if ($conceptotecnico->isValid($data)) {
                DB::beginTransaction();
                try {
                    $conceptotecnico->fill($data);
                    $conceptotecnico->fillBoolean($data);
                    $conceptotecnico->save();

                    //Forget cache
                    Cache::forget( ConceptoTecnico::$key_cache );

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $conceptotecnico->id]);

                } catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]); 
                }
            }
            return response()->json(['success' => false, 'errors' => $conceptotecnico->errors]);
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
        $conceptotecnico = ConceptoTecnico::findOrFail($id);
        if ($request->ajax()) {
            return response()->json($conceptotecnico);
        }
        return view('tecnico.conceptostecnico.show', ['conceptotecnico' => $conceptotecnico]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $conceptotecnico = ConceptoTecnico::findOrFail($id);
        return view('tecnico.conceptostecnico.edit', ['conceptotecnico' => $conceptotecnico]);
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
            $conceptotecnico = ConceptoTecnico::findOrFail($id);
            if ($conceptotecnico->isValid($data)) {
                DB::beginTransaction();
                try {
                    // ConceptoTecnico
                    $conceptotecnico->fill($data);
                    $conceptotecnico->fillBoolean($data);
                    $conceptotecnico->save();

                    //Forget cache
                    Cache::forget( ConceptoTecnico::$key_cache );
                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $conceptotecnico->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $conceptotecnico->errors]);
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
