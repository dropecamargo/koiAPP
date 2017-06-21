<?php

namespace App\Http\Controllers\Tecnico;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Tecnico\RemRepu,App\Models\Tecnico\Orden;
use App\Models\Inventario\Producto;
use App\Models\Base\Sucursal,App\Models\Base\Documentos;

use Log, DB;

class RemRepuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {          
            $query = RemRepu::query();
            $query->select('remrepu.*','producto.producto_referencia as remrepu_serie', 'producto.producto_nombre as remrepu_nombre');
            $query->join('producto','remrepu_producto', '=','producto.id');
            $query->where('remrepu_orden',$request->orden_id);
            return response()->json($query->get());
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
            $remrepu = new RemRepu;
            if ($remrepu->isValid($data)) {
                try {
                    // Recupero instancia de documentos
                    $documentos = Documentos::where('documentos_codigo', RemRepu::$default_document)->first();
                    if (!$documentos instanceof Documentos) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar documentos, por favor verifique la información o consulte al administrador.']);
                    }
                    // Recupero instancia de producto
                    $producto = Producto::where('producto_serie', $request->remrepu_serie)->first();
                    if(!$producto instanceof Producto) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique la información o consulte al administrador.']);
                    }   
                    // Recupero instancia de orden
                    $orden = Orden::find($request->remrepu_orden);
                    if (!$orden instanceof Orden) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar orden, por favor verifique la información o consulte al administrador.']);
                    }
                    // Recupero instancia de sucursal 
                    $sucursal  = Sucursal::find($orden->orden_sucursal);
                    if (!$sucursal instanceof Sucursal) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar sucursal, por favor verifique la información o consulte al administrador.']);
                    }
                    // Consecutive sucursal_remr
                    $consecutive = $sucursal->sucursal_remr + 1 ;

                    // RemRepu
                    $remrepu->fill($data);
                    $remrepu->remrepu_producto = $producto->id;
                    $remrepu->remrepu_orden = $orden->id;
                    $remrepu->remrepu_sucursal = $sucursal->id;
                    $remrepu->remrepu_numero = $consecutive;
                    $remrepu->remrepu_documentos = $documentos->id;
                    $remrepu->save();

                    // Update sucursal_remr 
                    $sucursal->sucursal_remr = $consecutive;
                    $sucursal->save();
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $remrepu->id]);
                }catch(\Exception $e){
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $remrepu->errors]);
        }
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
