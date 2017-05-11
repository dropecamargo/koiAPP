<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Inventario\Prodbode, App\Models\Inventario\Producto;
use DB, Log;

class ProdbodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $producto = Producto::find($request->producto_id);
            if(!$producto instanceof Producto){
                return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique la información ó consulte al administrador.']);
            }

            $query = Prodbode::query();
            $query->join('producto', 'prodbode.prodbode_serie', '=', 'producto.id');
            $query->join('sucursal', 'prodbode.prodbode_sucursal', '=', 'sucursal.id');
            if ($request->has('sucursal')) {
                $query->where('prodbode_sucursal', $request->sucursal)->where('prodbode_cantidad' ,'>', 0);
            }
            $query->where('producto_referencia', $producto->producto_serie);
            $query->select('producto_serie','producto_nombre', 'sucursal_nombre','producto.id');
            return response()->json(['success' => true, 'series' => $query->get()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            $prodbode = ProdBode::findOrFail($id);
            DB::beginTransaction();
            try {
                // Producto
                $prodbode->prodbode_ubicacion1 = $request->data['prodbode_ubicacion1'];
                $prodbode->save();

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'id' => $prodbode->id]);
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
            return response()->json(['success' => false, 'errors' => $prodbode->errors]);
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
