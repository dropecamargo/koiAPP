<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB, Log, Datatables, Cache;

use App\Models\Base\Sucursal;

class SucursalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Sucursal::query();
            $query->select('sucursal.id as id', 'sucursal_nombre' , 'sucursal_direccion');
            return Datatables::of($query)->make(true);
        }
        return view('admin.sucursales.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sucursales.create');
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

            $sucursal = new Sucursal;
            if ($sucursal->isValid($data)) {
                DB::beginTransaction();
                try {
                    // sucursal
                    $sucursal->fill($data);
                    $sucursal->fillBoolean($data);
                    $sucursal->save();

                    // Commit Transaction
                    DB::commit();
                    // Forget cache
                    Cache::forget( Sucursal::$key_cache );

                    return response()->json(['success' => true, 'id' => $sucursal->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $sucursal->errors]);
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
        $sucursal = Sucursal::getSucursal($id);
        // dd($id);
        if ($request->ajax()) {

            return response()->json(['sucursal_pedn'=>$sucursal->sucursal_pedn,'id'=>$sucursal->id,'sucursal_nombre'=>$sucursal->sucursal_nombre]);
        }
        return view('admin.sucursales.show', ['sucursal' => $sucursal]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sucursal = Sucursal::findOrFail($id);
        return view('admin.sucursales.edit', ['sucursal' => $sucursal]);
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

            $sucursal = Sucursal::findOrFail($id);
            if ($sucursal->isValid($data)) {
                DB::beginTransaction();
                try {
                    // sucursal
                    $sucursal->fill($data);
                    $sucursal->fillBoolean($data);
                    $sucursal->save();

                    // Commit Transaction
                    DB::commit();
                    // Forget cache
                    //Cache::forget( Sucursal::$key_cache );

                    return response()->json(['success' => true, 'id' => $sucursal->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $sucursal->errors]);
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
