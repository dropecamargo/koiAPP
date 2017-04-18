<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Inventario\Traslado1,App\Models\Inventario\Traslado2, App\Models\Inventario\Producto;
use App\Models\Base\Documentos, App\Models\Base\Sucursal;
use DB, Log, Datatables;

class TrasladoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Traslado1::query();
            $query->select('traslado1.id', 'traslado1_numero', 'traslado1_fecha', 'o.sucursal_nombre as sucursa_origen', 'd.sucursal_nombre as sucursa_destino');   
            $query->join('sucursal as o', 'traslado1_origen', '=', 'o.id');
            $query->join('sucursal as d', 'traslado1_destino', '=', 'd.id');
            return Datatables::of($query)->make(true);
        }
        return view('inventario.traslados.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventario.traslados.create');
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
            $traslado = new Traslado1;
            if ($traslado->isValid()) {
                DB::beginTransaction();
                try {
                    // Recuperar origen
                    $origen = Sucursal::find($request->traslado1_sucursal);
                    if(!$origen instanceof Sucursal) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar sucursal origen, por favor verifique la información o consulte al administrador.']);
                    }

                    // Recuperar destino
                    $destino = Sucursal::find($request->traslado1_destino);
                    if(!$destino instanceof Sucursal) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar sucursal destino, por favor verifique la información o consulte al administrador.']);
                    }

                    // Recuperar consecutivo
                    $consecutivo = $origen->sucursal_traslado + 1;

                    
                    // Commit Transaction
                    DB:rollback();
                    return response()->json(['success' => false, 'errors'=> 'OK']);
                } catch (\Exception $e) {
                    DB::rollback();
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
