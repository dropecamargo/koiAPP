<?php

namespace App\Http\Controllers\Tecnico;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Tecnico\RemRepu,App\Models\Tecnico\RemRepu2,App\Models\Tecnico\Orden;
use App\Models\Inventario\Producto;
use App\Models\Base\Sucursal,App\Models\Base\Documentos;

use Log, DB, Auth;

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
            $query->select('remrepu1.*',DB::raw("CONCAT((CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,(CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)) ELSE tercero_razonsocial END)) AS tercero_nombre"));
            $query->join('tercero', 'remrepu1_usuario_elaboro', '=', 'tercero.id');
            $query->where('remrepu1_orden',$request->orden_id);
            return response()->json($query->get());
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
        if ($request->ajax()) {
            $data = $request->all();
            $remrepu = new RemRepu;
            if ($remrepu->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recupero instancia de documentos
                    $documentos = Documentos::where('documentos_codigo', RemRepu::$default_document)->first();
                    if (!$documentos instanceof Documentos) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar documentos, por favor verifique la información o consulte al administrador.']);
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
                    $consecutive = $sucursal->sucursal_remr + 1;

                    // RemRepu
                    $remrepu->remrepu1_orden = $orden->id;
                    $remrepu->remrepu1_sucursal = $sucursal->id;
                    $remrepu->remrepu1_numero = $consecutive;
                    $remrepu->remrepu1_documentos = $documentos->id;
                    $remrepu->remrepu1_usuario_elaboro = Auth::user()->id;
                    $remrepu->remrepu1_fh_elaboro = date('Y-m-d H:m:s');
                    $remrepu->save();


                    foreach ($data['detalle'] as $value) {

                        // Recupero instancia de producto
                        $producto = Producto::where('producto_serie', $value['remrepu2_serie'])->first();
                        if(!$producto instanceof Producto) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique la información o consulte al administrador.']);
                        }
                        // Valido producto unico en la remision
                        $existente = DB::table('remrepu2')->where('remrepu2_producto', $producto->id)->where('remrepu2_remrepu1', $remrepu->id)->first();

                        if ($existente != null) {
                            DB::rollback();
                            return response()->json(['success'=> false, 'errors' => "Producto {$producto->producto_nombre} - {$producto->producto_serie} se encuentra repetido, por favor verificar información o consulte al administrador."]);
                        }
                        // Remrepu2
                        $remrepu2 = new RemRepu2;
                        $remrepu2->fill($value);
                        $remrepu2->remrepu2_remrepu1 = $remrepu->id;  
                        $remrepu2->remrepu2_producto = $producto->id;
                        $remrepu2->save();  
                    }

                    // Update sucursal_remr 
                    $sucursal->sucursal_remr = $consecutive;
                    $sucursal->save();

                    DB::commit();
                    return response()->json(['success' => true, 'id' => $remrepu->id]);
                }catch(\Exception $e){
                    DB::rollback();
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
