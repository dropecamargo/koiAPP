<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Inventario\TipoAjuste;

use DB, Log, Datatables, Cache;


class TipoAjusteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of(TipoAjuste::query())->make(true);
        }
        return view('inventario.tiposajuste.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventario.tiposajuste.create');
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
            $tipoajuste = new TipoAjuste;
            if ($tipoajuste->isValid($data)) {
                DB::beginTransaction();
                try {
                    //tipoajuste
                    $tipoajuste->fill($data);
                    $tipoajuste->fillBoolean($data);
                    $tipoajuste->save();

                    // Commit Transaction
                    DB::commit();
                    // Forget cache
                    Cache::forget( TipoAjuste::$key_cache );
                    return response()->json(['success' => true, 'id' => $tipoajuste->id]);
                } catch (\Exception $e) {

                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]); 
                }
            }
            return response()->json(['success' => false, 'errors' => $tipoajuste->errors]);
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
        
        $tipoajuste = TipoAjuste::findOrFail($id);
        if ($request->ajax()) {
            return response()->json($tipoajuste);
        }
        return view('inventario.tiposajuste.show',['tipoajuste'=>$tipoajuste]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tipoajuste = TipoAjuste::findOrFail($id);
        return view('inventario.tiposajuste.edit',['tipoajuste'=>$tipoajuste]);
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
            $tipoajuste = TipoAjuste::findOrFail($id);
            if ($tipoajuste->isValid($data)) {
                DB::beginTransaction();
                try {
                    //tipoajuste
                    $tipoajuste->fill($data);
                    $tipoajuste->fillBoolean($data);
                    $tipoajuste->save();
                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $tipoajuste->id]);
                } catch (\Exception $e) {

                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]); 
                }
            }
            return response()->json(['success' => false, 'errors' => $tipoajuste->errors]);
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
