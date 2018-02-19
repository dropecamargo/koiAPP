<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Cartera\Banco;
use DB, Log, Cache, Datatables;

class BancoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Banco::query();
            return Datatables::of($query)->make(true);
        }
        return view('cartera.bancos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cartera.bancos.create');
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
            $banco = new Banco;
            if ($banco->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Banco
                    $banco->fill($data);
                    $banco->fillBoolean($data);
                    $banco->save();

                    // Commit Transaction
                    DB::commit();

                    //Forget cache
                    Cache::forget( Banco::$key_cache );
                    return response()->json(['success' => true, 'id' => $banco->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $banco->errors]);
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
        $banco = Banco::findOrFail($id);
        if ($request->ajax()) {
            return response()->json($banco);
        }
        return view('cartera.bancos.show', ['banco' => $banco]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banco = Banco::findOrFail($id);
        return view('cartera.bancos.edit', ['banco' => $banco]);
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
            $banco = Banco::findOrFail($id);
            if ($banco->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Banco
                    $banco->fill($data);
                    $banco->fillBoolean($data);
                    $banco->save();

                    // Commit Transaction
                    DB::commit();

                    //Forget cache
                    Cache::forget( Banco::$key_cache );
                    return response()->json(['success' => true, 'id' => $banco->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $banco->errors]);
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
