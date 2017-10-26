<?php

namespace App\Http\Controllers\Comercial;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Comercial\GestionComercial,App\Models\Comercial\ConceptoComercial;
use App\Models\Base\Tercero;
use DB, Log, Auth, Datatables;

class GestionComercialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            
            $query = GestionComercial::query();
              // Filter show collection in tercero
            if ($request->has('tercero')) {
                $query->select('gestioncomercial.*', 'conceptocom_nombre', DB::raw(DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS usuario_nombre")));

                $query->join('tercero','gestioncomercial_usuario_elaboro', '=', 'tercero.id');
                $query->join('conceptocom','gestioncomercial_conceptocom', '=', 'conceptocom.id');
                $query->where('gestioncomercial_tercero', $request->tercero);
                $gestioncomercial = $query->get();
                return response()->json($gestioncomercial);
            }

            $query->select('gestioncomercial.*', 'conceptocom_nombre', 'tercero_nit', 'tercero_razonsocial', 'tercero_nombre1', 'tercero_nombre2', 'tercero_apellido1', 'tercero_apellido2',DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            );
            $query->join('tercero','gestioncomercial_tercero', '=', 'tercero.id');
            $query->join('conceptocom','gestioncomercial_conceptocom', '=', 'conceptocom.id');


            return Datatables::of($query)->make(true);
        }
        return view('comercial.gestionescomercial.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('comercial.gestionescomercial.create');
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
            $gestioncomercial = new GestionComercial;
            if ($gestioncomercial->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recupero instancia de Tercero(cliente)  
                    $tercero = Tercero::where('tercero_nit', $request->gestioncomercial_tercero)->first();
                    if(!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cliente, verifique información ó por favor consulte al administrador.']);
                    }
                    // Recupero instancia de Conceptocom
                    $conceptocom = ConceptoComercial::find($request->gestioncomercial_conceptocom);
                    if (!$conceptocom instanceof ConceptoComercial) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar concepto comercial, verifique información ó por consulte al administrador']);
                    }
                    // Recupero instancia de Tercero(vendedor)  
                    $vendedor = Tercero::find($request->gestioncomercial_vendedor);
                    if (!$vendedor instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar vendedor, verifique información ó por favor consulte al administrador.']);
                    }
                    $gestioncomercial->fill($data);
                    $gestioncomercial->gestioncomercial_tercero = $tercero->id;
                    $gestioncomercial->gestioncomercial_conceptocom = $conceptocom->id;
                    $gestioncomercial->gestioncomercial_vendedor = $vendedor->id;
                    $gestioncomercial->gestioncomercial_fh = date('Y-m-d H:m:s'); 
                    $gestioncomercial->gestioncomercial_inicio = "$request->gestioncomercial_inicio $request->gestioncomercial_hinicio"; 
                    $gestioncomercial->gestioncomercial_finalizo = "$request->gestioncomercial_finalizo $request->gestioncomercial_hfinalizo"; 
                    $gestioncomercial->gestioncomercial_usuario_elaboro = Auth::user()->id;
                    $gestioncomercial->gestioncomercial_fh_elaboro = date('Y-m-d H:m:s'); 
                    $gestioncomercial->save();
                    
                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $gestioncomercial->id]);
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }

            return response()->json(['success' => false, 'errors' => $gestioncomercial->errors]);
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
        $gestioncomercial = GestionComercial::getGestionComercial($id);
        if(!$gestioncomercial instanceof GestionComercial) {
            abort(404);
        }
         if($request->ajax()) {
            return response()->json($gestioncomercial);
        }
        return view('comercial.gestionescomercial.show', ['gestioncomercial' => $gestioncomercial]);
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
