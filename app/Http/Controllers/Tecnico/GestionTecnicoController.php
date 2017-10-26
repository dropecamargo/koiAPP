<?php

namespace App\Http\Controllers\Tecnico;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Tecnico\GestionTecnico,App\Models\Tecnico\ConceptoTecnico;
use App\Models\Base\Tercero;
use DB, Log, Auth, Datatables;

class GestionTecnicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            
            $query = GestionTecnico::query();

            // Filter show collection in tercero
            if ($request->has('tercero')) {
                $query->select('gestiontecnico.*', 'conceptotec_nombre', DB::raw(DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS usuario_nombre")));

                $query->join('tercero','gestiontecnico_usuario_elaboro', '=', 'tercero.id');
                $query->join('conceptotec','gestiontecnico_conceptotec', '=', 'conceptotec.id');
                $query->where('gestiontecnico_tercero', $request->tercero);
                $gestiontecnico = $query->get();
                return response()->json($gestiontecnico);
            }
            
            $query->select('gestiontecnico.*', 'conceptotec_nombre', 'tercero_nit', 'tercero_razonsocial', 'tercero_nombre1', 'tercero_nombre2', 'tercero_apellido1', 'tercero_apellido2',DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            );
            $query->join('tercero','gestiontecnico_tercero', '=', 'tercero.id');
            $query->join('conceptotec','gestiontecnico_conceptotec', '=', 'conceptotec.id');


            return Datatables::of($query)->make(true);
        }
        return view('tecnico.gestionestecnico.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tecnico.gestionestecnico.create');
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
            $gestiontecnico = new GestionTecnico;
            if ($gestiontecnico->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recupero instancia de Tercero(cliente)  
                    $tercero = Tercero::where('tercero_nit', $request->gestiontecnico_tercero)->first();
                    if(!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cliente, verifique información ó por favor consulte al administrador.']);
                    }
                    // Recupero instancia de Conceptotec
                    $conceptotec = ConceptoTecnico::find($request->gestiontecnico_conceptotec);
                    if (!$conceptotec instanceof ConceptoTecnico) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar concepto tecnico, verifique información ó por consulte al administrador']);
                    }
                    // Recupero instancia de Tercero(tecnico)  
                    $tecnico = Tercero::find($request->gestiontecnico_tecnico);
                    if (!$tecnico instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar tecnico, verifique información ó por favor consulte al administrador.']);
                    }
                    $gestiontecnico->fill($data);
                    $gestiontecnico->gestiontecnico_tercero = $tercero->id;
                    $gestiontecnico->gestiontecnico_conceptotec = $conceptotec->id;
                    $gestiontecnico->gestiontecnico_tecnico = $tecnico->id;
                    $gestiontecnico->gestiontecnico_fh = date('Y-m-d H:m:s'); 
                    $gestiontecnico->gestiontecnico_inicio = "$request->gestiontecnico_inicio $request->gestiontecnico_hinicio"; 
                    $gestiontecnico->gestiontecnico_finalizo = "$request->gestiontecnico_finalizo $request->gestiontecnico_hfinalizo"; 
                    $gestiontecnico->gestiontecnico_usuario_elaboro = Auth::user()->id;
                    $gestiontecnico->gestiontecnico_fh_elaboro = date('Y-m-d H:m:s'); 
                    $gestiontecnico->save();
                    
                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $gestiontecnico->id]);
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }

            return response()->json(['success' => false, 'errors' => $gestiontecnico->errors]);
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
        $gestiontecnico = GestionTecnico::getGestionTecnico($id);
        if(!$gestiontecnico instanceof GestionTecnico) {
            abort(404);
        }
         if($request->ajax()) {
            return response()->json($gestiontecnico);
        }
        return view('tecnico.gestionestecnico.show', ['gestiontecnico' => $gestiontecnico]);
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
