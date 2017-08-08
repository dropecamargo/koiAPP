<?php

namespace App\Http\Controllers\Tesoreria;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Tesoreria\Facturap2, App\Models\Tesoreria\Facturap1, App\Models\Tesoreria\ReteFuente;
use App\Models\Inventario\Impuesto;
use App\Models\Base\Tercero;
use DB, Log, Datatables, Cache;

class Facturap2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
         $facturapDetalle = Facturap2::getFacturap2($request->id);
         return response()->json($facturapDetalle);
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
            $facturapDetalle = new Facturap2;
            $data = $request->all();
            if ($facturapDetalle->isvalid($data)) {
                try {
                    $retefuente = [];
                    $impuesto = [];
                    if ($request->has('facturap2_base_impuesto')) {
                        $impuesto = Impuesto::find($request->facturap2_impuesto);
                        if (!$impuesto instanceof Impuesto) {
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar impuesto, por favor verifique la información o consulte al administrador']);
                        }
                        $facturapDetalle->facturap2_base = $request->facturap2_base_impuesto;
                        $facturapDetalle->facturap2_porcentaje = $impuesto->impuesto_porcentaje;
                    }
                    if ($request->has('facturap2_base_retefuente')) {
                        // Recupero tercero para saber tipo de persona
                        $tercero = Tercero::where('tercero_nit', $request->facturap1['facturap1_tercero'])->first();
                        if (!$tercero instanceof Tercero) {
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar tercero, por favor verifique la información o consulte al administrador']);

                        }
                        $retefuente = ReteFuente::find($request->facturap2_retefuente);
                        if (!$retefuente instanceof ReteFuente) {
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar retefuente, por favor verifique la información o consulte al administrador']);
                        }
                        $facturapDetalle->facturap2_base = $request->facturap2_base_retefuente;
                        $facturapDetalle->facturap2_porcentaje = ($tercero->tercero_persona == 'N') ? $retefuente->retefuente_tarifa_natural : $retefuente->retefuente_tarifa_juridico;
                    }
                    return response()->json([ 'success' => true, 'id' => uniqid(),'impuesto_nombre' => (empty($impuesto)) ? null : $impuesto->impuesto_nombre , 'retefuente_nombre' => empty($retefuente) ? null : $retefuente->retefuente_nombre, 'facturap2_base' => $facturapDetalle->facturap2_base , 'facturap2_porcentaje' => $facturapDetalle->facturap2_porcentaje ]);           
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $facturapDetalle->errors]);
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
