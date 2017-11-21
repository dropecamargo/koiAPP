<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Cartera\Recibo1, App\Models\Cartera\Recibo2, App\Models\Cartera\Recibo3, App\Models\Cartera\Factura3, App\Models\Cartera\Factura1,App\Models\Cartera\ChposFechado1,App\Models\Cartera\ChDevuelto,App\Models\Cartera\Anticipo1;
use App\Models\Cartera\Conceptosrc, App\Models\Cartera\CuentaBanco, App\Models\Cartera\MedioPago,App\Models\Cartera\Banco;
use App\Models\Base\Documentos, App\Models\Base\Sucursal,App\Models\Base\Regional, App\Models\Base\Tercero;
use DB, Log, Auth, Datatables;

class Recibo1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Recibo1::query();
            $query->select('recibo1.*', DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            );
            $query->join('tercero','recibo1_tercero', '=', 'tercero.id');
            $query->orderBy('recibo1.id', 'desc');
            return Datatables::of($query->get())->make(true);
        }
        return view('cartera.recibos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cartera.recibos.create');
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
            $recibo1 = new Recibo1;
            if ($recibo1->isValid($data)) {
                DB::beginTransaction();
                try {
                    //Recuperar Cuenta && cliente && sucursal && documento(RECI)
                    $documento = Documentos::where('documentos_codigo', Recibo1::$default_document)->first();
                    if(!$documento instanceof Documentos) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar documentos,por favor verifique la información ó por favor consulte al administrador.']);
                    }

                    $cuentabanco = CuentaBanco::find($request->recibo1_cuentas);
                    if(!$cuentabanco instanceof CuentaBanco) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar la cuenta, verifique información ó por favor consulte al administrador.']);
                    }

                    $tercero = Tercero::where('tercero_nit', $request->recibo1_tercero)->first();
                    if(!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cliente, verifique información ó por favor consulte al administrador.']);
                    }

                    $sucursal = Sucursal::find($request->recibo1_sucursal);
                    if(!$sucursal instanceof Sucursal) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar sucursal, verifique información ó por favor consulte al administrador.']);
                    }
                    $regional = Regional::find($sucursal->sucursal_regional);
                    if(!$regional instanceof Regional) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar regional, verifique información ó por favor consulte al administrador.']);
                    }
                    // Consecutive
                    $consecutive = $regional->regional_reci + 1;

                    // Recibo1
                    $recibo1->fill($data);
                    $recibo1->recibo1_tercero = $tercero->id;
                    $recibo1->recibo1_sucursal = $sucursal->id;
                    $recibo1->recibo1_numero = $consecutive;
                    $recibo1->recibo1_documentos = $documento->id;
                    $recibo1->recibo1_cuentas = $cuentabanco->id;
                    $recibo1->recibo1_usuario_elaboro = Auth::user()->id;
                    $recibo1->recibo1_fh_elaboro = date('Y-m-d H:m:s');
                    $recibo1->save();

                    // Recibo2
                    $recibo2 = isset($data['recibo2']) ? $data['recibo2'] : null;
                    foreach ($recibo2 as $item)
                    {
                        $recibo2 = new Recibo2;
                        $recibo2->fill($item);
                        $recibo2->recibo2_recibo1 = $recibo1->id;

                        $conceptorc = Conceptosrc::find($item['recibo2_conceptosrc']);
                        if (!$conceptorc instanceof Conceptosrc) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar concepto recibo de caja, por favor verifique ó consulte con el administrador.']);
                        }

                        $documento = Documentos::find($conceptorc->conceptosrc_documentos);
                        if ($documento instanceof Documentos) {
                            switch ($documento->documentos_codigo) {
                                case 'FACT':
                                    if( isset($item['factura3_id']) ) {
                                        $factura3 = Factura3::where('id',$item['factura3_id'])->where('factura3_factura1', $item['recibo2_factura1'])->first();
                                        if( !$factura3 instanceof Factura3 ){
                                            DB::rollback();
                                            return response()->json(['success'=>false, 'errors'=>'No es posible recuperar el numero de la factura, por favor verifique ó consulte con el administrador.']);
                                        }

                                        $factura = Factura1::where( 'id', $factura3->factura3_factura1 )->where('factura1_tercero', $tercero->id)->first();
                                        if( !$factura instanceof Factura1 ){
                                            DB::rollback();
                                            return response()->json(['success'=>false, 'errors'=>"La factura #$factura3->factura1_numero ingresada no corresponde al cliente, por favor verifique ó consulte con el administrador."]);
                                        }

                                        $factura3->factura3_saldo = $factura3->factura3_saldo <= 0 ? $factura3->factura3_saldo + $item['factura3_valor'] : $factura3->factura3_saldo - $item['factura3_valor'];
                                        $factura3->factura3_fecha_pago = date('Y-m-d');
                                        $factura3->save();
                                        $recibo2->recibo2_id_doc = $factura3->id;
                                    }

                                    if(!empty($item['factura3_valor'])){
                                        $recibo2->recibo2_valor = $item['factura3_valor'];
                                    }
                                break;

                                case 'CHD':
                                    $chdevuelto = ChDevuelto::find($item['chdevuelto_id']);
                                    if ( !$chdevuelto instanceof ChDevuelto ) {
                                        DB::rollback();
                                        return response()->json(['success'=>false, 'errors'=>"No es posible recuperar cheque devuelto, por favor verifique ó consulte con el administrador."]);
                                    }
                                    $chdevuelto->chdevuelto_saldo = $chdevuelto->chdevuelto_saldo <= 0 ? $chdevuelto->chdevuelto_saldo + $item['recibo2_valor'] : $chdevuelto->chdevuelto_saldo - $item['recibo2_valor'];
                                    $chdevuelto->save();
                                    $recibo2->recibo2_id_doc = $chdevuelto->id;
                                    $recibo2->recibo2_valor = $item['recibo2_valor'];
                                break;
                                case 'ANTI':
                                    $anticipo = Anticipo1::find( $item['anticipo_id'] );
                                    if (!$anticipo instanceof Anticipo1) {
                                        DB::rollback();
                                        return response()->json(['success'=>false, 'errors'=>"No es posible recuperar anticipo, por favor verifique ó consulte con el administrador."]);
                                    }
                                    $anticipo->anticipo1_saldo = $anticipo->anticipo1_saldo <= 0 ? $anticipo->anticipo1_saldo + $item['recibo2_valor'] : $anticipo->anticipo1_saldo - $item['recibo2_valor'];
                                    $anticipo->save();
                                    $recibo2->recibo2_id_doc = $anticipo->id;
                                    $recibo2->recibo2_valor = $item['recibo2_valor'];
                                break;
                                default:
                                    $recibo2->recibo2_valor = $item['recibo2_valor'];
                                break;
                            }
                        }else{
                            $recibo2->recibo2_valor = $item['recibo2_valor'];
                        }
                        $recibo2->save();
                    }

                    foreach ($data['recibo3'] as $value) {
                        // Recupero instancia de MedioPago
                        $mediopago = MedioPago::find($value['recibo3_mediopago']);
                        if (!$mediopago instanceof MedioPago) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar medio de pago, verifique información ó por favor consulte al administrador.']);
                        }
                        // Cuando es cheque o tarjeta estos vienen con datos que hay que guardar
                        if ( $value['recibo3_banco_medio'] != "" && $value['recibo3_numero_medio'] != "" && $value['recibo3_vence_medio'] != "" ) {
                            // Recupero instancia de cheque para cambiar indicativo de activo
                            if ($mediopago->mediopago_ch) {
                                $cheque = ChposFechado1::where('chposfechado1_ch_numero',$value['recibo3_numero_medio'])->first();
                                if (!$cheque instanceof ChposFechado1) {
                                    DB::rollback();
                                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar cheque, verifique información ó por favor consulte al administrador.']);
                                }
                                // Update estado del cheque
                                $cheque->chposfechado1_activo = false;
                                $cheque->save();
                            }
                            // Recupero instancia de Banco
                            $banco = Banco::find($value['recibo3_banco_medio']);
                            if (!$banco instanceof Banco) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => 'No es posible recuperar banco, verifique información ó por favor consulte al administrador.']);
                            }
                        }
                        $recibo3 = new Recibo3;
                        $recibo3->recibo3_recibo1 = $recibo1->id;
                        $recibo3->recibo3_mediopago = $mediopago->id;
                        $recibo3->recibo3_valor = $value['recibo3_valor'];
                        $recibo3->recibo3_banco_medio = ($value['recibo3_banco_medio'] == "") ? null : $banco->id;
                        $recibo3->recibo3_numero_medio = $value['recibo3_numero_medio'];
                        $recibo3->recibo3_vence_medio = ($value['recibo3_vence_medio'] == "") ? null : $value['recibo3_vence_medio'];
                        $recibo3->save();
                    }

                    // Update consecutive regional_reci in Regional
                    $regional->regional_reci = $consecutive;
                    $regional->save();

                    // Commit Transaction
                    DB::commit();
                    // return response()->json(['success' => false, 'errors' => 'TODO OK']);
                    return response()->json(['success' => true, 'id' => $recibo1->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $recibo1->errors]);
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
        $recibo = Recibo1::getRecibo($id);
        if ($request->ajax()) {
            return response()->json($recibo);
        }
        return view('cartera.recibos.show', ['recibo' => $recibo]);
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
