<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Inventario\TipoAjuste, App\Models\Inventario\TipoAjuste2, App\Models\Inventario\TipoProducto;
use DB, Log;

class DetalleTipoAjusteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = [];
            if( $request->has('tipoajuste') ){
                $query = TipoAjuste2::query();
                $query->select('tipoajuste2.id as id', 'tipoproducto.id as tipoproducto', 'tipoproducto_codigo', 'tipoproducto_nombre');
                $query->join('tipoajuste', 'tipoajuste2_tipoajuste', '=', 'tipoajuste.id');
                $query->join('tipoproducto', 'tipoajuste2_tipoproducto', '=', 'tipoproducto.id');
                $query->where('tipoajuste2_tipoajuste', $request->tipoajuste);
                $data = $query->get();
            }
            return response()->json($data);
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
            // Validar TipoProducto
            try {
                $tipoproducto = TipoProducto::find($request->tipoproducto);
                if( !$tipoproducto instanceof TipoProducto ){
                    return response()->json(['success'=> false, 'errors'=>'No es posible recuperar tipo de producto, por favor verifique la información o consulte al administrador.']);
                }

                return response()->json(['success' => true, 'id' => uniqid(), 'tipoproducto_codigo' => $tipoproducto->tipoproducto_codigo, 'tipoproducto_nombre' => $tipoproducto->tipoproducto_nombre]);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
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
                // Validar padre
                $tipoajuste = TipoAjuste::find($request->tipoajuste);
                if(!$tipoajuste instanceof TipoAjuste) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar el tipo de ajuste, por favor verifique la información o consulte al administrador.']);
                }

                $tipoajuste2 = TipoAjuste2::find($id);
                if(!$tipoajuste2 instanceof TipoAjuste2) {
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar el item, por favor verifique la información o consulte al administrador.']);
                }

                if( $tipoajuste2->tipoajuste2_tipoajuste != $tipoajuste->id ){
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'El item que esta tratando de eliminar no corresponde al tipo de ajuste, por favor verifique la información o consulte al administrador.']);
                }

                $tipoajuste2->delete();

                DB::commit();
                return response()->json(['success' => true]);
            }catch(\Exception $e){
                DB::rollback();
                Log::error(sprintf('%s -> %s: %s', 'Cotizacion2Controller', 'destroy', $e->getMessage()));
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
