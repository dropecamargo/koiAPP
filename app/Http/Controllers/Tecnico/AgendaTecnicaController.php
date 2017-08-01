<?php

namespace App\Http\Controllers\Tecnico;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Tecnico\Orden, App\Models\Base\Tercero;
use DB, Log;

class AgendaTecnicaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){

            $query = Orden::query();
            $query->select(DB::raw("CONCAT('Orden #', orden.id) as title"), 'orden_fh_servicio as start' , DB::raw("SUBSTRING_INDEX(orden_fh_servicio, ' ', -1) as hora_servicio"), DB::raw("SUBSTRING_INDEX(orden_fh_servicio, ' ', 1) as fecha_servicio"), DB::raw("(CASE WHEN t.tercero_persona = 'N'
                    THEN CONCAT(t.tercero_nombre1,' ',t.tercero_nombre2,' ',t.tercero_apellido1,' ',t.tercero_apellido2,
                            (CASE WHEN (t.tercero_razonsocial IS NOT NULL AND t.tercero_razonsocial != '') THEN CONCAT(' - ', t.tercero_razonsocial) ELSE '' END)
                        )
                    ELSE t.tercero_razonsocial END)
                AS tercero_nombre"), DB::raw("(CASE WHEN tc.tercero_persona = 'N'
                    THEN CONCAT(tc.tercero_nombre1,' ',tc.tercero_nombre2,' ',tc.tercero_apellido1,' ',tc.tercero_apellido2,
                            (CASE WHEN (tc.tercero_razonsocial IS NOT NULL AND tc.tercero_razonsocial != '') THEN CONCAT(' - ', tc.tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tc.tercero_razonsocial END)
                AS tecnico_nombre")
            );
            $query->leftJoin('tercero as tc', 'orden_tecnico', '=', 'tc.id');
            $query->leftJoin('tercero as t', 'orden_tercero', '=', 't.id');

            if($request->has('search_technical')){
                // Recuperar tecnico
                $tecnico = Tercero::getTechnical($request->search_technical);
                if(!$tecnico instanceof Tercero){
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar el tecnico, por favor verifique la informacion o consulte al administrador.']);
                }

                $query->where('orden_tecnico', $tecnico->id);
            }

            if($request->has('search_tercero')){
                // Recuperar tercero
                $tercero = Tercero::where('tercero_nit', $request->search_tercero)->first();
                if(!$tercero instanceof Tercero){
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar el tercero, por favor verifique la informacion o consulte al administrador.']);
                }

                $query->where('orden_tercero', $tercero->id);
            }

            $ordenes = $query->get();

            // Crear objeto
            $object = new \stdClass();
            $object->ordenes = []; 
            foreach ($ordenes as $orden) {
                $object->ordenes[] = $orden;
            }

            $object->success = true;
            return response()->json($object);
        }
        return view('tecnico.agendatecnica.main');
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
