<?php

namespace App\Http\Controllers\Tecnico;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Tecnico\RemRepu2, App\Models\Tecnico\RemRepu, App\Models\Inventario\Producto, App\Models\Tecnico\Orden;
Use Log, DB;

class RemRepuDetalleController extends Controller
{
/**
 * Display a listing of the resource.
 *
 * @return \Illuminate\Http\Response
 */
public function index(Request $request)
{
    if ($request->ajax()) {
        $remrepu2 = RemRepu2::query();
        $remrepu2->select('remrepu2.*', 'producto_nombre AS remrepu2_nombre', 'producto_serie AS remrepu2_serie', 'remrepu1_numero', 'sucursal_nombre', 'remrepu1_tipo');
        $remrepu2->join('producto', 'remrepu2_producto','=','producto.id');
        $remrepu2->join('remrepu1', 'remrepu2_remrepu1','=','remrepu1.id');
        $remrepu2->join('sucursal', 'remrepu1_sucursal','=','sucursal.id');

        if ($request->has('remrepu2_remrepu1')) {
            $remrepu2->where('remrepu2_remrepu1', $request->remrepu2_remrepu1);
            return $remrepu2->get();
        }
        if ($request->has('orden_id')) {
            $remrepu2->whereIn('remrepu2_remrepu1', DB::table('remrepu1')->select('remrepu1.id')->where('remrepu1_orden', $request->orden_id) );
            $remrepu2->where('remrepu1_tipo', 'R');
            $remrepu2->orderBy('sucursal_nombre', 'desc');
            return $remrepu2->get();
        }
    }
    abort(403);
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
            $remrepu2 = new RemRepu2;
            if ($remrepu2->isValid($data)) {
                try {
                    // Recupero instancia de producto
                    $producto = Producto::where('producto_serie', $request->remrepu2_serie)->first();
                    if(!$producto instanceof Producto) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique la información o consulte al administrador.']);
                    }   
                    return response()->json(['success' => true, 'id' => uniqid() ]);
                }catch(\Exception $e){
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $remrepu2->errors]);
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

    /**
     * update legalizacion.
     *
     * @return \Illuminate\Http\Response
     */
    public function legalizacion(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
                
            // Recuperar orden
            $orden = Orden::find($request->orden_id);
            if(!$orden instanceof Orden){
                abort(404);
            }
            
            DB::beginTransaction();
            try {

// Recuperar remrepu
$remrepu = Remrepu::where('remrepu1_orden', $orden->id)->select('remrepu1.*', 'sucursal_nombre')->where('remrepu1_tipo', 'R')->join('sucursal', 'remrepu1_sucursal', '=', 'sucursal.id')->get();
    
if( count($remrepu) <= 0){
    DB::rollback();
    return response()->json(['success' => false, 'errors' => 'No existe ningun producto para realizar una legalización.']);
}

foreach ($remrepu as $father) {

    $childs = RemRepu2::where('remrepu2_remrepu1', $father->id)->get();

    foreach ($childs as $child) {

        if($request->has("facturado_$child->id") && $request->has("nofacturado_$child->id") && $request->has("devuelto_$child->id") && $request->has("usado_$child->id") ){
            $facturado = $request->get("facturado_$child->id");
            $nofacturado = $request->get("nofacturado_$child->id");
            $devuelto = $request->get("devuelto_$child->id");
            $usado = $request->get("usado_$child->id");

            if( $facturado < 0 || $nofacturado < 0 || $devuelto < 0 || $usado < 0){
                DB::rollback();
                return response()->json(['success' => false, 'errors' => "Ningun campo puede ser negativo."]);
            }

            if( $facturado > 0 || $nofacturado > 0 || $devuelto > 0 || $usado > 0 ) {

                // la suma de cada hijo, no puede superar la cantidad disponible
                $ingreso = $facturado + $nofacturado + $devuelto + $usado;

                if( $ingreso > $child->remrepu2_saldo){
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => "Los datos ingresados en Sucursal {$father->sucursal_nombre} - Remision No. {$father->remrepu1_numero} supera la cantidad disponible, ingresado {$ingreso} disponible {$child->remrepu2_saldo}"]);
                }

                // Update childs
                if($child instanceof RemRepu2){
                    $child->remrepu2_saldo -= $ingreso;
                    $child->remrepu2_facturado += $facturado;
                    $child->remrepu2_no_facturado += $nofacturado;
                    $child->remrepu2_devuelto += $devuelto;
                    $child->remrepu2_usado += $usado;
                    $child->save();

                    // Duplicate remrepu1 
                    $result = RemRepu2::createRemisionL($child, $facturado, $nofacturado, $devuelto, $usado);
                    if($result != 'OK'){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result]);
                    }
                }
            }
        }
    }
}

                DB::rollback();
                return response()->json(['success' => false, 'errors' => '!OK Bitchesss' ]);

                // Commit transaction
                // DB::commit();

                // return response()->json(['success' => true, 'id' => $orden->id ]);
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(404);
    }
}
