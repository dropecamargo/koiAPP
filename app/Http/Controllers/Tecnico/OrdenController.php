<?php

namespace App\Http\Controllers\Tecnico;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Tecnico\Orden;
use App\Models\Inventario\Producto;
use App\Models\Base\Tercero,App\Models\Base\Documentos,App\Models\Base\Sucursal;

use DB, Log, Datatables, Auth;

class OrdenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $query = Orden::query();
            $query->select('orden.*',
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
            $query->join('tercero', 'orden_tercero', '=', 'tercero.id');

           // Persistent data filter
            if($request->has('persistent') && $request->persistent) {
                session(['searchorden_orden_id' => $request->has('id') ? $request->id : '']);
                session(['searchorden_tercero' => $request->has('tercero_nit') ? $request->tercero_nit : '']);
                session(['searchorden_tercero_nombre' => $request->has('tercero_nombre') ? $request->tercero_nombre : '']);
            }

            return Datatables::of($query)
                ->filter(function($query) use($request) {

                    //id Orden
                    if($request->has('id')){
                        $query->where('orden.id',$request->id);
                    }
                    // Tercero nit
                    if($request->has('tercero_nit')) {
                        $query->where('tercero_nit', $request->tercero_nit);
                    }

                    // Estado
                    if($request->has('orden_abierta')) {
                        if($request->orden_abierta == 'A') {
                            $query->where('orden_abierta', true);
                        }
                        if($request->orden_abierta == 'C') {
                            $query->where('orden_abierta', false);
                        }
                        /*if($request->orden_abierta == 'N') {
                            $query->where('orden_anulada', true);
                        }*/
                    }
                })
                ->make(true);
        }
        return view ('tecnico.orden.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tecnico.orden.create');
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
            $orden = new Orden;
            if ($orden->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recupero instancia de Documento  
                    $documento = Documentos::where('documentos_codigo' , Orden::$default_document)->first();
                    if (!$documento instanceof Documentos) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar documentos,por favor verifique la información ó por favor consulte al administrador.']);
                    }
                    // Recupero instancia de sucursal
                    $sucursal = Sucursal::find($request->orden_sucursal);
                    if (!$sucursal instanceof Sucursal) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar sucursal,por favor verifique la información ó por favor consulte al administrador.']);
                    }
                    // Recupero instancia del producto
                    $producto = Producto::where('producto_serie', $request->orden_serie)->first();
                    if(!$producto instanceof Producto) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique la información o consulte al administrador.']);
                    }
                    // Recupero instancia Tercero(Tecnico)
                    $tecnico = Tercero::where('tercero_nit', $request->orden_tecnico)->first();
                    if(!$tecnico instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar datos del tecnico, por favor verifique la información o consulte al administrador.']);
                    }
                    // Recupero instancia Tercero(cliente)
                    $tercero = Tercero::where('tercero_nit', $request->orden_tercero)->first();
                    if(!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar datos del cliente, por favor verifique la información o consulte al administrador.']);
                    }

                    // Consecutive sucursal_ord
                    $consecutive = $sucursal->sucursal_ord + 1;

                    // Orden
                    $orden->fill($data);
                    $orden->orden_fh_servicio = "$request->orden_fecha_servicio $request->orden_hora_servicio";
                    $orden->orden_sucursal = $sucursal->id;
                    $orden->orden_numero = $consecutive;
                    $orden->orden_serie = $producto->id;
                    $orden->orden_tercero = $tercero->id;
                    $orden->orden_tecnico = $tecnico->id;
                    $orden->orden_documentos = $documento->id;
                    $orden->orden_usuario_elaboro = Auth::user()->id;
                    $orden->orden_fh_elaboro = date('Y-m-d H:m:s');
                    $orden->save();

                    // Update sucursal_ord
                    $sucursal->sucursal_ord = $consecutive;
                    $sucursal->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $orden->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $orden->errors]);
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
        $orden = Orden::getOrden($id);
        if($request->ajax()){
            return response()->json($orden);
        }
        return view('tecnico.orden.show',['orden' => $orden]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $orden = Orden::getOrden($id);
        if(!$orden instanceof Orden) {
            abort(404);
        }
        return view('tecnico.orden.edit', ['orden' => $orden]);  
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
        if( $request->ajax() ) {
            $data = $request->all();
            $orden = Orden::findOrFail($id);
            if( $orden->isValid($data) ) {
                DB::beginTransaction();
                try {
                    $tercero = Tercero::where('tercero_nit', $request->orden_tercero)->first();
                    $producto = Producto::where('producto_serie', $request->orden_serie)->first();
                    $tecnico = Tercero::where('tercero_nit', $request->orden_tecnico)->first();
                   
                    if(!$producto instanceof Producto ) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique la información o consulte al administrador.']);
                    } 

                    $tipo= Tipo::where('id', $producto->producto_tipo)->first();
                    if(!$tipo instanceof Tipo ) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar tipo, por favor verifique la información o consulte al administrador.']);
                    }

                    if(!in_array($tipo->tipo_codigo, ['EQ'])){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar tipo, por favor verifique la información o consulte al administrador.']);  
                    }

                    if(!$tecnico instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar tecnico, por favor verifique la información o consulte al administrador.']);
                    }

                    if(!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cliente, por favor verifique la información o consulte al administrador.']);
                    }

                    if($tercero->id != $producto->producto_tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'El producto no corresponde al cliente, por favor verifique la información o consulte al administrador.']);
                    }

                    // ordenes
                    $orden->orden_fh_servicio = "$request->orden_fecha_servicio $request->orden_hora_servicio";
                    $orden->orden_placa = $producto->id;
                    $orden->orden_tercero = $tercero->id;
                    $orden->orden_tecnico = $tecnico->id;
                    $orden->orden_usuario_elaboro = Auth::user()->id;
                    $orden->orden_fecha_elaboro =  date('Y-m-d H:m:s');
                    $orden->save();

                    // Commit Transaction
                    DB::commit();                    
                    return response()->json(['success' => true, 'id' => $orden->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $orden->errors]);
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
            $orden = Orden::findOrFail($id);
            DB::beginTransaction();
            try {
                // Orden
                $orden->orden_abierta = false;
                $orden->orden_usuario_cerro = Auth::user()->id;
                $orden->orden_fh_cerro = date('Y-m-d H:m:s');
                $orden->save();

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'msg' => 'Orden cerrada con exito.']);
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
