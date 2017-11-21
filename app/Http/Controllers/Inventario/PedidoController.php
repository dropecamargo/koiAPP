<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Inventario\Pedido1, App\Models\Inventario\Pedido2, App\Models\Inventario\Producto;
use App\Models\Base\Documentos, App\Models\Base\Tercero,App\Models\Base\Sucursal,App\Models\Base\Bitacora;

use DB, Log, Datatables, Cache, Auth;


class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         if ($request->ajax()) {
            $query = Pedido1::query();
            $query->select('pedido1.*','tercero_nit', 'tercero_razonsocial', 'tercero_nombre1', 'tercero_nombre2', 'tercero_apellido1', 'tercero_apellido2','sucursal_nombre',
                DB::raw("
                    CONCAT(
                        (CASE WHEN tercero_persona = 'N'
                            THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                                (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                            )
                            ELSE tercero_razonsocial
                        END)

                    ) AS tercero_nombre"
                )
            );
            $query->join('tercero', 'pedido1.pedido1_tercero', '=', 'tercero.id');
            $query->join('sucursal', 'pedido1.pedido1_sucursal', '=', 'sucursal.id');
            $query->orderBy('pedido1.id', 'desc');
            return Datatables::of($query)->make(true);
        }

        return view('inventario.pedidos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventario.pedidos.create');
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
            $pedido = new Pedido1;
            if ($pedido->isValid($data)) {
                DB::beginTransaction();
                try {

                    //valida Documentos
                    $documento = Documentos::where('documentos_codigo', Pedido1::$default_document)->first();
                    if(!$documento instanceof Documentos) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar documentos, por favor consulte al administrador.']);
                    }
                    //recupera sucursal
                    $sucursal = Sucursal::where('id', $request->pedido1_sucursal)->first();
                     if(!$sucursal instanceof Sucursal) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar sucursal, por favor consulte al administrador.']);
                    }
                    //valida Tercero
                    $tercero = Tercero::where('tercero_nit', $request->pedido1_tercero)->first();
                    if(!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar tercero, por favor verifique información o consulte al administrador.']);
                    }


                    $consecutive = $sucursal->sucursal_pedn + 1;
                    // Pedido
                    $pedido->fill($data);
                    $pedido->pedido1_numero = $consecutive;
                    $pedido->pedido1_documentos = $documento->id;
                    $pedido->pedido1_tercero = $tercero->id;
                    $pedido->pedido1_usuario_elaboro = Auth::user()->id;
                    $pedido->pedido1_fh_elaboro = date('Y-m-d H:m:s');
                    $pedido->save();

                    //Pedido2
                    $pedidoDetalle = new Pedido2;
                    $detalle = [];
                    $detalle['Producto'] = $request->producto_pedido2;
                    $detalle['Pedido'] = $pedido->id;
                    $detalle['Cantidad'] =  $request->pedido2_cantidad;
                    $detalle['Precio'] =  $request->pedido2_precio;

                    $result = $pedidoDetalle->storePedido2($detalle);
                    if(!$result->success) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result->error]);
                    }

                    //update sucursal_pedn in Sucursal
                    $sucursal->sucursal_pedn = $consecutive;
                    $sucursal->save();

                    // Commit Transaction
                    DB::commit();

                    return response()->json(['success' => true, 'pedido_id' => $pedido->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $pedido->errors]);
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

        $pedido = Pedido1::getPedido($id);
        if(!$pedido instanceof Pedido1) {
            abort(404);
        }
         if($request->ajax()) {
            return response()->json($pedido);
        }
        return view('inventario.pedidos.show', ['pedido1' => $pedido]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pedido = Pedido1::getPedido($id);

        if(!$pedido instanceof Pedido1) {
            abort(404);
        }


        return view('inventario.pedidos.edit', ['pedido1' => $pedido]);
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
            $pedido = Pedido1::findOrFail($id);
            if ($pedido->isValid($data)) {
                DB::beginTransaction();
                try {
                    //valida Documentos
                    $documento = Documentos::query()->where('documentos_codigo', Pedido1::$default_document)->first();
                    if(!$documento instanceof Documentos) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar documentos, por favor consulte al administrador.']);
                    }
                    //valida Tercero
                    $tercero = Tercero::query()->where('tercero_nit', $request->pedido1_tercero)->first();
                    if(!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar tercero, por favor verifique información o consulte al administrador.']);
                    }
                    // Pedidos
                    $pedido->bitacora($pedido,$data,$documento->id);
                    $pedido->fill($data);
                    $pedido->pedido1_documentos = $documento->id;
                    $pedido->pedido1_tercero = $tercero->id;
                    $pedido->pedido1_usuario_elaboro = Auth::user()->id;
                    $pedido->pedido1_fh_elaboro = date('Y-m-d H:m:s');
                    $pedido->save();


                    // Commit Transaction
                    DB::commit();

                    return response()->json(['success' => true, 'id' => $pedido->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $pedido->errors]);
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

    /**
     * Cerrar the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cerrar(Request $request, $id)
    {
        if ($request->ajax()) {
            $pedido = Pedido1::findOrFail($id);
            DB::beginTransaction();
            try {
                // Pedido
                $pedido->pedido1_cerrado = true;
                $pedido->save();

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'msg' => 'Pedido cerrado con exito.']);
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }

    /**
     * Cancelar the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function anular(Request $request, $id)
    {
        if ($request->ajax()) {
            $pedido = Pedido1::findOrFail($id);
            DB::beginTransaction();
            try {
                // Pedido
                $pedido->pedido1_anulado = true;
                $pedido->save();

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'msg' => 'Pedido Anulado con exito.']);
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
