<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Inventario\Lote, App\Models\Inventario\Producto, App\Models\Base\Sucursal, App\Models\Base\Ubicacion;

class LoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $producto = Producto::where('producto_serie', $request->producto)->first();
            if (!$producto instanceof Producto) {
                 return response()->json( 'No es posible recuperar PRODUCTO,verifique información ó por favor consulte al administrador.');
            }
            $sucursal = Sucursal::find($request->sucursal);
            if (!$sucursal instanceof Sucursal) {
                return response()->json( 'No es posible recuperar SUCURSAL,verifique información ó por favor consulte al administrador.');
            }
            $lotes = [];
            if($request->has('producto') && $request->has('sucursal')) {
                $query = Lote::select('lote.*', 'ubicacion_nombre');
                $query->where('lote_serie', $producto->id);
                $query->where('lote_sucursal', $sucursal->id);
                $query->whereRaw('lote_saldo > 0');
                $query->leftJoin('ubicacion', 'lote_ubicacion', '=', 'ubicacion.id');
                $query->orderby('lote_fecha', 'asc');
            }
            // Use in traslados de ubicación
            if ($request->has('ubicacion')) {
                $ubicacion = Ubicacion::find($request->ubicacion);
                if (!$producto instanceof Producto) {
                    return response()->json( 'No es posible recuperar UBICACIÓN de ORIGEN,verifique información ó por favor consulte al administrador.');
                }
                $query->where('lote_ubicacion', $ubicacion->id);
            }
            $lotes = $query->get();
            return response()->json($lotes);
        }
        abort(404);
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
        //
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
