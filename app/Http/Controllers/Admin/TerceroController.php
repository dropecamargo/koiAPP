<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Base\Tercero, App\Models\Base\Actividad;
use DB, Log, Datatables, Cache;

class TerceroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Tercero::query();
            $query->select('id', 'tercero_nit', 'tercero_razonsocial', 'tercero_nombre1', 'tercero_nombre2', 'tercero_apellido1', 'tercero_apellido2','tercero_direccion',
                DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            );

            // Persistent data filter
            if($request->has('persistent') && $request->persistent) {
                session(['search_tercero_nit' => $request->has('tercero_nit') ? $request->tercero_nit : '']);
                session(['search_tercero_nombre' => $request->has('tercero_nombre') ? $request->tercero_nombre : '']);
            }

            return Datatables::of($query)
                ->filter(function($query) use($request) {
                    // Documento
                    if($request->has('tercero_nit')) {
                        $query->whereRaw("tercero_nit LIKE '%{$request->tercero_nit}%'");
                    }

                    if($request->has('cliente')) {
                        $query->where('tercero_cliente', true);
                    }

                    if($request->has('vendedor')) {
                        $query->where('tercero_vendedor', true);
                    }

                    if($request->has('tecnico')) {
                        $query->where('tercero_activo', true);
                        $query->where('tercero_tecnico', true);
                    }

                    // Nombre
                    if($request->has('tercero_nombre')) {
                        $query->where(function ($query) use($request) {
                            $query->whereRaw("tercero_nombre1 LIKE '%{$request->tercero_nombre}%'");
                            $query->orWhereRaw("tercero_nombre2 LIKE '%{$request->tercero_nombre}%'");
                            $query->orWhereRaw("tercero_apellido1 LIKE '%{$request->tercero_nombre}%'");
                            $query->orWhereRaw("tercero_apellido2 LIKE '%{$request->tercero_nombre}%'");
                            $query->orWhereRaw("tercero_razonsocial LIKE '%{$request->tercero_nombre}%'");
                            $query->orWhereRaw("CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2) LIKE '%{$request->tercero_nombre}%'");
                        });
                    }
                })
                ->make(true);
        }
        return view('admin.terceros.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.terceros.create');
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
            $tercero = new Tercero;
            if ($tercero->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Tercero
                    $tercero->fill($data);
                    $tercero->fillBoolean($data);
                    $tercero->save();

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget( Tercero::$key_cache_tadministrators );
                    Cache::forget( Tercero::$key_cache_badvisors );
                    Cache::forget( Tercero::$key_cache_sellers );
                    Cache::forget( Tercero::$key_cache_technicals );
                    return response()->json(['success' => true, 'id' => $tercero->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $tercero->errors]);
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
        $tercero = Tercero::getTercero($id);
        if ($request->ajax()) {
            return response()->json($tercero);
        }
        return view('admin.terceros.show', ['tercero' => $tercero]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tercero = Tercero::findOrFail($id);
        return view('admin.terceros.edit', ['tercero' => $tercero]);
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
        if ($request->ajax()) {
            $data = $request->all();
            $tercero = Tercero::findOrFail($id);
            if ($tercero->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Tercero
                    $tercero->fill($data);
                    $tercero->fillBoolean($data);
                    $tercero->save();

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget( Tercero::$key_cache_tadministrators );
                    Cache::forget( Tercero::$key_cache_badvisors );
                    Cache::forget( Tercero::$key_cache_sellers );
                    Cache::forget( Tercero::$key_cache_technicals );
                    return response()->json(['success' => true, 'id' => $tercero->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $tercero->errors]);
        }
        abort(403);
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
     * Display a digit of verification from document partner.
     *
     * @return \Illuminate\Http\Response
     */
    public function dv(Request $request)
    {
        if ($request->has('tercero_nit')) {

            // Valid nit
            if (! Tercero::isValidNit($request->all())) {
                return response()->json(['success' => false, 'errors' => "El nit $request->tercero_nit ya se encuentra registrado"]);
            }
            // Calc dv
            $primer = substr($request->tercero_nit,0,1);
            $longitud = strlen($request->tercero_nit);
            $verificacion = [
                0=>71, 1=>67, 2=>59,
                3=>53, 4=>47, 5=>43,
                6=>41, 7=>37, 8=>29,
                9=>23, 10=>19, 11=>17,
                12=>13, 13=>7, 14=>3
            ];
            //$a contendra el valor de la sumatoria de los productos de cada posicion del nit * el factor correspondiente en el array de verificacion
            //$b residuo($a,11)
            //si $b=0 => digito =0
            //si $b=1 => digito =1
            //si $b!=0 && $b!=1 => digito =11-$b
            $a = 0;
            $posicionnit = ($longitud-1);
            for($i=14; $i >= (15-$longitud); $i--) {
                $a += ($verificacion[$i]*substr($request->tercero_nit, $posicionnit,1));
                $posicionnit--;
            }

            $b = $a%11;
            if($b==0) {
                $dv = 0;
            }else if($b==1) {
                $dv = 1;
            }else {
                $dv = (11-$b);
            }
            return response()->json(['success' => true, 'dv' => $dv]);
        }

    }

    /**
     * Display % rcree of activity.
     *
     * @return \Illuminate\Http\Response
     */
    public function rcree(Request $request)
    {
        $rcree = '';
        if($request->has('tercero_actividad')){
            $actividad = Actividad::findOrFail($request->tercero_actividad);
            $rcree = $actividad->actividad_tarifa;
        }
        return response()->json(['success' => true, 'rcree' => $rcree]);
    }

    /**
     * Search tercero.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        if($request->has('tercero_nit')) {
            $tercero = Tercero::select('id', 'tercero_nit','tercero_direccion',
                DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            )->where('tercero_nit', $request->tercero_nit)->first();
            if($tercero instanceof Tercero) {
                return response()->json(['success' => true, 'id' => $tercero->id, 'tercero_nombre' => $tercero->tercero_nombre, 'tercero_direccion' => $tercero->tercero_direccion]);
            }
        }
        return response()->json(['success' => false]);
    }

    public function setpassword(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $tercero = Tercero::find($request->id);
            if ($tercero->isValidPass($data)) {
                DB::beginTransaction();
                try {
                    if(!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar tercero, por favor verifique la información del asiento o consulte al administrador.']);
                    }

                    $tercero->username = trim($request->username);
                    if($request->has('password')) {
                        $tercero->password = bcrypt($request->password);
                    }
                    $tercero->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'message' => 'Datos de acceso fueron actualizados.']);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $tercero->errors]);
        }
        abort(403);
    }
}
