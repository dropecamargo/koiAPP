<?php

namespace App\Http\Controllers\Cobro;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Cobro\DocumentoCobro, App\Models\Cobro\Deudor;
use DB;

class DocumentoCobroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $detalle = [];
            if( $request->has('deudor_id') ){
                $detalle = DocumentoCobro::select('documentocobro.*', DB::raw("DATEDIFF(documentocobro_vencimiento, NOW() ) as days"))->where('documentocobro_deudor', $request->deudor_id)->orderBy('documentocobro_vencimiento', 'desc')->get();
            }

            if( $request->has('tercero_id') && $request->has('deudor_nit') ){
                // Recuperar deudor
                $deudor = Deudor::where('deudor_tercero', $request->tercero_id)->where('deudor_nit', $request->deudor_nit)->first();
                if($deudor instanceof Deudor){
                    $detalle = DocumentoCobro::select('documentocobro.*', DB::raw("DATEDIFF(documentocobro_vencimiento, NOW() ) as days"))->where('documentocobro_deudor', $deudor->id)->orderBy('documentocobro_vencimiento', 'desc')->get();
                }
            }
            return response()->json($detalle);
        }
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
        //
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
