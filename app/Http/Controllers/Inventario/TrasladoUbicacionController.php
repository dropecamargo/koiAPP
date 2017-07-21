<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Inventario\TrasladoUbicacion1,App\Models\Inventario\TrasladoUbicacion2,App\Models\Inventario\TipoTraslado,App\Models\Inventario\Producto,App\Models\Inventario\Lote,App\Models\Inventario\Prodbode,App\Models\Inventario\Inventario,App\Models\Inventario\Rollo;
use App\Models\Base\Documentos, App\Models\Base\Sucursal, App\Models\Base\Ubicacion;
use DB,Log,Datatables,Auth;

class TrasladoUbicacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = TrasladoUbicacion1::query();
            $query->select('trasladou1.id', 'trasladou1_numero', 'trasladou1_fecha', 'o.sucursal_nombre as sucursa_origen', 'd.sucursal_nombre as sucursa_destino');   
            $query->join('sucursal as o', 'trasladou1_origen', '=', 'o.id');
            $query->join('sucursal as d', 'trasladou1_destino', '=', 'd.id');
            return Datatables::of($query)->make(true);
        }
        return view('inventario.trasladosubicaciones.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventario.trasladosubicaciones.create');
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
            $trasladou = new TrasladoUbicacion1;
            if ($trasladou->isValid($data)) {
                DB::beginTransaction();
                try {
                    
                    //Validar Documentos
                    $documento = Documentos::where('documentos_codigo', Trasladou1::$default_document)->first();
                    if(!$documento instanceof Documentos) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar documentos,por favor verifique la información ó por favor consulte al administrador.']);
                    }
                    
                    // Recuperar
                    $sucursal = Sucursal::find($request->trasladou1_sucursal);
                    if(!$sucursal instanceof Sucursal) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar sucursal, por favor verifique la información o consulte al administrador.']);
                    }
                    
                    // Recuperar origen
                    $origen = Ubicacion::find($request->trasladou1_origen);
                    if(!$origen instanceof Ubicacion) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar sucursal origen, por favor verifique la información o consulte al administrador.']);
                    }
                    // Recuperar destino
                    $destino = Ubicacion::find($request->trasladou1_destino);
                    if(!$destino instanceof Ubicacion) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar sucursal destino, por favor verifique la información o consulte al administrador.']);
                    }
                    //Validar tipo traslado
                    $tipotraslado = TipoTraslado::find($request->trasladou1_tipotraslado);
                    if (!$tipotraslado instanceof TipoTraslado) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el tipo de traslado, por favor verifique la información o consulte al administrador']);
                    }

                    // Recuperar consecutivo
                    $consecutive = $sucursal->sucursal_trau + 1;

                    // Traslado 1
                    $trasladou->fill($data);
                    $trasladou->trasladou1_documentos = $documento->id;
                    $trasladou->trasladou1_numero = $consecutive;
                    $trasladou->trasladou1_tipotraslado = $tipotraslado->id;
                    $trasladou->trasladou1_sucursal = $sucursal->id;
                    $trasladou->trasladou1_origen = $origen->id;
                    $trasladou->trasladou1_destino = $destino->id;
                    $trasladou->trasladou1_usuario_elaboro = Auth::user()->id;
                    $trasladou->trasladou1_fh_elaboro = date('Y-m-d H:m:s'); 
                    $trasladou->save();

                    // Update consecutive sucursal_trau in Sucursal origen
                    $sucursal->sucursal_trau = $consecutive;
                    $sucursal->save();
                    
                    // Commit Transaction
                    // DB::commit();
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'TODO OK' ]);
                    // return response()->json(['success' => true, 'id' => $trasladou->id ]);
                }catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $trasladou->errors]);
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
        $trasladou = TrasladoUbicacion1::getTrasladoUbicacion($id);
        if(!$trasladou instanceof TrasladoUbicacion1){
            abort(404);
        }

        if ($request->ajax()) {
            return response()->json($trasladou);
        }

        return view('inventario.trasladosubicaciones.show', ['trasladou' => $trasladou]);
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
