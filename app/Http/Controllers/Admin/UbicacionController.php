<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Base\Ubicacion, App\Models\Base\Sucursal;
use Datatables,Cache,Log,DB;

class UbicacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Ubicacion::query();
            return Datatables::of($query)->make(true);
        }
        return view('admin.ubicaciones.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.ubicaciones.create');
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
            $ubicacion = new Ubicacion;
            if ($ubicacion->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recupero instancia de sucursal
                    $sucursal = Sucursal::find($request->ubicacion_sucursal);
                    if (!$sucursal instanceof Sucursal) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar sucursal, por favor verifique la información o consulte al administrador.']);
                    }
                    // Ubicacion
                    $ubicacion->fill($data);
                    $ubicacion->fillBoolean($data);
                    $ubicacion->ubicacion_sucursal = $sucursal->id;
                    $ubicacion->save();

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget( Ubicacion::$key_cache );

                    return response()->json(['success' => true, 'id' => $ubicacion->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $ubicacion->errors]);
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
        $ubicacion = Ubicacion::findOrFail($id);
        if ($request->ajax()) {
            return response()->json($ubicacion);
        }
        return view('admin.ubicaciones.show', ['ubicacion' => $ubicacion]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ubicacion = Ubicacion::findOrFail($id);
        return view('admin.ubicaciones.edit', ['ubicacion' => $ubicacion]);
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

            $ubicacion = Ubicacion::findOrFail($id);
            if ($ubicacion->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recupero instancia de sucursal
                    $sucursal = Sucursal::find($request->ubicacion_sucursal);
                    if (!$sucursal instanceof Sucursal) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar sucursal, por favor verifique la información o consulte al administrador.']);
                    }
                    // Ubicacion
                    $ubicacion->fill($data);
                    $ubicacion->fillBoolean($data);
                    $ubicacion->ubicacion_sucursal = $sucursal->id;
                    $ubicacion->save();

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget( Ubicacion::$key_cache );

                    return response()->json(['success' => true, 'id' => $ubicacion->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $ubicacion->errors]);
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
