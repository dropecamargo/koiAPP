<?php

namespace App\Http\Controllers\Comercial;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Log, DB;

use App\Models\Comercial\PresupuestoAsesor;
use App\Models\Inventario\Categoria;

class PresupuestoAsesorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $query = Categoria::query();
            $query->select('categoria_nombre','id');
            $categoria = $query->get();
            $data = [];
            foreach ($categoria as $categoria) {
                $objeto = new \stdClass();
                $objeto->id = $categoria->id;
                $objeto->categoria_nombre = $categoria->categoria_nombre;
                $objeto->presupuesto = [];

                $query = PresupuestoAsesor::query();
                $query->select('presupuestoasesor_mes','presupuestoasesor_valor');
                $query->where('presupuestoasesor_asesor', $request->presupuestoasesor_asesor)->where('presupuestoasesor_categoria', $categoria->id)->where('presupuestoasesor_ano', $request->presupuestoasesor_ano);

                $objeto->presupuesto = $query->lists('presupuestoasesor_valor','presupuestoasesor_mes');
                $data[] = $objeto;
            }
            return response()->json(['success'=>true, 'categorias'=>$data]);
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

            dd($data);
            $presupuesto = new PresupuestoAsesor;
            if ($presupuesto->isValid($data)) {
                DB::beginTransaction();
                try {
                    // presupuestoasesor

                    
                    // $presupuesto->fill($data);
                    // $presupuesto->save();

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
