<?php

namespace App\Http\Controllers\Comercial;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Comercial\Pedidoc2, App\Models\Base\Sucursal, App\Models\Inventario\Producto;
use DB, Log;

class DetallePedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            $pedidoc2Detalle = Pedidoc2::getPedidoc2($request->id);
            return response()->json($pedidoc2Detalle);
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
        if ($request->ajax()) {
            $data = $request->all();
            $pedidocDetalle = new Pedidoc2;
            if ($pedidocDetalle->isValid($data)) {
                try {
                    $sucursal = Sucursal::find($request->sucursal);
                    if (!$sucursal instanceof Sucursal) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar sucursal, por favor verifique información o consulte con el administrador' ]);
                    }
                    $producto = Producto::where('producto_serie', $request->producto_serie)->first();
                    if (!$producto instanceof Producto) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique información o consulte con el administrador']);
                    }
                    $prodbode = DB::table('prodbode')->select('prodbode_cantidad')->where('prodbode_serie',$producto->id)->where('prodbode_sucursal', $sucursal->id )->first();
                    if ($prodbode->prodbode_cantidad < $request->pedidoc2_cantidad) {
                        return response()->json(['success'=> false, 'errors' => 'No existe cantidad suficiente en bodega, por favor verifique información o consulte con el administrador']);
                    }
                    return response()->json(['success' => true, 'id' => uniqid() ]);
                }catch (\Exception $e) {
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $pedidocDetalle->errors]);
        }
        abort(403);
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
