<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

use App\Models\Cartera\GestionCobro, App\Models\Cartera\ConceptoCob, App\Models\Base\Notificacion;
use App\Models\Base\Tercero;
use DB, Log, Cache, Auth, Datatables;

class GestionCobroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = GestionCobro::query();

            // Filter show collection in tercero
            if ($request->has('tercero')) {
                $query->select('gestioncobro.*', 'conceptocob_nombre', DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS usuario_nombre"));
                $query->join('tercero','gestioncobro_usuario_elaboro', '=', 'tercero.id');
                $query->join('conceptocob','gestioncobro_conceptocob', '=', 'conceptocob.id');
                $query->where('gestioncobro_tercero', $request->tercero);
                $gestioncobro = $query->get();
                return response()->json($gestioncobro);
            }

            $query->select('gestioncobro.*', 'conceptocob_nombre', 'tercero_nit', 'tercero_razonsocial', 'tercero_nombre1', 'tercero_nombre2', 'tercero_apellido1', 'tercero_apellido2',DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            );
            $query->join('tercero','gestioncobro_tercero', '=', 'tercero.id');
            $query->join('conceptocob','gestioncobro_conceptocob', '=', 'conceptocob.id');


            return Datatables::of($query)->make(true);
        }
        return view('cartera.gestioncobros.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cartera.gestioncobros.create');
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
            $gestioncobro = new GestionCobro;
            if ($gestioncobro->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recupero instancia de Tercero(cliente)
                    $tercero = Tercero::where('tercero_nit', $request->gestioncobro_tercero)->first();
                    if(!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cliente, verifique información ó por favor consulte al administrador.']);
                    }
                    // Recupero instancia de ConceptoCobro
                    $conceptocobro = ConceptoCob::find($request->gestioncobro_conceptocob);
                    if(!$conceptocobro instanceof ConceptoCob) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar Concepto Cobro, verifique información ó por favor consulte al administrador.']);
                    }

                    $gestioncobro->fill($data);
                    $gestioncobro->gestioncobro_fh = date('Y-m-d H:m:s');
                    $gestioncobro->gestioncobro_proxima = "$request->gestioncobro_proxima $request->gestioncobro_hproxima";
                    $gestioncobro->gestioncobro_tercero = $tercero->id;
                    $gestioncobro->gestioncobro_conceptocob = $conceptocobro->id;
                    $gestioncobro->gestioncobro_usuario_elaboro = Auth::user()->id;
                    $gestioncobro->gestioncobro_fh_elaboro = date('Y-m-d H:m:s');
                    $gestioncobro->save();

                    $url = route('gestioncobros.show', $gestioncobro->id, false);
                    $descripcion = Str::title($request->tercero_nombre);
                    $title = trans('notification.call.gestioncobro');

                    // Parameters newNotificacion(tercero->session, tiponotificacion, visto, fecha_visto, fecha, hora, url, descripcion, titulo)
                    $result = Notificacion::newNotificacion(Auth::user()->id, 'llamada', false, null, $request->gestioncobro_proxima, $request->gestioncobro_hproxima, $url, $descripcion, $title);
                    if($result != 'OK'){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result]);
                    }

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $gestioncobro->id]);
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }

            return response()->json(['success' => false, 'errors' => $gestioncobro->errors]);
        }
        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $gestioncobro = GestionCobro::getGestionCobro($id);
        if(!$gestioncobro instanceof GestionCobro) {
            abort(404);
        }
         if($request->ajax()) {
            return response()->json($gestioncobro);
        }
        return view('cartera.gestioncobros.show', ['gestioncobro' => $gestioncobro]);
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
