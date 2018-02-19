<?php

namespace App\Http\Controllers\Tesoreria;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller, App\Models\Tesoreria\ReteFuente;
use DB, Log, Datatables, Cache;

class ReteFuenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = ReteFuente::query();
            return Datatables::of($query)->make(true);
        }
        return view('tesoreria.retefuente.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tesoreria.retefuente.create');
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
            $retefuente = new ReteFuente;
            if ($retefuente->isValid($data)) {
                DB::beginTransaction();
                try {
                    // ReteFuente
                    $retefuente->fill($data);
                    $retefuente->fillBoolean($data);
                    $retefuente->save();

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget( ReteFuente::$key_cache );
                    return response()->json(['success' => true, 'id' =>$retefuente->id]);
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $retefuente->errors]);
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
        $retefuente = ReteFuente::find($id);
        if ($request->ajax()) {
            return response()->json($retefuente);
        }
        return view('tesoreria.retefuente.show', ['retefuente' => $retefuente]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $retefuente = ReteFuente::findOrFail($id);
        return view('tesoreria.retefuente.edit', ['retefuente' => $retefuente]);
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
            $retefuente = ReteFuente::findOrFail($id);
            if ($retefuente->isValid($data)) {
                DB::beginTransaction();
                try {
                    // ReteFuente
                    $retefuente->fill($data);
                    $retefuente->fillBoolean($data);
                    $retefuente->save();

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget( ReteFuente::$key_cache );
                    return response()->json(['success' => true, 'id' =>$retefuente->id]);
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $retefuente->errors]);
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
