<?php

namespace App\Http\Controllers\Tesoreria;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Tesoreria\Ajustep2;
use App\Models\Base\Documentos, App\Models\Base\Tercero;
use Log, DB;

class AjustepDetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $ajustep2 = [];
            if($request->has('ajustep')) {
                $query = Ajustep2::query();
                $query->select('ajustep2.*', 'documentos_nombre','facturap3_cuota','facturap1_numero', 'ajustep2_valor as facturap3_valor', DB::raw("(CASE WHEN tercero_persona = 'N'
                        THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                                (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                            )
                        ELSE tercero_razonsocial END)
                    AS tercero_nombre")
                );
                $query->join('tercero', 'ajustep2_tercero', '=', 'tercero.id');
                $query->join('documentos', 'ajustep2_documentos_doc', '=', 'documentos.id');
                $query->leftJoin('facturap3','ajustep2_id_doc', '=', 'facturap3.id');
                $query->leftJoin('facturap1','facturap3_facturap1', '=', 'facturap1.id');
                $query->where('ajustep2_ajustep1', $request->ajustep);
                $ajustep2 = $query->get();
            }
            return response()->json($ajustep2);
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
            $ajustep2 = new Ajustep2;
            if ($ajustep2->isValid($data)) {
                try {
                    
                    $documentos = Documentos::find($request->ajustep2_documentos_doc);
                    if(!$documentos instanceof Documentos) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar documento, verifique información ó por favor consulte al administrador.']);
                    }
                    $tercero = Tercero::getTercero($request->ajustep2_tercero);
                    //Recuperar Tercero
                    if(!$tercero instanceof Tercero) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el proveedor, verifique información ó por favor consulte al administrador.']);
                    }
                    return response()->json(['success' => true, 'id' => uniqid(), 'documentos_nombre' => $documentos->documentos_nombre, 'tercero_nombre' => $tercero->getName()]);
                }catch(\Exception $e){
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $ajustep2->errors]);
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
