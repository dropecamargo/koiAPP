<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Base\Empresa, App\Models\Base\Tercero;
use App\Models\Contabilidad\PlanCuenta;
use Log, DB;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $empresa = Empresa::getEmpresa();
            return response()->json($empresa);
        }
        return view('admin.empresa.main');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
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
        if ($request->ajax()) {
            $data = $request->all();
            $empresa = Empresa::findOrFail($id);
            $tercero = Tercero::findOrFail($empresa->empresa_tercero);
            if ($tercero->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Tercero
                    $tercero->fill($data);
                    $tercero->fillBoolean($data);
                    $tercero->save();

                    //Recuperar Plan cuenta
                    $cuenta = PlanCuenta::find($request->empresa_cuentacartera);
                    if(!$cuenta instanceof PlanCuenta) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar plan de cuenta, verifique información ó por favor consulte al administrador.']);
                    }

                    // Validando Sub Niveles
                    $result = $cuenta->validarSubnivelesCuenta();
                    if ($result != 'OK') {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result ]);
                    }

                    // Empresa
                    $empresa->fill($data);
                    $empresa->fillBoolean($data);
                    $empresa->empresa_cuentacartera = $cuenta->id;
                    $empresa->save();

                    // Update variable the session
                    session([ 'empresa' => $empresa ]);

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $tercero->errors]);
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
