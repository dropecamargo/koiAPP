<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Classes\AsientoContableDocumento, App\Classes\AsientoNifContableDocumento;
use App\Models\Cartera\Anticipo1,App\Models\Cartera\Anticipo2,App\Models\Cartera\Anticipo3;
use App\Models\Base\Tercero,App\Models\Base\Documentos,App\Models\Base\Sucursal,App\Models\Base\Regional;
use App\Models\Cartera\Conceptosrc, App\Models\Cartera\CuentaBanco, App\Models\Cartera\MedioPago;
use DB, Log, Datatables,Auth;

class AnticipoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Anticipo1::query();

            if ( $request->has('datatables') ) {
                $query->select('anticipo1.*', 'tercero_nit', 'tercero_razonsocial', 'tercero_nombre1', 'tercero_nombre2', 'tercero_apellido1', 'tercero_apellido2','sucursal.sucursal_nombre',DB::raw("(CASE WHEN tercero_persona = 'N'
                        THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                                (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                            )
                        ELSE tercero_razonsocial END)
                    AS tercero_nombre")
                );
                $query->join('tercero','anticipo1_tercero', '=', 'tercero.id');
                $query->join('sucursal','anticipo1_sucursal', '=', 'sucursal.id');
                $query->orderBy('anticipo1.id', 'desc');
                return Datatables::of($query)->make(true);
            }

            if ( $request->has('tercero') ) {
                $anticipo = [];
                $query->select('anticipo1.*','cuentabanco_nombre');
                $query->join('cuentabanco','anticipo1_cuentas', '=', 'cuentabanco.id');
                $query->where('anticipo1_saldo', '<>', 0 );
                $query->where('anticipo1_tercero', $request->tercero)->where('anticipo1_sucursal', $request->sucursal);

                $anticipo = $query->get();
                return response()->json($anticipo);
            }
        }
        return view('cartera.anticipos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cartera.anticipos.create');
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
            $anticipo1 = new Anticipo1;
            if ($anticipo1->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recupero instancia de Documento
                    $documento = Documentos::where('documentos_codigo' , Anticipo1::$default_document)->first();
                    if (!$documento instanceof Documentos) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar documentos,por favor verifique la información ó por favor consulte al administrador.']);
                    }
                    // Recupero instancia de CuentaBanco
                    $cuentabanco = CuentaBanco::find($request->anticipo1_cuentas);
                    if(!$cuentabanco instanceof CuentaBanco) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar la cuenta, verifique información ó por favor consulte al administrador.']);
                    }
                    // Recupero instancia de Tercero(cliente)
                    $tercero = Tercero::where('tercero_nit', $request->anticipo1_tercero)->first();
                    if(!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cliente, verifique información ó por favor consulte al administrador.']);
                    }
                    // Recupero instancia de Tercero
                    $vendedor = Tercero::find($request->anticipo1_vendedor);
                    if(!$vendedor instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar vendedor, verifique información ó por favor consulte al administrador.']);
                    }
                    //Valido si es un vendedor
                    if (!$vendedor->tercero_vendedor) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => "{$vendedor->getName()} , no es vendedor, verifique información ó por favor consulte al administrador."]);
                    }
                    // Recupero instancia de Sucursal
                    $sucursal = Sucursal::find($request->anticipo1_sucursal);
                    if(!$sucursal instanceof Sucursal) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar sucursal, verifique información ó por favor consulte al administrador.']);
                    }
                    // Recupero instancia regional
                    $regional = Regional::find($sucursal->sucursal_regional);
                    if(!$regional instanceof Regional) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar regional, verifique información ó por favor consulte al administrador.']);
                    }
                    // consecutive
                    $consecutive = $regional->regional_anti + 1;

                    $anticipo1->fill($data);
                    $anticipo1->anticipo1_sucursal = $sucursal->id;
                    $anticipo1->anticipo1_numero = $consecutive;
                    $anticipo1->anticipo1_tercero = $tercero->id;
                    $anticipo1->anticipo1_cuentas = $cuentabanco->id;
                    $anticipo1->anticipo1_vendedor = $vendedor->id;
                    $anticipo1->anticipo1_documentos = $documento->id;
                    $anticipo1->anticipo1_valor = $request->anticipo1_valor;
                    $anticipo1->anticipo1_saldo = $request->anticipo1_valor;
                    $anticipo1->anticipo1_usuario_elaboro = Auth::user()->id;
                    $anticipo1->anticipo1_fh_elaboro = date('Y-m-d H:m:s');
                    $anticipo1->save();

                    // Anticipo2
                    foreach ($data['anticipo2'] as $value) {

                        // Recupero instancia de MedioPago
                        $mediopago = MedioPago::find($value['anticipo2_mediopago']);
                        if (!$mediopago instanceof MedioPago) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar medio de pago, verifique información ó por favor consulte al administrador.']);
                        }
                        // Cuando es cheque o tarjeta estos vienen con datos que hay que guardar
                        if ( !isset($value['anticipo2_banco_medio']) && isset($value['anticipo2_numero_medio']) && isset($value['anticipo2_vence_medio']) ) {

                            // Recupero instancia de Banco
                            $banco = Banco::find($value['anticipo2_banco_medio']);
                            if (!$banco instanceof Banco) {
                                DB::rollback();
                                return response()->json(['success' => false, 'errors' => 'No es posible recuperar banco, verifique información ó por favor consulte al administrador.']);
                            }
                        }
                        $anticipo2 = new Anticipo2;
                        $anticipo2->anticipo2_anticipo1 = $anticipo1->id;
                        $anticipo2->anticipo2_mediopago = $mediopago->id;
                        $anticipo2->anticipo2_valor = $value['anticipo2_valor'];
                        $anticipo2->anticipo2_banco_medio = ($value['anticipo2_banco_medio'] == "") ? null : $value['anticipo2_banco_medio'] ;
                        $anticipo2->anticipo2_numero_medio = $value['anticipo2_numero_medio'];
                        $anticipo2->anticipo2_vence_medio = empty($value['anticipo2_vence_medio']) ? date('Y-m-d H:m:s') : $value['anticipo2_vence_medio'];
                        $anticipo2->save();
                    }

                    // Reference variables prepare asiento
                    $detalle = $encabezado = [];
                    $credito = $debito = 0;

                    // Anticipo3
                    $items3 = isset($data['anticipo3']) ? $data['anticipo3'] : null;
                    foreach ($items3 as $value) {
                        //Recuperar Conceptosrc-DocumentosConceptosrc
                        $conceptosrc = Conceptosrc::find($value['anticipo3_conceptosrc']);
                        if(!$conceptosrc instanceof Conceptosrc) {
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar concepto, verifique información ó por favor consulte al administrador.']);
                        }
                        $anticipo3 = new Anticipo3;
                        $anticipo3->fill($value);
                        $anticipo3->anticipo3_anticipo1 = $anticipo1->id;
                        $anticipo3->anticipo3_conceptosrc = $conceptosrc->id;
                        $anticipo3->save();

                        // Credito y debito
                        $credito +=  ($anticipo3->anticipo3_naturaleza == 'C') ? $anticipo3->anticipo3_valor : 0;
                        $debito +=  ($anticipo3->anticipo3_naturaleza == 'D') ? $anticipo3->anticipo3_valor : 0;

                        // Preparando detalle asiento
                        $result = $anticipo1->detalleAsiento($anticipo3, $tercero, $conceptosrc);
                        if(!is_array($result)){
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => $result]);
                        }
                        $detalle[] = $result;
                    }

                    // Encabezado Asiento
                    $encabezado = $anticipo1->encabezadoAsiento($tercero, $cuentabanco, $credito, $debito);
                    if(!is_object($encabezado)){
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $encabezado]);
                    }
                    $detalle[] = $encabezado->cuenta;

                    // Creo el objeto para manejar el asiento
                    $objAsiento = new AsientoContableDocumento($encabezado->data);
                    if($objAsiento->asiento_error) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => $objAsiento->asiento_error]);
                    }
                    // Preparar asiento
                    $result = $objAsiento->asientoCuentas($detalle);
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
                        $result = $objAsientoNif->asientoCuentas($detalle);
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
                        $anticipo1->anticipo1_asienton = $objAsientoNif->asientoNif->id;
                    }
                    $anticipo1->anticipo1_asiento = $objAsiento->asiento->id;
                    $anticipo1->save();

                    // Update consecutive regional_anti in Regional
                    $regional->regional_anti = $consecutive;
                    $regional->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $anticipo1->id]);
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $anticipo1->errors]);
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
        $anticipo1 = Anticipo1::getAnticipo($id);
        if(!$anticipo1 instanceof Anticipo1) {
            abort(404);
        }
         if($request->ajax()) {
            return response()->json($anticipo1);
        }
        return view('cartera.anticipos.show', ['anticipo1' => $anticipo1]);
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
