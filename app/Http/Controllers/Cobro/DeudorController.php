<?php

namespace App\Http\Controllers\Cobro;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

use App\Models\Cobro\Deudor, App\Models\Cobro\GestionDeudor, App\Models\Cartera\ConceptoCob, App\Models\Base\Notificacion, App\Models\Base\Tercero;
use Datatables, DB, Log, Auth;

class DeudorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if( $request->ajax() ){
            $query = Deudor::query();
            $query->select('deudor.*', DB::raw("CONCAT(deudor_nombre1,' ',deudor_nombre2,' ',deudor_apellido1,' ',deudor_apellido2) AS deudor_nombre"), DB::raw("(CASE WHEN tercero_persona = 'N'
                THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                        (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                    )
                ELSE tercero_razonsocial END)
            AS tercero_nombre"));
            $query->join('tercero', 'deudor_tercero', '=', 'tercero.id');
            return Datatables::of($query)
                ->filter(function($query) use($request) {
                    // Tercero
                    if( $request->has('deudor_tercero') ) {
                        $query->where('deudor_tercero', $request->deudor_tercero);
                    }

                    // Documento
                    if( $request->has('deudor_nit') ) {
                        $query->whereRaw("deudor_nit LIKE '%{$request->deudor_nit}%'");
                    }

                    // Nombre
                    if( $request->has('deudor_nombre') ) {
                        $query->where(function ($query) use($request) {
                            $query->whereRaw("deudor_nombre1 LIKE '%{$request->deudor_nombre}%'");
                            $query->orWhereRaw("deudor_nombre2 LIKE '%{$request->deudor_nombre}%'");
                            $query->orWhereRaw("deudor_apellido1 LIKE '%{$request->deudor_nombre}%'");
                            $query->orWhereRaw("deudor_apellido2 LIKE '%{$request->deudor_nombre}%'");
                            $query->orWhereRaw("deudor_razonsocial LIKE '%{$request->deudor_nombre}%'");
                            $query->orWhereRaw("CONCAT(deudor_nombre1,' ',deudor_nombre2,' ',deudor_apellido1,' ',deudor_apellido2) LIKE '%{$request->deudor_nombre}%'");
                        });
                    }
                })->make(true);
        }
        return view('cobro.deudores.index');
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
    public function show(Request $request, $id)
    {
        $deudor = Deudor::getDeudor($id);
        if ($request->ajax()) {
            return response()->json($deudor);
        }
        return view('cobro.deudores.show', ['deudor' => $deudor]);
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

    /**
     * gestiondeudor
     */
    public function gestiondeudor(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();

            $gestiondeudor = new GestionDeudor;
            if ($gestiondeudor->isValid($data)) {
                DB::beginTransaction();
                try {
                    $deudor = Deudor::findOrFail($request->deudor);
                    if(!$deudor instanceof Deudor) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar deudor, verifique información ó por favor consulte al administrador.']);
                    }

                    // Recupero instancia de ConceptoCobro
                    $conceptocobro = ConceptoCob::find($request->gestiondeudor_conceptocob);
                    if(!$conceptocobro instanceof ConceptoCob) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar Concepto Cobro, verifique información ó por favor consulte al administrador.']);
                    }

                    $gestiondeudor->fill($data);
                    $gestiondeudor->gestiondeudor_fh = date('Y-m-d H:m:s');
                    $gestiondeudor->gestiondeudor_proxima = "$request->gestiondeudor_proxima $request->gestiondeudor_hproxima";
                    $gestiondeudor->gestiondeudor_deudor = $deudor->id;
                    $gestiondeudor->gestiondeudor_conceptocob = $conceptocobro->id;
                    $gestiondeudor->gestiondeudor_usuario_elaboro = Auth::user()->id;
                    $gestiondeudor->gestiondeudor_fh_elaboro = date('Y-m-d H:m:s');
                    $gestiondeudor->save();

                    $url = route('gestiondeudores.show', $gestiondeudor->id, false);
                    $descripcion = Str::title($request->tercero_nombre);
                    $title = trans('notification.call.gestiondeudor');

                    // Parameters newNotificacion(tercero->session, tiponotificacion, visto, fecha_visto, fecha, hora, url, descripcion, titulo)
                    $result = Notificacion::newNotificacion(Auth::user()->id, 'llamada', false, null, $request->gestiondeudor_proxima, $request->gestiondeudor_hproxima, $url, $descripcion, $title);
                    if($result != 'OK'){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result]);
                    }

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $gestiondeudor->id, 'msg' => 'Se genero la gestión al deudor con exito.']);
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $gestiondeudor->errors]);
        }
        abort(403);
    }
}
