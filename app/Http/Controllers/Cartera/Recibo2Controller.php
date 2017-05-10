<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Cartera\Conceptosrc, App\Models\Cartera\Recibo1, App\Models\Cartera\Recibo2;
use App\Models\Base\Documentos;
use Log, DB;

class Recibo2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $recibo2 = [];
            if($request->has('recibo2')) {
                $query = Recibo2::query();
                $query->select('recibo2.*','conceptosrc_nombre','documentos_nombre','factura3_cuota as recibo2_cuota', 'factura1_numero as recibo2_numero');
                $query->join('conceptosrc','recibo2_conceptosrc', '=', 'conceptosrc.id');
                $query->join('documentos','recibo2_documentos_doc', '=', 'documentos.id');
                $query->leftJoin('factura3','recibo2_id_doc', '=', 'factura3.id');
                $query->leftJoin('factura1','factura3_factura1', '=', 'factura1.id');
                $query->where('recibo2_recibo1', $request->recibo2);
                $recibo2 = $query->get();
            }
            return response()->json($recibo2);
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
            $recibo2 = new Recibo2;
            if ($recibo2->isValid($data)) {
                try {
                    //Recuperar Conceptosrc-DocumentosConceptosrc
                    $conceptosrc = Conceptosrc::find($request->recibo2_conceptosrc);
                    if(!$conceptosrc instanceof Conceptosrc) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar concepto, verifique información ó por favor consulte al administrador.']);
                    }

                    $documentos = Documentos::find($conceptosrc->conceptosrc_documentos);
                    if(!$documentos instanceof Documentos) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar documento del concepto, verifique información ó por favor consulte al administrador.']);
                    }

                    return response()->json(['success' => true, 'id' => uniqid(), 'conceptosrc_nombre' => $conceptosrc->conceptosrc_nombre, 'documentos_nombre' => $documentos->documentos_nombre ,'recibo2_documentos_doc' => $documentos->id]);
                }catch(\Exception $e){
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $recibo2->errors]);
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
