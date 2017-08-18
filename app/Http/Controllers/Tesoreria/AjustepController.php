<?php

namespace App\Http\Controllers\Tesoreria;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Tesoreria\Ajustep1, App\Models\Tesoreria\Ajustep2, App\Models\Tesoreria\ConceptoAjustep, App\Models\Tesoreria\Facturap3;
use App\Models\Base\Tercero, App\Models\Base\Regional, App\Models\Base\Documentos;
use DB, Log, Datatables, Auth;

class AjustepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Ajustep1::query();
            $query->select('ajustep1.*', DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            );
            $query->join('tercero','ajustep1_tercero', '=', 'tercero.id');
            return Datatables::of($query)->make(true);
        }
        return view('tesoreria.ajustesp.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tesoreria.ajustesp.create');
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
            $ajustep = new Ajustep1;
            if ($ajustep->isValid($data)) {
                DB::beginTransaction();
                try {
                    //Recuperar cliente && regional && documento(AJUP) && conceptoAjustep
                    $documento = Documentos::where('documentos_codigo', Ajustep1::$default_document)->first();
                    if(!$documento instanceof Documentos) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar documentos,por favor verifique la información ó por favor consulte al administrador.']);
                    }

                    $tercero = Tercero::where('tercero_nit', $request->ajustep1_tercero)->first();
                    if(!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cliente, verifique información ó por favor consulte al administrador.']);
                    }
                    
                    $regional = Regional::find($request->ajustep1_regional);
                    if(!$regional instanceof Regional) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar regional, verifique información ó por favor consulte al administrador.']);
                    }

                    $conceptoajustep = ConceptoAjustep::find($request->ajustep1_conceptoajustep);
                    if(!$conceptoajustep instanceof ConceptoAjustep) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el concepto, verifique información ó por favor consulte al administrador.']);
                    }

                    // Consecutive
                    $consecutive = $regional->regional_ajup + 1;

                    // Ajustep1
                    $ajustep->fill($data);
                    $ajustep->ajustep1_regional = $regional->id;
                    $ajustep->ajustep1_numero = $consecutive;
                    $ajustep->ajustep1_tercero = $tercero->id;
                    $ajustep->ajustep1_documentos = $documento->id;
                    $ajustep->ajustep1_conceptoajustep = $conceptoajustep->id;
                    $ajustep->ajustep1_usuario_elaboro = Auth::user()->id;
                    $ajustep->ajustep1_fh_elaboro = date('Y-m-d H:m:s');
                    $ajustep->save();

                    $detalle = isset($data['detalle']) ? $data['detalle'] : null;
                    foreach ($detalle as $item) 
                    {
                        // Recupero instancia de Documentos
                        $documentos = Documentos::find($item['ajustep2_documentos_doc']);
                        if(!$documentos instanceof Documentos){
                            DB::rollback();
                            return response()->json(['success'=>false, 'errors'=>'No es posible recuperar documento, verifique información ó por favor consulte al administrador.']);
                        }
                        $tercero = Tercero::getTercero($item['ajustep2_tercero']);
                        // Recupero instancia de Tercero 
                        if(!$tercero instanceof Tercero){
                            DB::rollback();
                            return response()->json(['success'=>false, 'errors'=>'No es posible recuperar cliente, verifique información ó por favor consulte al administrador.']);
                        }
                        // Ajustep2
                        $ajustep2 = new Ajustep2;
                        $ajustep2->ajustep2_ajustep1 = $ajustep->id;
                        $ajustep2->ajustep2_naturaleza = $item['ajustep2_naturaleza'];
                        $ajustep2->ajustep2_valor = $item['ajustep2_valor'];
                        $ajustep2->ajustep2_documentos_doc = $documentos->id;
                        $ajustep2->ajustep2_tercero = $tercero->id;

                        if(isset($item['facturap3_id'])){
                            $facturap3 = Facturap3::where('id',$item['facturap3_id'])->where('facturap3_facturap1', $item['ajustep2_facturap1'])->first();
                            if( !$facturap3 instanceof Facturap3 ){
                                DB::rollback();
                                return response()->json(['success'=>false, 'errors'=>'No es posible recuperar el numero de la factura, por favor verifique ó consulte con el administrador.']);
                            }

                            if($item['ajustep2_naturaleza'] == 'D'){
                                $facturap3->facturap3_saldo = $facturap3->facturap3_saldo - $item['facturap3_valor'];
                            }else{
                                $facturap3->facturap3_saldo = $facturap3->facturap3_saldo + $item['facturap3_valor'];
                            }

                            $facturap3->save();
                            $ajustep2->ajustep2_id_doc = $facturap3->facturap3_facturap1;
                        }
                        $ajustep2->save();
                    }
                    // Update consecutive regional_ajup in Regional
                    $regional->regional_ajup = $consecutive;
                    $regional->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $ajustep->id]);
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $ajustep->errors]);
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
        $ajustep = Ajustep1::getAjustep($id);
        if ($request->ajax()) {
            return response()->json($ajustep);
        }
        return view('tesoreria.ajustesp.show', ['ajustep' => $ajustep]);
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
