<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Cartera\Conceptosrc, App\Models\Cartera\ChposFechado1, App\Models\Cartera\ChposFechado2;
use App\Models\Base\Documentos;
use Log, DB;

class ChposFechado2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $chposfechado2 = [];
            if($request->has('chposfechado2')) {
                $query = ChposFechado2::query();
                $query->select('chposfechado2.*','conceptosrc_nombre','documentos_nombre','factura3_cuota','factura1_numero', 'chposfechado2_valor as factura3_valor');
                $query->join('conceptosrc','chposfechado2_conceptosrc', '=', 'conceptosrc.id');
                $query->join('documentos','chposfechado2_documentos_doc', '=', 'documentos.id');
                $query->leftJoin('factura3','chposfechado2_id_doc', '=', 'factura3.id');
                $query->leftJoin('factura1','factura3_factura1', '=', 'factura1.id');
                $query->where('chposfechado2_chposfechado1', $request->chposfechado2);
            }
            if ($request->has('tercero')) {
                $query = ChposFechado1::select('chposfechado1.id as id_cheque', 'chposfechado1_ch_fecha','chposfechado1_ch_numero','banco_nombre','banco.id as id_banco','chposfechado1_valor');
                $query->join('banco','chposfechado1_banco', '=','banco.id');
                $query->where('chposfechado1_activo', true);
                $query->where('chposfechado1_tercero', $request->tercero)->where('chposfechado1_sucursal', $request->sucursal);
            }
            $chposfechado2 = $query->get();
            return response()->json($chposfechado2);
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
            $cheque2 = new ChposFechado2;
            if ($cheque2->isValid($data)) {
                DB::beginTransaction();
                try {
                    //Recuperar Conceptosrc-DocumentosConceptosrc
                    $conceptosrc = Conceptosrc::find($request->chposfechado2_conceptosrc);
                    if(!$conceptosrc instanceof Conceptosrc) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar concepto, verifique información ó por favor consulte al administrador.']);
                    }

                    $documentos = Documentos::find($conceptosrc->conceptosrc_documentos);
                    if(!$documentos instanceof Documentos) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar documento del concepto, verifique información ó por favor consulte al administrador.']);
                    }

                    return response()->json(['success' => true, 'id' => uniqid(), 'conceptosrc_nombre' => $conceptosrc->conceptosrc_nombre, 'documentos_nombre' => $documentos->documentos_nombre ,'chposfechado2_documentos_doc' => $documentos->id]);
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
                return response()->json(['success' => false, 'errors' => $cheque2->errors]);
            }
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
