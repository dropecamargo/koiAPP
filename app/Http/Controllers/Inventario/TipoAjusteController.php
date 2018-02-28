<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Inventario\TipoAjuste, App\Models\Inventario\TipoAjuste2, App\Models\Inventario\TipoProducto;
use DB, Log, Datatables, Cache;

class TipoAjusteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of(TipoAjuste::query())->make(true);
        }
        return view('inventario.tiposajuste.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventario.tiposajuste.create');
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
            $tipoajuste = new TipoAjuste;
            if ($tipoajuste->isValid($data)) {
                DB::beginTransaction();
                try {
                    //tipoajuste
                    $tipoajuste->fill($data);
                    $tipoajuste->fillBoolean($data);
                    $tipoajuste->save();

                    // Select multiple && Guardar referencia select multiple
                    $detalle = isset($data['detalle']) ? $data['detalle'] : null;
                    foreach ( $detalle as $tipoproducto) {
                        $tipoajuste2 = new TipoAjuste2;
                        $tipoajuste2->tipoajuste2_tipoajuste = $tipoajuste->id;
                        $tipoajuste2->tipoajuste2_tipoproducto = $tipoproducto['tipoproducto'];
                        $tipoajuste2->save();
                    }

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget( TipoAjuste::$key_cache );
                    return response()->json(['success' => true, 'id' => $tipoajuste->id]);
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $tipoajuste->errors]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $tipoajuste = TipoAjuste::findOrFail($id);
        if ($request->ajax()) {
            // Recuperar tipoajuste2
            if($request->has('call')){
                $tipoajuste->tipoajuste_tipoproducto = $tipoajuste->getTypesProducto()->tipoajuste_tipoproducto;
            }
            return response()->json($tipoajuste);
        }
        return view('inventario.tiposajuste.show', ['tipoajuste'=>$tipoajuste]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tipoajuste = TipoAjuste::findOrFail($id);
        return view('inventario.tiposajuste.create', ['tipoajuste'=>$tipoajuste]);
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
            $tipoajuste = TipoAjuste::findOrFail($id);
            if ($tipoajuste->isValid($data)) {
                DB::beginTransaction();
                try {
                    //tipoajuste
                    $tipoajuste->fill($data);
                    $tipoajuste->fillBoolean($data);
                    $tipoajuste->save();

                    // Select multiple && Guardar referencia select multiple
                    $detalle = isset($data['detalle']) ? $data['detalle'] : null;
                    foreach ( $detalle as $tipoproducto) {
                        // Validar Tipodeporudcto
                        $validar = TipoAjuste2::where('tipoajuste2_tipoproducto', $tipoproducto['tipoproducto'])->where('tipoajuste2_tipoajuste', $tipoajuste->id)->first();
                        if( !$validar instanceof TipoAjuste2 ){
                            $tipoajuste2 = new TipoAjuste2;
                            $tipoajuste2->tipoajuste2_tipoajuste = $tipoajuste->id;
                            $tipoajuste2->tipoajuste2_tipoproducto = $tipoproducto['tipoproducto'];
                            $tipoajuste2->save();
                        }
                    }

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget( TipoAjuste::$key_cache );
                    return response()->json(['success' => true, 'id' => $tipoajuste->id]);
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $tipoajuste->errors]);
        }
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
