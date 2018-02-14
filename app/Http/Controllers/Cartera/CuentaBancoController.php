<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Cartera\CuentaBanco, App\Models\Cartera\Banco;
use DB, Log, Cache, Datatables;

class CuentaBancoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = CuentaBanco::query();
            $query->select('cuentabanco.*','banco_nombre');
            $query->join('banco','cuentabanco_banco', '=','banco.id');
            return Datatables::of($query)->make(true);
        }
        return view('cartera.cuentabancos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cartera.cuentabancos.create');
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
            $cuentabanco = new CuentaBanco;
            if ($cuentabanco->isValid($data)) {
                DB::beginTransaction();
                try {
                    //Recuperar Banco
                    $banco = Banco::find($request->cuentabanco_banco);
                    if(!$banco instanceof Banco) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar banco, verifique información ó por favor consulte al administrador.']);
                    }

                    // Cuenta Banco
                    $cuentabanco->fill($data);
                    $cuentabanco->fillBoolean($data);
                    $cuentabanco->cuentabanco_banco = $banco->id;
                    $cuentabanco->save();

                    //Forget cache
                    Cache::forget( CuentaBanco::$key_cache );
                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $cuentabanco->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $cuentabanco->errors]);
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
        $cuentabanco = CuentaBanco::getCuentaBanco($id);
        if ($request->ajax()) {
            return response()->json($cuentabanco);
        }
        return view('cartera.cuentabancos.show', ['cuentabanco' => $cuentabanco]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cuentabanco = CuentaBanco::getCuentaBanco($id);
        return view('cartera.cuentabancos.edit', ['cuentabanco' => $cuentabanco]);
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
            $cuentabanco = CuentaBanco::findOrFail($id);
            if ($cuentabanco->isValid($data)) {
                DB::beginTransaction();
                try {
                    //Recuperar Banco && plancuentas
                    $banco = Banco::find($request->cuentabanco_banco);
                    if(!$banco instanceof Banco) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar banco, verifique información ó por favor consulte al administrador.']);
                    }

                    // Cuenta Banco
                    $cuentabanco->fill($data);
                    $cuentabanco->fillBoolean($data);
                    $cuentabanco->cuentabanco_banco = $banco->id;
                    $cuentabanco->save();

                    //Forget cache
                    Cache::forget( CuentaBanco::$key_cache );
                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $cuentabanco->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $cuentabanco->errors]);
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
