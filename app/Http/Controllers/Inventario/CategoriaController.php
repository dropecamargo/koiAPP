<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Inventario\Categoria, App\Models\Inventario\Linea;
use DB, Log, Datatables, Cache;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Categoria::query();

            // Return Datatable
            if ($request->has('datatables')) {
                return Datatables::of($query)->make(true);
            }

            // Return Json in select2 product
            if ($request->has('product')) {
                $categories = [];
                $query->select('categoria.id' , 'categoria_nombre AS name');
                $query->where('categoria_linea', $request->id);
                $categories = $query->get();
                return response()->json($categories);
            }
        }
        return view('inventario.categoria.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventario.categoria.create');
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
            $categoria = new Categoria;
            if ($categoria->isValid($data)) {
                DB::beginTransaction();
                try {

                    // Recuperar linea
                    $linea = Linea::find($request->categoria_linea);
                    if (! $linea instanceof Linea) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar LINEA por favor verifique información o consulte con el administrador']);
                    }

                    //Categoria
                    $categoria->fill($data);
                    $categoria->fillBoolean($data);
                    $categoria->categoria_linea =  $linea->id;
                    $categoria->save();

                    // Commit Transaction
                    DB::commit();

                    //Forget cache
                    Cache::forget( Categoria::$key_cache );
                    return response()->json(['success' => true, 'id' => $categoria->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $categoria->errors]);
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
        $categoria = Categoria::getCategoria($id);
        if ($request->ajax()) {
            return response()->json($categoria);
        }
        return view('inventario.categoria.show', ['categoria' => $categoria]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('inventario.categoria.edit', ['categoria' => $categoria]);
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
            $categoria = Categoria::findOrFail($id);
            if ($categoria->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar linea
                    $linea = Linea::find($request->categoria_linea);
                    if (! $linea instanceof Linea) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar LINEA por favor verifique información o consulte con el administrador']);
                    }

                    // Categoria
                    $categoria->fill($data);
                    $categoria->fillBoolean($data);
                    $categoria->categoria_linea =  $linea->id;
                    $categoria->save();

                    // Commit Transaction
                    DB::commit();

                    //Forget cache
                    Cache::forget( Categoria::$key_cache );
                    return response()->json(['success' => true, 'id' => $categoria->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $categoria->errors]);
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
