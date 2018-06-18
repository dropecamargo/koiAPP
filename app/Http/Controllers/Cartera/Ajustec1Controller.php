<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Classes\AsientoContableDocumento, App\Classes\AsientoNifContableDocumento;
use App\Models\Cartera\Ajustec1, App\Models\Cartera\Ajustec2, App\Models\Cartera\ConceptoAjustec, App\Models\Cartera\Factura3, App\Models\Cartera\ChDevuelto, App\Models\Cartera\Anticipo1;
use App\Models\Base\Tercero, App\Models\Base\Sucursal, App\Models\Base\Regional, App\Models\Base\Documentos;
use DB, Log, Datatables, Auth;

class Ajustec1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Ajustec1::query();
            $query->select('ajustec1.*', DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            );
            $query->join('tercero','ajustec1_tercero', '=', 'tercero.id');
            $query->orderBy('ajustec1.id', 'desc');
            return Datatables::of($query)->make(true);
        }
        return view('cartera.ajustesc.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cartera.ajustesc.create');
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
            $ajustec = new Ajustec1;
            if ($ajustec->isValid($data)) {
                DB::beginTransaction();
                try {
                    //Recuperar cliente && sucursal && documento(AJUC) && conceptoAjustec
                    $documento = Documentos::where('documentos_codigo', Ajustec1::$default_document)->first();
                    if(!$documento instanceof Documentos) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar documentos,por favor verifique la información ó por favor consulte al administrador.']);
                    }

                    $tercero = Tercero::where('tercero_nit', $request->ajustec1_tercero)->first();
                    if(!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cliente, verifique información ó por favor consulte al administrador.']);
                    }

                    $sucursal = Sucursal::find($request->ajustec1_sucursal);
                    if(!$sucursal instanceof Sucursal) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar sucursal, verifique información ó por favor consulte al administrador.']);
                    }
                    $regional = Regional::find($sucursal->sucursal_regional);
                    if(!$regional instanceof Regional) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar sucursal, verifique información ó por favor consulte al administrador.']);
                    }

                    $conceptoajustec = ConceptoAjustec::find($request->ajustec1_conceptoajustec);
                    if(!$conceptoajustec instanceof ConceptoAjustec) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el concepto, verifique información ó por favor consulte al administrador.']);
                    }

                    // Consecutive
                    $consecutive = $regional->regional_ajuc + 1;

                    // ajustec
                    $ajustec->fill($data);
                    $ajustec->ajustec1_sucursal = $sucursal->id;
                    $ajustec->ajustec1_numero = $consecutive;
                    $ajustec->ajustec1_tercero = $tercero->id;
                    $ajustec->ajustec1_documentos = $documento->id;
                    $ajustec->ajustec1_conceptoajustec = $conceptoajustec->id;
                    $ajustec->ajustec1_usuario_elaboro = Auth::user()->id;
                    $ajustec->ajustec1_fh_elaboro = date('Y-m-d H:m:s');
                    $ajustec->save();

                    $total = 0;
                    foreach ($data['detalle'] as $item)
                    {
                        // Recupero instancia de Documentos
                        $documentos = Documentos::find($item['ajustec2_documentos_doc']);
                        if(!$documentos instanceof Documentos){
                            DB::rollback();
                            return response()->json(['success'=>false, 'errors'=>'No es posible recuperar documento, verifique información ó por favor consulte al administrador.']);
                        }
                        // Ajuste2
                        $ajustec2 = new Ajustec2;
                        $ajustec2->ajustec2_ajustec1 = $ajustec->id;
                        $ajustec2->ajustec2_naturaleza = $item['ajustec2_naturaleza'];
                        $ajustec2->ajustec2_documentos_doc = $documentos->id;

                        switch ($documentos->documentos_codigo) {
                            case 'FACT':
                                if(isset($item['factura3_id'])){
                                    $factura3 = Factura3::where('id',$item['factura3_id'])->where('factura3_factura1', $item['ajustec2_factura1'])->first();
                                    if( !$factura3 instanceof Factura3 ){
                                        DB::rollback();
                                        return response()->json(['success'=>false, 'errors'=>'No es posible recuperar el numero de la factura, por favor verifique ó consulte con el administrador.']);
                                    }

                                    if($item['ajustec2_naturaleza'] == 'D'){
                                        $factura3->factura3_saldo = $factura3->factura3_saldo - $item['factura3_valor'];
                                    }else{
                                        $factura3->factura3_saldo = $factura3->factura3_saldo + $item['factura3_valor'];
                                    }
                                    $factura3->factura3_fecha_pago = date('Y-m-d');
                                    $factura3->save();

                                    $ajustec2->ajustec2_id_doc = $factura3->id;
                                    $ajustec2->ajustec2_valor = $item['factura3_valor'];
                                }
                                break;
                            case 'CHD':
                                $chdevuelto = ChDevuelto::find($item['chdevuelto_id']);
                                if ( !$chdevuelto instanceof ChDevuelto ) {
                                    DB::rollback();
                                    return response()->json(['success'=>false, 'errors'=>"No es posible recuperar cheque devuelto, por favor verifique ó consulte con el administrador."]);
                                }

                                if($item['ajustec2_naturaleza'] == 'D'){
                                    $chdevuelto->chdevuelto_saldo = $chdevuelto->chdevuelto_saldo - $item['ajustec2_valor'];
                                }else{
                                    $chdevuelto->chdevuelto_saldo = $chdevuelto->chdevuelto_saldo + $item['ajustec2_valor'];
                                }
                                $chdevuelto->save();
                                $ajustec2->ajustec2_id_doc = $chdevuelto->id;
                                $ajustec2->ajustec2_valor = $item['ajustec2_valor'];
                            break;
                            case 'ANTI':
                                $anticipo = Anticipo1::find( $item['anticipo_id'] );
                                if (!$anticipo instanceof Anticipo1) {
                                    DB::rollback();
                                    return response()->json(['success'=>false, 'errors'=>"No es posible recuperar anticipo, por favor verifique ó consulte con el administrador."]);
                                }
                                $anticipo->anticipo1_saldo = $anticipo->anticipo1_saldo <= 0 ? $anticipo->anticipo1_saldo + $item['ajustec2_valor'] : $anticipo->anticipo1_saldo - $item['ajustec2_valor'];
                                $anticipo->save();
                                $ajustec2->ajustec2_id_doc = $anticipo->id;
                                $ajustec2->ajustec2_valor = $item['ajustec2_valor'];
                            break;
                            default:
                                $ajustec2->ajustec2_valor = $item['ajustec2_valor'];
                            break;
                        }
                        $ajustec2->ajustec2_tercero = $tercero->id;
                        $ajustec2->save();

                        // Total para ajustec1
                        $total += $ajustec2->ajustec2_valor ;
                    }
                    $ajustec->ajustec1_valor += $total;

                    // Preparando asiento
                    $encabezado = $ajustec->encabezadoAsiento($tercero, $conceptoajustec);
                    if(!is_object($encabezado)){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $encabezado]);
                    }
                    //Creo el objeto para manejar el asiento
                    $objAsiento = new AsientoContableDocumento($encabezado->data);
                    if($objAsiento->asiento_error) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $objAsiento->asiento_error]);
                    }
                    // Preparar asiento
                    $result = $objAsiento->asientoCuentas($encabezado->cuenta);
                    if($result != 'OK'){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result]);
                    }

                    // Insertar asiento
                    $result = $objAsiento->insertarAsiento();
                    if($result != 'OK') {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $result]);
                    }
                    // AsientoNif
                    if (!empty($encabezado->dataNif)) {
                        // Creo el objeto para manejar el asiento
                        $objAsientoNif = new AsientoNifContableDocumento($encabezado->dataNif);
                        if($objAsientoNif->asientoNif_error) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $objAsiento->asientoNif_error]);
                        }

                        // Preparar asiento
                        $result = $objAsientoNif->asientoCuentas($encabezado->cuenta);
                        if($result != 'OK'){
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $result]);
                        }

                        // Insertar asiento
                        $result = $objAsientoNif->insertarAsientoNif();
                        if($result != 'OK') {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $result]);
                        }
                        // Recuperar el Id del asiento y guardar en la factura
                        $ajustec->ajustec1_asienton = $objAsientoNif->asientoNif->id;
                    }
                    $ajustec->ajustec1_asiento = $objAsiento->asiento->id;
                    $ajustec->save();
                    // Update consecutive regional_ajuc in Sucursal
                    $regional->regional_ajuc = $consecutive;
                    $regional->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $ajustec->id]);
                    // return response()->json(['success' => false, 'errors' => 'TODO OK']);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $ajustec->errors]);
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
        $ajustec = Ajustec1::getAjustec($id);
        if ($request->ajax()) {
            return response()->json($ajustec);
        }
        return view('cartera.ajustesc.show', ['ajustec' => $ajustec]);
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
