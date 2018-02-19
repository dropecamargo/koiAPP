<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Inventario\Rollo, App\Models\Inventario\Producto, App\Models\Base\Sucursal;
use DB;

class RolloController extends Controller
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
            $rollos = [];
            if($request->has('producto') && $request->has('sucursal')) {
                $query = Rollo::select('rollo.*', DB::raw('SUM(rollo_saldo) AS rollo_saldo') , DB::raw('COUNT(rollo.id) AS rollo_rollos'), 'ubicacion_nombre');
                $query->leftJoin('ubicacion', 'rollo_ubicacion', '=', 'ubicacion.id');
                $query->where( 'rollo_serie', $producto->id );
                $query->where( 'rollo_sucursal', $sucursal->id );
                $query->whereRaw('rollo_saldo > 0');
                $query->orderby('rollo_fecha', 'asc');
                $query->groupBy('rollo_saldo','rollo_ubicacion');
                $rollos = $query->get();
            }
            return response()->json($rollos);
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
