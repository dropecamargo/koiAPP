<?php

namespace App\Http\Controllers\Comercial;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Log, DB;

use App\Models\Comercial\PresupuestoAsesor;
use App\Models\Inventario\Categoria;
use App\Models\Base\Tercero;

class PresupuestoAsesorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $object = new \stdClass();
            $object->meses = config('koi.meses');
            $object->categorias = [];
            $object->total_mes = [];
            $object->total_categorias = [];

            $categorias = Categoria::where('categoria_activo', true)->get();

            $data = [];
            foreach ($categorias as $item)
            {
                $categoria = new \stdClass();
                $categoria->id = $item->id;
                $categoria->categoria_nombre = $item->categoria_nombre;

                $query = PresupuestoAsesor::query();
                $query->where('presupuestoasesor_asesor', $request->presupuestoasesor_asesor);
                $query->where('presupuestoasesor_ano', $request->presupuestoasesor_ano);
                $query->where('presupuestoasesor_categoria', $item->id);
                $categoria->presupuesto = $query->lists('presupuestoasesor_valor', 'presupuestoasesor_mes');
           
                $object->categorias[] = $categoria;
            }
            
            $object->total_categorias = PresupuestoAsesor::query()
                ->select('categoria.id as categoria', DB::raw('sum(presupuestoasesor_valor) as total'))
                ->join('categoria', 'presupuestoasesor_categoria', '=', 'categoria.id')
                ->where('presupuestoasesor_asesor', $request->presupuestoasesor_asesor)
                ->where('presupuestoasesor_ano', $request->presupuestoasesor_ano)
                ->where('categoria_activo', true)
                ->groupBy('presupuestoasesor_categoria')->lists('total', 'categoria');

            $object->total_mes = PresupuestoAsesor::query()
                ->select('presupuestoasesor_mes as mes', DB::raw('SUM(presupuestoasesor_valor) as total'))
                ->join('categoria', 'presupuestoasesor_categoria', '=', 'categoria.id')
                ->where('presupuestoasesor_asesor', $request->presupuestoasesor_asesor)
                ->where('presupuestoasesor_ano', $request->presupuestoasesor_ano)
                ->where('categoria_activo', true)
                ->groupBy('presupuestoasesor_mes')
                ->lists('total', 'mes');

            $object->success = true;
            return response()->json($object);
        }
        return view('comercial.presupuestoasesor.main');
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
            $presupuesto = new PresupuestoAsesor;
            if ($presupuesto->isValid($data)) {
                DB::beginTransaction();
                try {
                    $asesor = Tercero::select(
                            DB::raw("CONCAT((CASE WHEN tercero_persona = 'N'
                                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                                        (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                                    )
                                    ELSE tercero_razonsocial
                                END)
                            ) AS tercero_nombre"
                        ))     
                        ->find($request->presupuestoasesor_asesor);
                    if(!$asesor instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'Asesor no se encuentra registrado, por favor verifique la información o consulte al administrador.']);
                    }

                    $query = Categoria::query()->where('categoria_activo', true);
                    $categorias = $query->get();
                    
                    foreach ($categorias as $categoria) {
                        foreach ( config('koi.meses') as $key => $name ) {
                            if($request->has("presupuestoasesor_valor_{$categoria->id}_{$key}")){

                                $query = PresupuestoAsesor::query();
                                $query->where('presupuestoasesor_mes', $key);
                                $query->where('presupuestoasesor_ano', $request->presupuestoasesor_ano);
                                $query->where('presupuestoasesor_categoria', $categoria->id);
                                $query->where('presupuestoasesor_asesor', $request->presupuestoasesor_asesor);
                                $presupuestoasesor = $query->first();

                                if(!$presupuestoasesor instanceof PresupuestoAsesor) {
                                    $presupuestoasesor = new PresupuestoAsesor;
                                }

                                $presupuestoasesor->presupuestoasesor_mes = $key;
                                $presupuestoasesor->presupuestoasesor_ano = $request->presupuestoasesor_ano;
                                $presupuestoasesor->presupuestoasesor_categoria = $categoria->id;
                                $presupuestoasesor->presupuestoasesor_asesor = $request->presupuestoasesor_asesor;
                                $presupuestoasesor->presupuestoasesor_valor = $request->get("presupuestoasesor_valor_{$categoria->id}_{$key}");
                                $presupuestoasesor->save();
                            }
                        }
                    }                   

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'message' => "Presupuesto de $asesor->tercero_nombre del año $request->presupuestoasesor_ano actualizado!"]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $presupuestoasesor->errors]);
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
    public function destroy($id)
    {
        //
    }
}
