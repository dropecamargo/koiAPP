<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Inventario\Pedido2, App\Models\Inventario\Producto;
use DB,Log;
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
         $pedidoDetalle = pedido2::getPedido2($request->pedido_id);
         return response()->json($pedidoDetalle);
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
            $detallePedido = new Pedido2;
            if ($detallePedido->isValid($data)) {
                DB::beginTransaction();
                try {
                    //Validar Producto
                    $producto = Producto::query()->where('producto_serie',$request->producto_pedido2)->first();
                    if (!$producto instanceof Producto ) {
                        DB::rollBack();
                        return response()->json(['success' => false,'errors' => 'No es posible recuperar producto, por favor verifique la información o consulte al administrador.']);
                    }
                    $detallePedido->fill($data);
                    $detallePedido->pedido2_pedido1 = $request->pedido2_pedido1;
                    $detallePedido->pedido2_serie = $producto->id;
                    $detallePedido->save();
                    DB::commit();
                    return response()->json(['success' => true, 'producto_serie'=>$producto->producto_serie,'producto_nombre'=>$producto->producto_nombre, 'pedido_cantidad'=>$detallePedido->pedido2_cantidad,'pedido_precio'=>$detallePedido->pedido2_precio,'id' => $detallePedido->id]);
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $detallePedido->errors]);
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
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            DB::beginTransaction();
            try {

                $pedido2 = Pedido2::find($id);
                if(!$pedido2 instanceof Pedido2){
                    return response()->json(['success' => false, 'errors' => 'No es posible definir pedido, por favor verifique la información del pedido o consulte al administrador.']);
                }
                
                // Eliminar item asiento2
                $pedido2->delete();

                DB::commit();
                return response()->json(['success' => true]);

            }catch(\Exception $e){
                DB::rollback();
                Log::error(sprintf('%s -> %s: %s', 'DetallePedidoController', 'destroy', $e->getMessage()));
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);    }
}
