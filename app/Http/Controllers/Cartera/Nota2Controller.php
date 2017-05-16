<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Cartera\ConceptoNota, App\Models\Cartera\Nota1, App\Models\Cartera\Nota2;
use App\Models\Base\Documentos;
use Log, DB;

class Nota2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $nota2 = [];
            if($request->has('nota2')) {
                $query = Nota2::query();
                $query->select('nota2.*','conceptonota_nombre','nota2_valor as factura3_valor','documentos_nombre','factura3_cuota', 'factura1_numero');
                $query->join('nota1','nota2_nota1', '=', 'nota1.id');
                $query->join('conceptonota','nota1_conceptonota', '=', 'conceptonota.id');
                $query->join('documentos','nota2_documentos_doc', '=', 'documentos.id');
                $query->join('factura3','nota2_id_doc', '=', 'factura3.id');
                $query->join('factura1','factura3_factura1', '=', 'factura1.id');
                $query->where('nota2_nota1', $request->nota2);
                $nota2 = $query->get();
            }
            return response()->json($nota2);
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
            $nota2 = new Nota2;
            try {
                //Recuperar ConceptoNota-Documentos
                $concepto = ConceptoNota::find($request->nota2_conceptonota);
                if(!$concepto instanceof ConceptoNota) {
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar concepto, verifique la información ó por favor consulte al administrador.']);
                }

                $documento = Documentos::find($request->nota2_documentos_doc);
                if(!$documento instanceof Documentos) {
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar documento, verifique la información ó por favor consulte al administrador.']);
                }

                return response()->json(['success' => true, 'id' => uniqid(), 'conceptonota_nombre' => $concepto->conceptonota_nombre, 'documentos_nombre' => $documento->documentos_nombre ]);
            }catch(\Exception $e){
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
            return response()->json(['success' => false, 'errors' => $nota2->errors]);
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
