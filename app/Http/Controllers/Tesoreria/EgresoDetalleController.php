<?php

namespace App\Http\Controllers\Tesoreria;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Tesoreria\Egreso2,App\Models\Tesoreria\TipoPago;
use App\Models\Base\Documentos, App\Models\Base\Tercero;
use Log, DB;

class EgresoDetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $egreso2 = [];
            if($request->has('egreso2')) {
                $query = Egreso2::query();
                $query->select('egreso2.*','tipopago_nombre','facturap3_cuota','facturap1_numero', 'egreso2_valor as facturap3_valor', DB::raw("(CASE WHEN tercero_persona = 'N'
                        THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                                (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                            )
                        ELSE tercero_razonsocial END)
                    AS tercero2_nombre"));
                $query->join('tercero','egreso2_tercero', '=', 'tercero.id');
                $query->join('tipopago','egreso2_tipopago', '=', 'tipopago.id');
                $query->leftJoin('facturap3','egreso2_id_doc', '=', 'facturap3.id');
                $query->leftJoin('facturap1','facturap3_facturap1', '=', 'facturap1.id');
                $query->where('egreso2_egreso1', $request->egreso2);
                $egreso2 = $query->get();
            }
            return response()->json($egreso2);
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
            $egreso2 = new Egreso2;
            if ($egreso2->isValid($data)) {
                try {
                    // Recuperar tercero
                    $tercero = Tercero::orWhere('tercero_nit', $request->egreso2_tercero)->orWhere('id', $request->egreso2_tercero)->first();
                    if(!$tercero instanceof Tercero) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar tercero, verifique información ó por favor consulte al administrador.']);
                    }
                    //Recuperar TipoPago-DocumentosTipoPago
                    $tipopago = TipoPago::find($request->egreso2_tipopago);
                    if(!$tipopago instanceof TipoPago) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar tipo pago, verifique información ó por favor consulte al administrador.']);
                    }
                    if ($request->has('egreso2_valor')) {
                        if ($request->egreso2_valor <= 0 ) {
                            return response()->json(['success' => false, 'errors' => 'El valor del detalle debe ser mayor a 0, verifique información ó por favor consulte al administrador.' ]);
                        }
                    }
                    if ($tipopago->tipopago_documentos != null) {
                        $documentos = Documentos::find($tipopago->tipopago_documentos);
                        if(!$documentos instanceof Documentos) {
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar documento del tipo pago, verifique información ó por favor consulte al administrador.']);
                        }
                        return response()->json(['success' => true, 'id' => uniqid(), 'tipopago_nombre' => $tipopago->tipopago_nombre, 'documentos_nombre' => $documentos->documentos_nombre ,'egreso2_documentos_doc' => $documentos->id, 'tercero2_nombre' => $tercero->getName()]);
                    }
                    return response()->json(['success' => true, 'id' => uniqid(), 'tipopago_nombre' => $tipopago->tipopago_nombre, 'documentos_nombre' => '' ,'egreso2_documentos_doc' => '', 'tercero2_nombre' => $tercero->getName() ]);
                }catch(\Exception $e){
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $egreso2->errors]);
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
