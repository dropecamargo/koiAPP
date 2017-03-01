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

            $query = Categoria::query();
            $query->select('categoria_nombre','id');
            $query->where('categoria_activo', true);
            $categorias = $query->get();

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
                    $asesor = Tercero::find($request->presupuestoasesor_asesor);
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

                    return response()->json(['success' => true, 'id' => $presupuesto->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $presupuesto->errors]);
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
