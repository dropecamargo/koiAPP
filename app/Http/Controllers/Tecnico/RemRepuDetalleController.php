<?php

namespace App\Http\Controllers\Tecnico;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Tecnico\RemRepu2,App\Models\Tecnico\RemRepu;
use App\Models\Inventario\Producto;

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
            $remrepu2->select('remrepu2.*', 'producto_nombre AS remrepu2_nombre', 'producto_serie AS remrepu2_serie', 'remrepu1_numero', 'sucursal_nombre');
            $remrepu2->join('producto', 'remrepu2_producto','=','producto.id');
            $remrepu2->join('remrepu1', 'remrepu2_remrepu1','=','remrepu1.id');
            $remrepu2->join('sucursal', 'remrepu1_sucursal','=','sucursal.id');

            if ($request->has('remrepu2_remrepu1')) {
                $remrepu2->where('remrepu2_remrepu1', $request->remrepu2_remrepu1);
                return $remrepu2->get();
            }
            if ($request->has('orden_id')) {
                $remrepu2->whereIn('remrepu2_remrepu1', DB::table('remrepu1')->select('remrepu1.id')->where('remrepu1_orden', $request->orden_id) );
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
        if ($request->ajax()) {
            $data = $request->all();

            $remrepu2 = RemRepu2::findOrFail($request->id);
            if ($remrepu2 instanceof RemRepu2 ) {
                DB::beginTransaction();
                try {
                    $facturado = 0;

                    // Validar facturado
                    if( $request->has("facturado_{$remrepu2->id}") ){
                        $facturado = $request->get("facturado_{$remrepu2->id}");
                    }

                    // Validar facturado
                    if( $request->has("facturado_{$remrepu2->id}") ){
                        $facturado = $request->get("facturado_{$remrepu2->id}");
                    }

                    // Validar facturado
                    if( $request->has("facturado_{$remrepu2->id}") ){
                        $facturado = $request->get("facturado_{$remrepu2->id}");
                    }

                    // Validar facturado
                    if( $request->has("facturado_{$remrepu2->id}") ){
                        $facturado = $request->get("facturado_{$remrepu2->id}");
                    }

                    // $producto = Producto::where('producto_serie', $request->remrepu2_serie)->first();
                    // if(!$producto instanceof Producto) {
                    //     DB::rollback();
                    //     return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique la información o consulte al administrador.']);
                    // }   
                    return response()->json(['success' => true, 'id' => $remrepu2->id ]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $remrepu2->errors]);
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
