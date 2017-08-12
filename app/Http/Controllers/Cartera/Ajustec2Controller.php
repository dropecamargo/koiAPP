<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Cartera\Ajustec2;
use App\Models\Base\Documentos, App\Models\Base\Tercero;
use Log, DB;

class Ajustec2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $ajustec2 = [];
            if($request->has('ajustec')) {
                $query = Ajustec2::query();
                $query->select('ajustec2.*', 'documentos_nombre','factura3_cuota','factura1_numero', 'ajustec2_valor as factura3_valor', DB::raw("(CASE WHEN tercero_persona = 'N'
                        THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                                (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                            )
                        ELSE tercero_razonsocial END)
                    AS tercero_nombre")
                );
                $query->join('tercero', 'ajustec2_tercero', '=', 'tercero.id');
                $query->join('documentos', 'ajustec2_documentos_doc', '=', 'documentos.id');
                $query->leftJoin('factura3','ajustec2_id_doc', '=', 'factura3.id');
                $query->leftJoin('factura1','factura3_factura1', '=', 'factura1.id');
                $query->where('ajustec2_ajustec1', $request->ajustec);
                $ajustec2 = $query->get();
            }
            return response()->json($ajustec2);
        }
        abort(404);
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
            $ajustec2 = new Ajustec2;
            if ($ajustec2->isValid($data)) {
                try {
                    
                    $documentos = Documentos::find($request->ajustec2_documentos_doc);
                    if(!$documentos instanceof Documentos) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar documento, verifique información ó por favor consulte al administrador.']);
                    }
                    switch ($documentos->documentos_codigo) {
                        case 'FACT':
                            $tercero = Tercero::getTercero($request->ajustec2_tercero);
                            break;
                        case 'CHD':
                            $tercero = Tercero::getTercero($request->ajustec2_tercero);
                            break;
                        case 'ANTI':
                            $tercero = Tercero::getTercero($request->ajustec2_tercero);
                            break;
                        default:
                            $tercero = Tercero::where('tercero_nit', $request->ajustec2_tercero)->first();
                            break;
                    }
                    //Recuperar Tercero
                    if(!$tercero instanceof Tercero) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el cliente, verifique información ó por favor consulte al administrador.']);
                    }
                    return response()->json(['success' => true, 'id' => uniqid(), 'documentos_nombre' => $documentos->documentos_nombre, 'tercero_nombre' => $tercero->getName()]);
                }catch(\Exception $e){
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $ajustec2->errors]);
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
