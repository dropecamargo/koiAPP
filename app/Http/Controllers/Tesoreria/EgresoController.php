<?php

namespace App\Http\Controllers\Tesoreria;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Tesoreria\Egreso1, App\Models\Tesoreria\Egreso2, App\Models\Tesoreria\Facturap1, App\Models\Tesoreria\Facturap3, App\Models\Tesoreria\TipoPago;
use App\Models\Base\Tercero,App\Models\Base\Documentos, App\Models\Base\Regional;
use App\Models\Cartera\CuentaBanco;
use DB, Log, Datatables, Auth, App, View;

class EgresoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Egreso1::query();
            $query->select('egreso1.*', DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre"), 'regional_nombre'
            );
            $query->join('tercero','egreso1_tercero', '=', 'tercero.id');
            $query->join('regional','egreso1_regional', '=', 'regional.id');
            $query->orderBy('egreso1.id', 'desc');
            return Datatables::of($query->get())->make(true);
        }
        return view('tesoreria.egreso.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tesoreria.egreso.create');
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
            $egreso = new Egreso1;
            if ($egreso->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recuperar documentos
                    $documento = Documentos::where('documentos_codigo', Egreso1::$default_document)->first();
                    if(!$documento instanceof Documentos) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar documentos,por favor verifique la información ó por favor consulte al administrador.']);
                    }

                    // Recuperar tercero
                    $tercero = Tercero::where('tercero_nit', $request->egreso1_tercero)->first();
                    if(!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cliente, verifique información ó por favor consulte al administrador.']);
                    }
                    // Recuperar cuentabanco
                    $cuentabanco = CuentaBanco::find($request->egreso1_cuentas);
                    if(!$cuentabanco instanceof CuentaBanco) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar la cuenta, verifique información ó por favor consulte al administrador.']);
                    }
                    // Recuperar regional
                    $regional = Regional::find($request->egreso1_regional);
                    if(!$regional instanceof Regional) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar regional, verifique información ó por favor consulte al administrador.']);
                    }

                    // Consecutive
                    $consecutive = $regional->regional_egre + 1;

                    // Egreso
                    $egreso->fill($data);
                    $egreso->egreso1_regional = $regional->id;
                    $egreso->egreso1_numero = $consecutive;
                    $egreso->egreso1_documentos = $documento->id;
                    $egreso->egreso1_tercero = $tercero->id;
                    $egreso->egreso1_cuentas = $cuentabanco->id;
                    $egreso->egreso1_usuario_elaboro = Auth::user()->id;
                    $egreso->egreso1_fh_elaboro = date('Y-m-d H:m:s');
                    $egreso->save();

                    // Egreso2
                    foreach ($data['detalle'] as $item) {
                        $tercero = Tercero::orWhere('tercero_nit', $item['egreso2_tercero'] )->orWhere('id', $item['egreso2_tercero'])->first();
                        if (!$tercero instanceof Tercero) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar tercero, por favor verifique ó consulte con el administrador.']);
                        }
                        // Recupero tipo pago
                        $tipopago = TipoPago::find($item['egreso2_tipopago']);
                        if (!$tipopago instanceof TipoPago) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar concepto recibo de caja, por favor verifique ó consulte con el administrador.']);
                        }

                        $egreso2 = new Egreso2;
                        $egreso2->fill($item);
                        $egreso2->egreso2_egreso1 = $egreso->id;
                        $egreso2->egreso2_tipopago = $tipopago->id;
                        $egreso2->egreso2_tercero = $tercero->id;
                        $egreso2->egreso2_documentos_doc = $tipopago->tipopago_documentos;
                        $egreso2->egreso2_valor = $item['egreso2_valor'];

                        if( isset($item['facturap3_id']) ) {
                            $facturap3 = Facturap3::where('id',$item['facturap3_id'])->where('facturap3_facturap1', $item['egreso2_facturap1'])->first();
                            if( !$facturap3 instanceof Facturap3 ){
                                DB::rollback();
                                return response()->json(['success'=>false, 'errors'=>'No es posible recuperar el numero de la factura, por favor verifique ó consulte con el administrador.']);
                            }

                            $facturap1 = Facturap1::where( 'id', $facturap3->facturap3_facturap1 )->where('facturap1_tercero', $tercero->id)->first();
                            if( !$facturap1 instanceof Facturap1 ){
                                DB::rollback();
                                return response()->json(['success'=>false, 'errors'=>"La factura #$facturap3->facturap1_numero ingresada no corresponde al cliente, por favor verifique ó consulte con el administrador."]);
                            }

                            $facturap3->facturap3_saldo = $facturap3->facturap3_saldo <= 0 ? $facturap3->facturap3_saldo + $item['facturap3_valor'] : $facturap3->facturap3_saldo - $item['facturap3_valor'];
                            $facturap3->save();
                            $egreso2->egreso2_id_doc = $facturap3->facturap3_facturap1;
                        }

                        if(!empty($item['facturap3_valor'])){
                            $egreso2->egreso2_valor = $item['facturap3_valor'];
                        }
                        $egreso2->save();
                    }
                    // Update consecutive regional_egre in Regional
                    $regional->regional_egre = $consecutive;
                    $regional->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $egreso->id]);
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $egreso->errors]);
        }

        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $egreso = Egreso1::getEgreso($id);
        if ($request->ajax()) {
            return response()->json($egreso);
        }
        return view('tesoreria.egreso.show', ['egreso' => $egreso]);
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
    /**
     * Anular the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function anular(Request $request, $id)
    {
        if ($request->ajax()) {
            $egreso = Egreso1::findOrFail($id);
            DB::beginTransaction();
            try {

                // Egreso
                $egreso->egreso1_anulado = true;
                $egreso->egreso1_usuario_anulo = Auth::user()->id;
                $egreso->egreso1_fh_anulo = date('Y-m-d H:m:s');
                $egreso->save();

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'msg' => 'Egreso anulado con exito.']);
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
    /**
     * Export pdf the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function exportar($id)
    {
        $egreso = Egreso1::getEgreso($id);
        if(!$egreso instanceof Egreso1){
            abort(404);
        }

        $detalle = Egreso2::getEgreso2($egreso->id);
        $title = sprintf('Egreso N° %s', $egreso->egreso1_numero);

        // Export pdf
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML(View::make('tesoreria.egreso.export',  compact('egreso', 'detalle', 'title'))->render());
        return $pdf->stream(sprintf('%s_%s_%s_%s.pdf', 'egreso', $egreso->id, date('Y_m_d'), date('H_m_s')));
    }
}
