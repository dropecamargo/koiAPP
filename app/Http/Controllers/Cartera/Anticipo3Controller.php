<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Cartera\Anticipo3, App\Models\Cartera\Conceptosrc;
use App\Models\Base\Documentos;
use DB, Log;

class Anticipo3Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if($request->has('anticipo3')) {
                $query = Anticipo3::query();
                $query->select('anticipo3.*','conceptosrc_nombre');
                $query->join('conceptosrc','anticipo3_conceptosrc', '=', 'conceptosrc.id');
                $query->where('anticipo3_anticipo1', $request->anticipo3);
                $anticipo3 = $query->get();
            }
            return response()->json($anticipo3);
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
            $anticipo3 = new Anticipo3;
            if ($anticipo3->isValid($data)) {
                try {
                    
                    if($request->anticipo3_naturaleza == 'C'){
                        $total = $request->anticipo3_valor;
                        if ($request->has('total')) {
                            $total = $request->total + $request->anticipo3_valor;
                        }
                        // Debito - Creditos
                        if ( ($request->valor - $total) <= 0 ) {
                            return response()->json(['success' => false, 'errors' => 'Valor de medio de pago MENOS valor de concepto no puede ser MENOR a 0, verifique información ó por favor consulte al administrador.']);
                        }
                    }
                    //Recuperar Conceptosrc-DocumentosConceptosrc
                    $conceptosrc = Conceptosrc::find($request->anticipo3_conceptosrc);
                    if(!$conceptosrc instanceof Conceptosrc) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar concepto, verifique información ó por favor consulte al administrador.']);
                    }
                    return response()->json(['success' => true, 'id' => uniqid(), 'conceptosrc_nombre' => $conceptosrc->conceptosrc_nombre ]);
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $anticipo3->errors]);
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
