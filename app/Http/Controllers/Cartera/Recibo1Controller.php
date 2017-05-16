<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Cartera\Recibo1, App\Models\Cartera\Recibo2, App\Models\Cartera\Factura3, App\Models\Cartera\Factura1;
use App\Models\Base\Documentos, App\Models\Base\Sucursal, App\Models\Base\Tercero;
use App\Models\Cartera\Conceptosrc, App\Models\Cartera\CuentaBanco;
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
            return Datatables::of($query)->make(true);
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
                    //

                    // Consecutive
                    $consecutive = $sucursal->sucursal_reci + 1;

                    // recibo1
                    $recibo1->fill($data);
                    $recibo1->recibo1_tercero = $tercero->id;
                    $recibo1->recibo1_sucursal = $sucursal->id;
                    $recibo1->recibo1_documentos = $documento->id;
                    $recibo1->recibo1_cuentas = $cuentabanco->id;
                    $recibo1->recibo1_usuario_elaboro = Auth::user()->id;
                    $recibo1->recibo1_fh_elaboro = date('Y-m-d H:m:s');
                    $recibo1->save();

                    $recibo2 = isset($data['recibo2']) ? $data['recibo2'] : null;
                    foreach ($recibo2 as $item)
                    {
                        $recibo2 = new Recibo2;
                        $recibo2->fill($item);
                        $recibo2->recibo2_recibo1 = $recibo1->id;


                        if( isset($item['recibo2_factura1']) ){
                            $factura3 = Factura3::where( 'factura3_factura1', $item['recibo2_factura1'] )->join('factura1', 'factura3_factura1', '=', 'factura1.id')->select('factura3.*', 'factura1_numero')->first();
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
                            $factura3->save();

                            $recibo2->recibo2_id_doc = $factura3->id;
                        }

                        if(!empty($item['factura3_valor'])){
                            $recibo2->recibo2_valor = $item['factura3_valor'];
                        }else{
                            $recibo2->recibo2_valor = $item['recibo2_valor'];
                        }
                        $recibo2->save();
                    }

                    // Update consecutive sucursal_reci in Sucursal
                    $sucursal->sucursal_reci = $consecutive;
                    $sucursal->save();

                    // Commit Transaction
                    DB::commit();
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
