<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Classes\AsientoContableDocumento, App\Classes\AsientoNifContableDocumento;
use App\Models\Cartera\Nota1, App\Models\Cartera\Nota2, App\Models\Cartera\ConceptoNota, App\Models\Cartera\Factura3, App\Models\Cartera\ChDevuelto, App\Models\Cartera\Anticipo1;
use App\Models\Base\Sucursal,App\Models\Base\Regional, App\Models\Base\Tercero, App\Models\Base\Documentos;
use DB, Log, Auth, Datatables;

class Nota1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Nota1::query();
            $query->select('nota1.*', 'sucursal_nombre', DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            );
            $query->join('sucursal', 'nota1_sucursal', '=', 'sucursal.id');
            $query->join('tercero', 'nota1_tercero', '=', 'tercero.id');
            $query->orderBy('nota1.id', 'desc');
            return Datatables::of($query)->make(true);
        }
        return view('cartera.notas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cartera.notas.create');
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
            $nota = new Nota1;
            if ($nota->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar Sucursal && Tercero && ConceptoNota && Documento
                    $sucursal = Sucursal::find($request->nota1_sucursal);
                    if(!$sucursal instanceof Sucursal) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar sucursal, verifique información ó por favor consulte al administrador.']);
                    }
                    // Recuperar Regional
                    $regional = Regional::find($sucursal->sucursal_regional);
                    if(!$regional instanceof Regional) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar regional, verifique información ó por favor consulte al administrador.']);
                    }

                    $tercero = Tercero::where('tercero_nit', $request->nota1_tercero)->first();
                    if(!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cliente, verifique información ó por favor consulte al administrador.']);
                    }

                    $concepto = ConceptoNota::find($request->nota1_conceptonota);
                    if(!$concepto instanceof ConceptoNota) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el concepto, verifique información ó por favor consulte al administrador.']);
                    }

                    $documentos = Documentos::where('documentos_codigo', Nota1::$default_document)->first();
                    if(!$documentos instanceof Documentos) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar documentos, por favor verifique la información ó por favor consulte al administrador.']);
                    }
                    // Consecutive
                    $consecutive = $regional->regional_nota + 1;

                    // Nota
                    $nota->fill($data);
                    $nota->fillBoolean($data);
                    $nota->nota1_sucursal = $sucursal->id;
                    $nota->nota1_tercero = $tercero->id;
                    $nota->nota1_documentos = $documentos->id;
                    $nota->nota1_conceptonota = $concepto->id;
                    $nota->nota1_usuario_elaboro = Auth::user()->id;
                    $nota->nota1_fh_elaboro = date('Y-m-d H:m:s');
                    $nota->save();

                    // Sumatoria para nota1_valor
                    $total = 0;
                    foreach ($data['nota2'] as $item)
                    {
                        $documentos = Documentos::find($item['nota2_documentos_doc']);
                        if(!$documentos instanceof Documentos) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar documentos, por favor verifique la información ó por favor consulte al administrador.']);
                        }
                        // Nota2
                        $nota2 = new Nota2;
                        $nota2->nota2_nota1 = $nota->id;
                        $nota2->nota2_documentos_doc = $documentos->id;

                        switch ($documentos->documentos_codigo) {
                            case 'FACT':
                                $factura3 = Factura3::where('id',$item['factura3_id'])->where('factura3_factura1', $item['nota2_factura1'])->first();
                                if( !$factura3 instanceof Factura3 ){
                                    DB::rollback();
                                    return response()->json(['success'=>false, 'errors'=>'No es posible recuperar el numero de la factura, por favor verifique ó consulte con el administrador.']);
                                }
                                $factura3->factura3_saldo = $factura3->factura3_saldo <= 0 ? $factura3->factura3_saldo + $item['factura3_valor'] : $factura3->factura3_saldo - $item['factura3_valor'];
                                $factura3->factura3_fecha_pago = date('Y-m-d');
                                $factura3->save();

                                $nota2->nota2_id_doc = $factura3->id;
                                $nota2->nota2_valor = $item['factura3_valor'];
                            break;
                            case 'CHD':
                                $chdevuelto = ChDevuelto::find($item['chdevuelto_id']);
                                if ( !$chdevuelto instanceof ChDevuelto ) {
                                    DB::rollback();
                                    return response()->json(['success'=>false, 'errors'=>"No es posible recuperar cheque devuelto, por favor verifique ó consulte con el administrador."]);
                                }
                                $chdevuelto->chdevuelto_saldo = $chdevuelto->chdevuelto_saldo <= 0 ? $chdevuelto->chdevuelto_saldo + $item['nota2_valor'] : $chdevuelto->chdevuelto_saldo - $item['nota2_valor'];
                                $chdevuelto->save();
                                $nota2->nota2_id_doc = $chdevuelto->id;
                                $nota2->nota2_valor = $item['nota2_valor'];
                            break;

                            case 'ANTI':
                                $anticipo = Anticipo1::find( $item['anticipo_id'] );
                                if (!$anticipo instanceof Anticipo1) {
                                    DB::rollback();
                                    return response()->json(['success'=>false, 'errors'=>"No es posible recuperar anticipo, por favor verifique ó consulte con el administrador."]);
                                }
                                $anticipo->anticipo1_saldo = $anticipo->anticipo1_saldo <= 0 ? $anticipo->anticipo1_saldo + $item['nota2_valor'] : $anticipo->anticipo1_saldo - $item['nota2_valor'];
                                $anticipo->save();
                                $nota2->nota2_id_doc = $anticipo->id;
                                $nota2->nota2_valor = $item['nota2_valor'];
                            break;

                            default:
                                $nota2->nota2_valor = $item['nota2_valor'];
                            break;
                        }
                        $nota2->save();
                        $total += $nota2->nota2_valor;
                    }
                    $nota->nota1_valor += $total;
                    
                    // Preparando asiento
                    $encabezado = $nota->encabezadoAsiento($tercero, $concepto);
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
                        $nota->nota1_asienton = $objAsientoNif->asientoNif->id;
                    }
                    $nota->nota1_asiento = $objAsiento->asiento->id;
                    $nota->save();

                    // Update consecutive sucursal_nota in Regional
                    $regional->regional_nota = $consecutive;
                    $regional->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $nota->id]);
                    // return response()->json(['success' => false, 'errors' => 'TODO OK']);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $nota->errors]);
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
        $nota = Nota1::getNota($id);
        if ($request->ajax()) {
            return response()->json($nota);
        }
        return view('cartera.notas.show', ['nota' => $nota]);
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
