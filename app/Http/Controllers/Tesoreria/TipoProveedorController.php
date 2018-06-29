<?php

namespace App\Http\Controllers\Tesoreria;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Tesoreria\TipoProveedor, App\Models\Contabilidad\PlanCuenta;
use DB, Log, Datatables, Cache;

class TipoProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = TipoProveedor::query();
            return Datatables::of($query)->make(true);
        }
        return view('tesoreria.tipoproveedor.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tesoreria.tipoproveedor.create');
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
            $tipoproveedor = new TipoProveedor;
            if ($tipoproveedor->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar Plan Cuentas
                    $cuenta = PlanCuenta::find($request->tipoproveedor_cuenta);
                    if (!$cuenta instanceof PlanCuenta) {
                        DB::rollback();
                        return response()->json(['success' => false , 'errors' => 'No es posible recuperar plan de cuenta, verifique información ó por favor consulte al administrador.']);
                    }

                    // Validando Sub Niveles
                    $result = $cuenta->validarSubnivelesCuenta();
                    if ($result != 'OK') {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result ]);
                    }

                    // TipoProveedor
                    $tipoproveedor->fill($data);
                    $tipoproveedor->fillBoolean($data);
                    $tipoproveedor->tipoproveedor_cuenta = $cuenta->id;
                    $tipoproveedor->save();

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget( TipoProveedor::$key_cache );

                    return response()->json(['success' => true, 'id' =>$tipoproveedor->id]);
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $tipoproveedor->errors]);
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
        $tipoproveedor = TipoProveedor::getTipoProveedor($id);
        if ($request->ajax()) {
            return response()->json($tipoproveedor);
        }
        return view('tesoreria.tipoproveedor.show', ['tipoproveedor' => $tipoproveedor]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tipoproveedor = TipoProveedor::findOrFail($id);
        return view('tesoreria.tipoproveedor.edit', ['tipoproveedor' => $tipoproveedor]);
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
            $tipoproveedor = TipoProveedor::findOrFail($id);
            if ($tipoproveedor->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar Plan Cuentas
                    $cuenta = PlanCuenta::find($request->tipoproveedor_cuenta);
                    if (!$cuenta instanceof PlanCuenta) {
                        DB::rollback();
                        return response()->json(['success' => false , 'errors' => 'No es posible recuperar plan de cuenta, verifique información ó por favor consulte al administrador.']);
                    }

                    // Validando Sub Niveles
                    $result = $cuenta->validarSubnivelesCuenta();
                    if ($result != 'OK') {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result ]);
                    }

                    // TipoProveedor
                    $tipoproveedor->fill($data);
                    $tipoproveedor->fillBoolean($data);
                    $tipoproveedor->tipoproveedor_cuenta = $cuenta->id;
                    $tipoproveedor->save();

                    // Commit Transaction
                    DB::commit();

                    // Forget cache
                    Cache::forget( TipoProveedor::$key_cache );

                    return response()->json(['success' => true, 'id' =>$tipoproveedor->id]);
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $tipoproveedor->errors]);
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
