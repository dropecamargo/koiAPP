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

            if ($producto->producto_vence) {
                $query = $producto->hasMany('App\Models\Inventario\Lote', 'lote_serie', 'id')
                    ->select('lote.*','sucursal_nombre', DB::raw('SUM(lote_saldo) AS lote_saldo'),'producto_vence','ubicacion_nombre')
                    ->join('producto','lote_serie','=','producto.id')
                    ->join('sucursal','lote_sucursal','=','sucursal.id')
                    ->leftJoin('ubicacion','lote_ubicacion','=','ubicacion.id')
                    ->whereRaw('lote_saldo > 0')
                    ->groupBy('lote_sucursal','lote_ubicacion')
                    ->orderBy('lote_vencimiento','asc');
            }else if($producto->producto_metrado){
                $query = $producto->hasMany('App\Models\Inventario\Rollo', 'rollo_serie', 'id')
                    ->select('rollo.*',DB::raw('COUNT(rollo.id) AS rollo_rollos'),'sucursal_nombre', 'ubicacion_nombre', 'producto_metrado')
                    ->join('producto','rollo_serie','=','producto.id')
                    ->join('sucursal','rollo_sucursal','=','sucursal.id')
                    ->leftJoin('ubicacion','rollo_ubicacion','=','ubicacion.id')
                    ->whereRaw('rollo_saldo > 0')
                    ->groupBy('rollo_sucursal','rollo_saldo');
            }else{
                $query = Prodbode::query();
                $query->select('producto_serie','producto_nombre','producto_maneja_serie', 'producto_metrado','producto_vence','prodbode_cantidad','sucursal_nombre', 'prodbode.id', 'ubicacion_nombre');
                $query->join('producto', 'prodbode_serie', '=', 'producto.id');
                $query->join('sucursal', 'prodbode_sucursal', '=', 'sucursal.id');
                $query->leftJoin('ubicacion', 'prodbode_ubicacion', '=', 'ubicacion.id');
                $query->where('producto_referencia', $producto->producto_serie);
                $query->whereRaw('prodbode_cantidad > 0');
                
            }
            
            $query->orderBy('sucursal_nombre', 'asc');
            $prodbode = $query->get();
            return response()->json($prodbode);
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
            $prodbode = Prodbode::findOrFail($id);
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
