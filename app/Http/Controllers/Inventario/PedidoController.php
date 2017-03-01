<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Inventario\Pedido1;
use App\Models\Base\Documentos, App\Models\Base\Tercero;

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
            $query->select('pedido1.*',
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
            $query->join('tercero', 'pedido1_tercero', '=', 'tercero.id');
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
                    $pedido->fill($data);
                    //$pedido->fillBoolean($data);
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

            $pedido = new Pedido1;
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
                    $pedido->fill($data);
                    //$pedido->fillBoolean($data);
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
}
