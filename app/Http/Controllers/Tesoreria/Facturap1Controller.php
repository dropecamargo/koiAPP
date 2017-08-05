<?php

namespace App\Http\Controllers\Tesoreria;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Tesoreria\Facturap1,App\Models\Tesoreria\TipoProveedor,App\Models\Tesoreria\TipoGasto;
use App\Models\Base\Tercero,App\Models\Base\Documentos,App\Models\Base\Regional;
use DB, Log, Datatables, Cache;

class Facturap1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Facturap1::query();
            return Datatables::of($query)->make(true);
        }
        return view('tesoreria.facturap.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tesoreria.facturap.create');
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
            $facturap1 = new Facturap1;
            if ($facturap1->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recupero instanci de tercero
                    $tercero = Tercero::where('tercero_nit', $request->facturap1_tercero)->first();
                    if (!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cliente, por favor verifique la información o consulte al administrador']);
                    }
                    // Recupero regional
                    $regional = Regional::find($request->facturap1_regional);
                    if (!$regional instanceof Regional) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar regional, por favor verifique la información o consulte al administrador']);
                    }
                    // Recupero documentos
                    $documentos = Documentos::where('documentos_codigo', Facturap1::$default_document)->first();
                    if (!$documentos instanceof Documentos) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar documentos, por favor verifique la información o consulte al administrador']);
                    }
                    // Recupero Tipo de Proveedor
                    $tipoproveedor = TipoProveedor::find($request->facturap1_tipoproveedor);
                    if (!$tipoproveedor instanceof TipoProveedor) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el tipo de proveedor, por favor verifique la información o consulte al administrador']);
                    }
                    // Recupero Tipo gasto
                    $tipogasto = TipoGasto::find($request->facturap1_tipogasto);
                    if (!$tipogasto instanceof TipoGasto) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el tipo de gasto, por favor verifique la información o consulte al administrador']);
                    }
                    // Consecutive
                    $consecutive = $regional->regional_fpro + 1;

                    $facturap1->fill($data);
                    $facturap1->facturap1_documentos = $documentos->id;
                    $facturap1->facturap1_tercero = $tercero->id;
                    $facturap1->facturap1_regional = $regional->id;
                    $facturap1->facturap1_numero = $consecutive;
                    $facturap1->facturap1_tipoproveedor = $tipoproveedor->id;
                    $facturap1->facturap1_tipogasto = $tipogasto->id;
                    $facturap1->facturap1_base = ($request->facturap1_subtotal - $request->facturap1_descuento);

                    $facturap1->save();

                    // Update consecutive regional_fpro
                    $regional->regional_fpro = $consecutive;
                    $regional->save();

                    // Commit
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $facturap1->id ]);
                    // DB::rollback();
                    // return response()->json(['success' => false, 'errors' => 'TODO OK' ]);
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $facturap1->errors ]);
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
        $facturap1 = Facturap1::getFacturap($id);
        if ($request->ajax()) {
            return response()->json($facturap1);
        }
        return view('tesoreria.facturap.show', ['facturap1' => $facturap1]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $facturap1 = Facturap1::findOrFail($id);
        return view('tesoreria.facturap.create', ['facturap1' => $facturap1]);
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
