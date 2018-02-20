<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Inventario\Modelo, App\Models\Inventario\Marca;
use DB, Log, Datatables, Cache;

class ModeloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Modelo::query();

            if( $request->has('datatables') ) {
                $query->select('modelo.*', 'marca_nombre');
                $query->join('marca', 'modelo_marca', '=', 'marca.id');
                return Datatables::of( $query )->make(true);
            }

            // Select ajax
            if( $request->has('marca') ){
                $query->where('modelo_marca', $request->marca);
                $query->where('modelo_activo', true);
                $query->orderby('modelo_nombre','asc');
            }

            return response()->json($query->get());
        }
        return view('inventario.modelo.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventario.modelo.create');
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

            $modelo = new Modelo;
            if ($modelo->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar marca
                    $marca = Marca::find($request->modelo_marca);
                    if( !$marca instanceof Marca ){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar la marca, por favor verifique la información o consulte al administrador.']);
                    }

                    // Modelo
                    $modelo->fill($data);
                    $modelo->fillBoolean($data);
                    $modelo->modelo_marca = $marca->id;
                    $modelo->save();

                    // Commit Transaction
                    DB::commit();

                    //Forget cache
                    Cache::forget( Modelo::$key_cache );
                    return response()->json(['success' => true, 'id' => $modelo->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $modelo->errors]);
        }
        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request ,$id)
    {
        $modelo = Modelo::findOrFail($id);

        if ($request->ajax()) {
            return response()->json($modelo);
        }
        return view('inventario.modelo.show', ['modelo' => $modelo]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $modelo = Modelo::findOrFail($id);
        return view('inventario.modelo.edit', ['modelo' => $modelo]);
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

            $modelo = Modelo::findOrFail($id);
            if ($modelo->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar marca
                    $marca = Marca::find($request->modelo_marca);
                    if( !$marca instanceof Marca ){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar la marca, por favor verifique la información o consulte al administrador.']);
                    }

                    // Modelo
                    $modelo->fill($data);
                    $modelo->fillBoolean($data);
                    $modelo->modelo_marca = $marca->id;
                    $modelo->save();

                    // Commit Transaction
                    DB::commit();

                    //Forget cache
                    Cache::forget( Modelo::$key_cache );
                    return response()->json(['success' => true, 'id' => $modelo->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $modelo->errors]);
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
