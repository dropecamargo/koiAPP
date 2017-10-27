<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Inventario\Impuesto;
use App\Models\Contabilidad\PlanCuenta;
use DB, Log, Datatables, Cache;

class ImpuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Impuesto::query();
            return Datatables::of($query)->make(true);
        }
        return view('inventario.impuesto.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventario.impuesto.create');
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

            $impuesto = new Impuesto;
            if ($impuesto->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Impuestos
                    $impuesto->fill($data);
                    $impuesto->fillBoolean($data);

                    if ($request->has('impuesto_plancuentas')) {
                        $plancuenta = PlanCuenta::where('plancuentas_cuenta',$request->impuesto_plancuentas)->first();
                        if (!$plancuenta instanceof PlanCuenta) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar plan de cuenta por favor verifique información o consulte con el administrador']);
                        }

                        // Valid correctly use the cuenta
                        $result = $plancuenta->validarSubnivelesCuenta();
                        if ($result != 'OK') {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $result ]);
                        }   
                        $impuesto->impuesto_plancuentas = $plancuenta->id;
                    }
                    $impuesto->save();

                    //Forget cache
                    Cache::forget( Impuesto::$key_cache );

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $impuesto->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $impuesto->errors]);
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
        $impuesto = Impuesto::getImpuesto($id);
        if ($request->ajax()) {
            return response()->json($impuesto);
        }
        return view('inventario.impuesto.show', ['impuesto' => $impuesto]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $impuesto = Impuesto::findOrFail($id);
        return view('inventario.impuesto.edit', ['impuesto' => $impuesto]);
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
            $impuesto = Impuesto::findOrFail($id);
            if ($impuesto->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Impuestos
                    $impuesto->fill($data);
                    $impuesto->fillBoolean($data);

                    if ($request->has('impuesto_plancuentas')) {
                        $plancuenta = PlanCuenta::where('plancuentas_cuenta',$request->impuesto_plancuentas)->first();
                        if (!$plancuenta instanceof PlanCuenta) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar plan de cuenta por favor verifique información o consulte con el administrador']);
                        }
                        // Valid correctly use the cuenta
                        $result = $plancuenta->validarSubnivelesCuenta();
                        if ($result != 'OK') {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $result ]);
                        } 
                        $impuesto->impuesto_plancuentas = $plancuenta->id;
                    }
                    $impuesto->save();
                    
                    //Forget cache
                    Cache::forget( Impuesto::$key_cache );
                    
                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $impuesto->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $impuesto->errors]);
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
