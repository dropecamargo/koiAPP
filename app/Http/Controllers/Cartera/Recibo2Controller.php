<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Log, DB;

use App\Models\Cartera\Conceptosrc;
use App\Models\Cartera\Recibo1;
use App\Models\Cartera\Recibo2;
use App\Models\Base\Documentos;

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
                $query->select('recibo2.*','conceptosrc_nombre','conceptosrc_documentos');
                $query->join('conceptosrc','recibo2_conceptosrc', '=', 'conceptosrc.id');
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

                    return response()->json(['success' => true, 'id' => uniqid(), 'conceptosrc_nombre' => $conceptosrc->conceptosrc_nombre]);
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
