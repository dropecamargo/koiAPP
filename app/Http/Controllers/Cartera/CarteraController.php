<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Cartera\Factura3, App\Models\Cartera\Anticipo1,App\Models\Cartera\ChDevuelto;
use App\Models\Base\Tercero;
use DB;

class CarteraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $cartera = [];
            if ($request->has('tercero')) {
                $tercero = Tercero::find($request->tercero);
                if(!$tercero instanceof Tercero){
                    return response()->json(['success' => false, 'errors' => 'No se pudo recuperar el cliente, por favor verifique la informacion o consulte al administrador']);
                }
                // Factura3 - cuotas
                $factura3 = Factura3::query();
                $factura3->select('factura3.id as factura3_id','factura3_chposfechado1','factura3_vencimiento','factura1_numero','factura3_cuota','factura3_saldo','factura1_fh_elaboro','sf.sucursal_nombre','df.documentos_nombre', 
                            DB::raw("DATEDIFF(factura3_vencimiento, NOW() ) as days"));

                $factura3->join('factura1', 'factura3_factura1', '=', 'factura1.id');
                $factura3->join('documentos as df', 'factura1_documentos', '=', 'df.id');
                $factura3->join('sucursal as sf', 'factura1_sucursal', '=', 'sf.id');
                $factura3->where('factura3_saldo', '<>',  0);
                $factura3->where('factura1_tercero', $tercero->id);

                // Anticipos 
                $anticipo = Anticipo1::query();
                $anticipo->select( 'anticipo1.id as anticipo1_id',DB::raw('null'),'anticipo1_fecha','anticipo1_numero',DB::raw('1'),DB::raw('anticipo1_saldo * -1'), 'anticipo1_fecha','sa.sucursal_nombre','da.documentos_nombre',DB::raw("DATEDIFF(anticipo1_fecha, NOW() ) as days"));
                $anticipo->join('documentos as da' , 'anticipo1_documentos', '=' , 'da.id');
                $anticipo->join('sucursal as sa', 'anticipo1_sucursal', '=', 'sa.id');
                $anticipo->where('anticipo1_saldo', '<>',  0);
                $anticipo->where('anticipo1_tercero', $tercero->id);

                // Cheques devueltos
                $chdevuelto = ChDevuelto::query();
                $chdevuelto->select( 'chdevuelto.id as chdevuelto_id',DB::raw('null'),'chdevuelto_fecha','chdevuelto_numero',DB::raw('1'), 'chdevuelto_saldo', 'chdevuelto_fecha','schd.sucursal_nombre','dch.documentos_nombre',DB::raw("DATEDIFF(chdevuelto_fecha, NOW() ) as days"));
                $chdevuelto->join('documentos as dch' , 'chdevuelto_documentos', '=' , 'dch.id');
                $chdevuelto->join('sucursal as schd', 'chdevuelto_sucursal', '=', 'schd.id');
                $chdevuelto->where('chdevuelto_saldo', '<>',  0);
                $chdevuelto->where('chdevuelto_tercero', $tercero->id);

                // Make the unions
                $factura3->unionAll($anticipo);
                $factura3->unionAll($chdevuelto);
                $factura3->orderBy('factura3_vencimiento', 'desc');
                $cartera = $factura3->get();
            }
            return response()->json($cartera);
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
