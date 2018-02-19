<?php

namespace App\Http\Controllers\Tesoreria;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Tesoreria\Facturap3,App\Models\Tesoreria\Facturap1, App\Models\Base\Tercero;
use DB;

class Facturap3Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){

            $query = Facturap3::query();
            if ($request->has('tercero')) {
                $tercero = Tercero::find($request->tercero);
                if(!$tercero instanceof Tercero){
                    return response()->json(['success' => false, 'errors' => 'No se pudo recuperar el cliente, por favor verifique la informacion o consulte al administrador']);
                }
                $query->select('facturap3.*','facturap1_numero','facturap1_fecha','regional_nombre','documentos_nombre','documentos_codigo','tipoproveedor_nombre',DB::raw("DATEDIFF(facturap3_vencimiento, NOW() ) as days"));

                $query->join('facturap1', 'facturap3_facturap1', '=', 'facturap1.id');
                $query->join('documentos', 'facturap1_documentos', '=', 'documentos.id');
                $query->join('tipoproveedor', 'facturap1_tipoproveedor', '=', 'tipoproveedor.id');
                $query->join('regional', 'facturap1_regional', '=', 'regional.id');
                $query->where('facturap3_saldo', '<>',  0);
                $query->where('facturap1_tercero', $tercero->id);
            }
            // Show factura collection
            if ($request->has('facturap1')) {
                $facturap1 = Facturap1::find($request->facturap1);
                if (!$facturap1 instanceof Facturap1) {
                    return response()->json(['success' => false, 'errors' => 'No se pudo recuperar el facturap1, por favor verifique la informacion o consulte al administrador']);
                }
                $query->where('facturap3_facturap1', $facturap1->id);
            }

            $query->orderBy('facturap3_vencimiento', 'desc');
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
