<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Cartera\Recibo3,App\Models\Cartera\Banco,App\Models\Cartera\MedioPago;
use Log, DB;

class Recibo3Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $recibo3 = [];
            if ($request->has('recibo3')) {
                $query = Recibo3::query();
                $query->select('recibo3.*', 'mediopago_nombre as mediopago', 'banco_nombre as banco');
                $query->join('mediopago', 'recibo3_mediopago', '=', 'mediopago.id');
                $query->Leftjoin('banco', 'recibo3_banco_medio', '=', 'banco.id');
                $query->where('recibo3_recibo1', $request->recibo3);
                $recibo3 = $query->get();
            }
            return response()->json($recibo3);
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
            $recibo3 = new Recibo3;
            if ($recibo3->isValid($data)) {
                try {

                    $mediopago = MedioPago::find($request->recibo3_mediopago);
                    if (!$mediopago instanceof MedioPago) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar medio de pago, verifique información ó por favor consulte al administrador.']);
                    }
                    if ($request->has('recibo3_banco_medio')) {
                        $banco = Banco::find($request->recibo3_banco_medio);
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
