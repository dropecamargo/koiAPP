<?php

namespace App\Http\Controllers\Comercial;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Comercial\AutorizaComercial, App\Models\Comercial\Pedidoc1, App\Models\Comercial\Pedidoc2;
use DB, Log, Auth;

class AutorizaComercialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            $authorization = [];

            $query = AutorizaComercial::query();
            $query->select('autorizaco.id as item','autorizaco_observaciones as observaciones', 'username as user', 'autorizaco_fh_aprobo as fecha');
            $query->join('pedidoc2', 'autorizaco_pedidoc2', '=', 'pedidoc2.id');
            $query->join('tercero', 'autorizaco_usuario_aprobo', '=', 'tercero.id');
            $query->where('pedidoc2_pedidoc1', $request->id);
            $authorization = $query->get();
            return response()->json($authorization);
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
            $authComercial = new AutorizaComercial;
            if ($authComercial->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Pedido
                    $pedidoc1 = Pedidoc1::findOrFail($request->id);
                    if (!$pedidoc1 instanceof Pedidoc1) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar pedido comercial, por favor verifique información o consulte al administrador']);
                    }

                    // Pedido Detalle
                    $query = Pedidoc2::query();
                    $query->select('pedidoc2.*', 'linea_margen_nivel1', 'linea_margen_nivel2', 'linea_margen_nivel3');
                    $query->join('linea', 'pedidoc2_linea', '=', 'linea.id');
                    $query->where('pedidoc2_pedidoc1', $pedidoc1->id);
                    $pedidoc2 = $query->get();

                    // Number autorizacion
                    $number = uniqid();

                    // Autorizacion comercial
                    foreach ($pedidoc2 as $value) {
                        $authorization = new AutorizaComercial;
                        $authorization->fill($data);
                        $authorization->autorizaco_numero = $number;
                        $authorization->autorizaco_pedidoc2 = $value->id;
                        $authorization->autorizaco_producto = $value->pedidoc2_producto;
                        $authorization->autorizaco_linea = $value->pedidoc2_linea;
                        $authorization->autorizaco_margen1 = $value->linea_margen_nivel1;
                        $authorization->autorizaco_margen2 = $value->linea_margen_nivel2;
                        $authorization->autorizaco_margen3 = $value->linea_margen_nivel2;
                        $authorization->autorizaco_usuario_aprobo =  Auth::user()->id;
                        $authorization->autorizaco_fh_aprobo =  date('Y-m-d H:m:s');
                        $authorization->save();
                    }

                    // Update pedido1
                    $pedidoc1->pedidoc1_autorizacion_co = $number;
                    $pedidoc1->save();

                    DB::commit();
                    return response()->json(['success' => true, 'msg' => 'Pedido comercial anulado con exito.', 'id' => $request->id]);
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $authComercial->errors]);
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
