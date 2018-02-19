<?php

namespace App\Http\Controllers\Comercial;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Comercial\ConceptoComercial;
use DB, Log, Datatables, Cache;

class ConceptoComercialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = ConceptoComercial::query();
            return Datatables::of($query)->make(true);
        }
        return view('comercial.conceptoscomercial.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('comercial.conceptoscomercial.create');
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
            $conceptocomercial = new ConceptoComercial;
            if ($conceptocomercial->isValid($data)) {
                DB::beginTransaction();
                try {
                    $conceptocomercial->fill($data);
                    $conceptocomercial->fillBoolean($data);
                    $conceptocomercial->save();

                    // Commit Transaction
                    DB::commit();

                    //Forget cache
                    Cache::forget( ConceptoComercial::$key_cache );
                    return response()->json(['success' => true, 'id' => $conceptocomercial->id]);
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $conceptocomercial->errors]);
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
        $conceptocomercial = ConceptoComercial::findOrFail($id);
        if ($request->ajax()) {
            return response()->json($conceptocomercial);
        }
        return view('comercial.conceptoscomercial.show', ['conceptocomercial' => $conceptocomercial]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $conceptocomercial = ConceptoComercial::findOrFail($id);
        return view('comercial.conceptoscomercial.edit', ['conceptocomercial' => $conceptocomercial]);
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
            $conceptocomercial = ConceptoComercial::findOrFail($id);
            if ($conceptocomercial->isValid($data)) {
                DB::beginTransaction();
                try {
                    // ConceptoComercial
                    $conceptocomercial->fill($data);
                    $conceptocomercial->fillBoolean($data);
                    $conceptocomercial->save();

                    // Commit Transaction
                    DB::commit();

                    //Forget cache
                    Cache::forget( ConceptoComercial::$key_cache );
                    return response()->json(['success' => true, 'id' => $conceptocomercial->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $conceptocomercial->errors]);
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
