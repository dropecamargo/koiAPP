<?php

namespace App\Http\Controllers\Tesoreria;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Tesoreria\TipoGasto;
use App\Models\Contabilidad\PlanCuenta;
use DB, Log, Datatables, Cache;

class TipoGastoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = TipoGasto::query();
            return Datatables::of($query)->make(true);
        }
        return view('tesoreria.tipogasto.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tesoreria.tipogasto.create');
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
            $tipogasto = new TipoGasto;
            if ($tipogasto->isValid($data)) {
                DB::beginTransaction();
                try {
                    // TipoGasto
                    $tipogasto->fill($data);
                    $tipogasto->fillBoolean($data);
                    
                    $plancuenta = PlanCuenta::where('plancuentas_cuenta',$request->tipogasto_plancuentas)->first();
                    if (!$plancuenta instanceof PlanCuenta) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar plan de cuentas, por favor verifique información o consulte con el administrador']);
                    }
                    $tipogasto->tipogasto_plancuentas = $plancuenta->id;
                    $tipogasto->save();

                    // Forget cache
                    Cache::forget( TipoGasto::$key_cache );

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' =>$tipogasto->id]); 
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $tipogasto->errors]);
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
        $tipogasto = TipoGasto::getTipoGasto($id);
        if ($request->ajax()) {
            return response()->json($tipogasto);
        }
        return view('tesoreria.tipogasto.show', ['tipogasto' => $tipogasto]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tipogasto = TipoGasto::findOrFail($id);
        return view('tesoreria.tipogasto.edit', ['tipogasto' => $tipogasto]);
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
            $tipogasto = TipoGasto::findOrFail($id);
            if ($tipogasto->isValid($data)) {
                DB::beginTransaction();
                try {
                    // TipoGasto
                    $tipogasto->fill($data);
                    $tipogasto->fillBoolean($data);
                    
                    $plancuenta = PlanCuenta::where('plancuentas_cuenta',$request->tipogasto_plancuentas)->first();
                    if (!$plancuenta instanceof PlanCuenta) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar plan de cuentas, por favor verifique información o consulte con el administrador']);
                    }
                    $tipogasto->tipogasto_plancuentas = $plancuenta->id;
                    $tipogasto->save();

                    // Forget cache
                    Cache::forget( TipoGasto::$key_cache );
                    
                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' =>$tipogasto->id]); 
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $tipogasto->errors]);
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
}
