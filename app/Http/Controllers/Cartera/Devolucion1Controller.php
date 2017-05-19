<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Cartera\Devolucion1,App\Models\Cartera\Devolucion2,App\Models\Cartera\Factura1;
use App\Models\Base\Documentos,App\Models\Base\Sucursal,App\Models\Base\Tercero;
use DB, Log, Datatables,Auth;

class Devolucion1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Devolucion1::query();
            return Datatables::of($query)->make(true);
        }
        return view('cartera.devoluciones.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cartera.devoluciones.create');
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
            $devolucion1 = new Devolucion1;
            if ($devolucion1->isValid($data)) {
                DB::beginTransaction();
                try {
                    //Validar documentos
                    $documento = Documentos::where('documentos_codigo', Devolucion1::$default_document)->first();
                    if (!$documento instanceof Documentos) {
                        DB::rollback();
                        return response()->json(['success'=> false, 'errors' => 'No es posible recuperar documentos,por favor verifique la información ó por favor consulte al administrador.']);
                    }
                    // Validar sucursal
                    $sucursal = Sucursal::find($request->devolucion1_sucursal);
                    if (!$sucursal instanceof Sucursal) {
                        DB::rollback();
                        return response()->json(['success' => false , 'No es posible recuperar sucursal,por favor verifique la información ó por favor consulte al administrador.']);
                    }
                    // Validar factura1
                    $factura1 = Factura1::where('factura1_sucursal',$sucursal->id)->where('factura1_numero',$request->devolucion1_factura1)->first();
                    if (!$factura1 instanceof Factura1) {
                        DB::rollback();
                        return response()->json(['success'=> false, 'errors' => 'No es posible recuperar factura,por favor verifique la información ó por favor consulte al administrador.']);
                    }
                    // Validar cliente
                    $cliente = Tercero::where('tercero_nit',$request->devolucion1_tercero)->first();
                    if (!$cliente instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cliente, por favor verifique la información o consulte al administrador']);
                    }
                    // Consecutive sucursal 
                    $consecutive = $sucursal->sucursal_devo + 1;
                    
                    $devolucion1->fill($data);
                    $devolucion1->devolucion1_documentos = $documento->id;
                    $devolucion1->devolucion1_sucursal = $sucursal->id;
                    $devolucion1->devolucion1_numero = $consecutive;
                    $devolucion1->devolucion1_tercero = $cliente->id;
                    $devolucion1->devolucion1_factura = $factura1->id;
                    $devolucion1->devolucion1_usuario_elaboro = Auth::user()->id;
                    $devolucion1->devolucion1_fh_elaboro = date('Y-m-d H:m:s');
                    $devolucion1->save();

                    // Update consecutive sucursal_devo in Sucursal
                    $sucursal->sucursal_devo = $consecutive;
                    $sucursal->save();
                    DB::rollback();
                    return response()->json(['success' => true, 'errors' => 'TODO OK']);
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]); 
                }
            }
            return response()->json(['success' => false, 'errors' => $devolucion1->errors]);
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
