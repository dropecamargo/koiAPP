<?php

namespace App\Http\Controllers\Comercial;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Comercial\ConfigSabanaVenta;
use App\Models\Inventario\Linea;

use DB, Log, Auth, Datatables;

class ConfigSabanaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // ConfigSabanaVenta::getlineas();
            $query = ConfigSabanaVenta::query();
            if( $request->has('datatables') ) {
                $query->select('configsabanaventa_orden_impresion', 'configsabanaventa_agrupacion_nombre', 'configsabanaventa_agrupacion');
                $query->groupBy('configsabanaventa_orden_impresion');
                $query->orderBy('configsabanaventa_orden_impresion', 'asc');
                return Datatables::of($query)->make(true);
            }else if($request->has('agrupacion')){
                $query->select('configsabanaventa.*', 'linea.id as linea_codigo', 'linea_nombre');
                $query->join('linea', 'linea.id', '=', 'configsabanaventa.configsabanaventa_linea');
                $query->orderBy('configsabanaventa_orden_impresion', 'asc');
                $query->orderBy('configsabanaventa_grupo', 'asc');
                $query->orderBy('configsabanaventa_agrupacion', 'asc');
                $query->orderBy('configsabanaventa_unificacion', 'asc');
                $query->orderBy('linea_nombre', 'asc');
                $query->where('configsabanaventa_agrupacion',$request->agrupacion);
                return response()->json(['data' => $query->get()]);
            }
            return response()->json("Consulte con su administrador a ocurrido un error en la configuración", 500);
        }
        return view('comercial.configsabana.main');
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
            $config = new ConfigSabanaVenta;
            if ($config->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recupero linea
                    $linea = Linea::find($request->configsabanaventa_linea);
                    if (!$linea instanceof Linea) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar linea, por favor verifique información']);
                    }
                    // Configuración sabana de venta
                    if ($request->call === 'add-agrupation') {
                        $config->getAgrupacion();
                        $config->getGrupo();
                        $config->getUnificacion();
                    }elseif ($request->call === 'add-group') {
                        if(!$config->getAgrupacion($request->agrupacion)){
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar agrupación, por favor verifique información']);
                        }
                        $config->getGrupo();
                        $config->getUnificacion();
                    }elseif ($request->call === 'add-unification') {
                        if(!$config->getAgrupacion($request->agrupacion)){
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar agrupación, por favor verifique información']);
                        }
                        if(!$config->getGrupo($request->configsabanaventa_grupo)){
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar grupo, por favor verifique información']);
                        }
                        $config->getUnificacion();
                    }elseif ($request->call === 'add-line') {
                        if(!$config->getAgrupacion($request->agrupacion)){
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar agrupación, por favor verifique información']);
                        }
                        if(!$config->getGrupo($request->configsabanaventa_grupo)){
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar grupo, por favor verifique información']);
                        }
                        if(!$config->getUnificacion($request->configsabanaventa_unificacion)){
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar unificación, por favor verifique información']);
                        }
                    }
                    $config->fill($data);
                    $config->configsabanaventa_linea = $linea->id;
                    $config->configsabanaventa_usuario_elaboro = Auth::user()->id;
                    $config->configsabanaventa_fh_elaboro = date('Y-m-d H:m:s');
                    $config->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $config->id, 'msg' => 'Configuración agregada con exito']);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $config->errors]);
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
        $itemConfig = ConfigSabanaVenta::find($id);
        if (!$itemConfig instanceof ConfigSabanaVenta) {
            return response()->json("Consulte con su administrador a ocurrido un error al querer eliminar este registro", 500);
        }
        $itemConfig->delete();
        return response()->json("Ítem eliminado correctamente", 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function grupos(Request $request)
    {
        $query = ConfigSabanaVenta::getGrupos($request->configsabana);
        if($request->has('q')) {
            $query->where( function($query) use($request) {
                $query->whereRaw("configsabanaventa_grupo_nombre like '%".$request->q."%'");
            });
        }

        if(empty($request->q) && empty($request->id)) {
            $query->take(50);
        }
        return response()->json($query->get());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unificaciones(Request $request)
    {
        $query = ConfigSabanaVenta::getUnificaciones($request->configsabana);
        if($request->has('q')) {
            $query->where( function($query) use($request) {
                $query->whereRaw("configsabanaventa_grupo_nombre like '%".$request->q."%'");
            });
        }

        if(empty($request->q) && empty($request->id)) {
            $query->take(50);
        }
        return response()->json($query->get());
    }

}
