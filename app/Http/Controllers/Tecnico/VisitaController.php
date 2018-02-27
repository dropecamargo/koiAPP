<?php

namespace App\Http\Controllers\Tecnico;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Tecnico\Visita, App\Models\Tecnico\Visitap, App\Models\Tecnico\Contadoresp, App\Models\Tecnico\Orden, App\Models\Inventario\Producto, App\Models\Base\Tercero;
use DB, Log, Cache,Auth;

class VisitaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       if( $request->ajax() ){
            $query = Visita::getVisita($request->orden_id);
            return response()->json( $query );
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
            $data = $request->all();
            $visita = new Visita;
            if ($visita->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Validar Tecnico
                    $tercero = Tercero::where('tercero_nit', $request->visita_tercero)->first();
                    if(!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar técnico, por favor verifique la información o consulte al administrador.']);
                    }

                    // Validar orden
                    $orden = Orden::find($request->visita_orden);
                    if(!$orden instanceof Orden) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar orden de servicio, por favor verifique la información o consulte al administrador.']);
                    }

                    // Validar maquina
                    $producto = Producto::find($orden->orden_serie);
                    if(!$producto instanceof Producto) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar maquina, por favor verifique la información o consulte al administrador.']);
                    }

                    //Numero visita
                    $numero = Visita::select(DB::raw('(COALESCE( COUNT(id), 0 ) + 1) as numero'))->where('visita_orden', $orden->id)->pluck('numero');

                    // visita
                    $visita->fill($data);
                    $visita->visita_numero = $numero;
                    $visita->visita_tecnico = $tercero->id;
                    $visita->visita_fh_llegada = "$request->visita_fecha_llegada $request->visita_hora_llegada";
                    $visita->visita_fh_inicio = "$request->visita_fecha_inicio $request->visita_hora_inicio";
                    $visita->visita_fh_finaliza = "$request->visita_fecha_fin $request->visita_hora_fin";
                    $visita->visita_usuario_elaboro = Auth::user()->id;
                    $visita->visita_fh_elaboro = date('Y-m-d H:m:s');
                    $visita->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $visita->id, 'visita_fh_llegada' => $visita->visita_fh_llegada, 'visita_fh_inicio' => $visita->visita_fh_inicio, 'tercero_nombre' => $tercero->getName(), 'visita_numero'=> $visita->visita_numero, 'visita_fh_finaliza' => $visita->visita_fh_finaliza]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $visita->errors]);
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
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                $visita = Visita::find($id);
                if(!$visita instanceof Visita){
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar visita, por favor verifique la información o consulte al administrador.']);
                }

                // Eliminar item visita
                $visita->delete();

                DB::commit();
                return response()->json(['success' => true]);
            }catch(\Exception $e){
                DB::rollback();
                Log::error(sprintf('%s -> %s: %s', 'VisitaController', 'destroy', $e->getMessage()));
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
