<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Cartera\Anticipo2,App\Models\Cartera\Banco,App\Models\Cartera\MedioPago;

use DB, Log;

class Anticipo2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $anticipo2 = [];
            if ($request->has('anticipo2')) {
                $query = Anticipo2::query();
                $query->select('anticipo2.*', 'mediopago_nombre as mediopago', 'banco_nombre as banco');
                $query->join('mediopago', 'anticipo2_mediopago', '=', 'mediopago.id');
                $query->Leftjoin('banco', 'anticipo2_banco_medio', '=', 'banco.id');
                $query->where('anticipo2_anticipo1', $request->anticipo2);
                $anticipo2 = $query->get();
            }
            return response()->json($anticipo2);
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
            $anticipo2 = new Anticipo2;
            if ($anticipo2->isValid($data)) {
                try {
                    $mediopago = MedioPago::find($request->anticipo2_mediopago);
                    if (!$mediopago instanceof MedioPago) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar medio de pago, verifique información ó por favor consulte al administrador.']);
                    }
                    if ($request->has('anticipo2_banco_medio')) {
                        $banco = Banco::find($request->anticipo2_banco_medio);
                        if (!$banco instanceof Banco) {
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar banco, verifique información ó por favor consulte al administrador.']);
                        }
                        return response()->json(['success' => true, 'id' => uniqid() , 'mediopago' => $mediopago->mediopago_nombre, 'banco' =>  $banco->banco_nombre]);
                    }
                    return response()->json(['success' => true, 'id' => uniqid() , 'mediopago' => $mediopago->mediopago_nombre, 'banco'=> '']);
                    
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
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
