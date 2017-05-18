<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Cartera\Factura3,App\Models\Cartera\Factura1;
use App\Models\Base\Tercero;
use DB;

class Factura3Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $query = Factura3::query();
            if ($request->has('tercero')) {
                $tercero = Tercero::find($request->tercero);
                if(!$tercero instanceof Tercero){
                    return response()->json(['success' => false, 'errors' => 'No se pudo recuperar el cliente, por favor verifique la informacion o consulte al administrador']);
                }
                $query->select('factura3.*','factura1_documentos','factura1_tercero','factura1_numero','factura1_fh_elaboro','factura1_prefijo','factura3_vencimiento','documentos_nombre', 
                            DB::raw("DATEDIFF(factura3_vencimiento, NOW() ) as days"));
                $query->join('factura1', 'factura3_factura1', '=', 'factura1.id');
                $query->join('documentos', 'factura1_documentos', '=', 'documentos.id');
                $query->where('factura1_tercero', $tercero->id);
            }

            if ($request->has('factura1')) {
                $factura1 = Factura1::find($request->factura1);
                if (!$factura1 instanceof Factura1) {
                    return response()->json(['success' => false, 'errors' => 'No se pudo recuperar el factura1, por favor verifique la informacion o consulte al administrador']);
                }
                $query->where('factura3_factura1', $factura1->id);
            }
            $query->where('factura3_saldo', '<>',  0);
            $query->orderBy('factura3_vencimiento', 'desc');
            $factura = $query->get();

        }
        return response()->json($factura);
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
