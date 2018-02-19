<?php

namespace App\Http\Controllers\Tesoreria;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Tesoreria\Facturap4, App\Models\Contabilidad\CentroCosto;
use Log;

class Facturap4Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $facturap4 = new Facturap4;
            return response()->json($facturap4->getFacturap4($request->id));
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
            $facturap4 = new Facturap4;
            $data = $request->all();
            if ($facturap4->isValid($data)) {
                try {
                    // Recuperar centro costo
                    $centroCosto = CentroCosto::find($request->facturap4_centrocosto);
                    if (!$centroCosto instanceof CentroCosto) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar centro costo, por favor verifique la información del asiento o consulte al administrador.']);
                    }

                    return response()->json([ 'success' => true, 'id' => uniqid(), 'centrocosto_nombre' => $centroCosto->centrocosto_nombre]);
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $facturap4->errors]);
        }
        abort(404);
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
