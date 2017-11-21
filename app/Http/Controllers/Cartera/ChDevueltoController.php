<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Cartera\ChDevuelto,App\Models\Cartera\ChposFechado1,App\Models\Cartera\Causal;
use App\Models\Base\Tercero,App\Models\Base\Documentos,App\Models\Base\Regional,App\Models\Base\Sucursal;

use DB, Log, Datatables,Auth;

class ChDevueltoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = ChDevuelto::query();

            if ( $request->has('datatables') ) {
                $query->select('chdevuelto.*', 'tercero_nit', 'tercero_razonsocial', 'tercero_nombre1', 'tercero_nombre2', 'tercero_apellido1', 'tercero_apellido2','sucursal_nombre','banco_nombre',DB::raw("(CASE WHEN tercero_persona = 'N'
                        THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                                (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                            )
                        ELSE tercero_razonsocial END)
                    AS tercero_nombre"), 'chposfechado1_banco', 'chposfechado1_sucursal','chposfechado1_ch_numero'
                );
                $query->join('tercero','chdevuelto_tercero', '=', 'tercero.id');
                $query->join('chposfechado1', 'chdevuelto_chposfechado1', '=', 'chposfechado1.id');
                $query->join('banco','chposfechado1_banco', '=', 'banco.id');
                $query->join('sucursal','chdevuelto_sucursal', '=', 'sucursal.id');
                $query->orderBy('chdevuelto.id', 'desc');
                return Datatables::of($query)->make(true);
            }

            // Fetch desde cartera action
            if ($request->has('tercero')) {
                $chdevuelto = [];
                $query->select('chdevuelto.*','banco_nombre','chposfechado1_banco','chposfechado1_ch_numero');
                $query->join('chposfechado1', 'chdevuelto_chposfechado1', '=', 'chposfechado1.id');
                $query->join('banco','chposfechado1_banco', '=', 'banco.id');
                $query->where('chdevuelto_tercero',$request->tercero);
                $query->where('chdevuelto_saldo', '<>', 0);
                $chdevuelto = $query->get();
                return response()->json($chdevuelto);
            }
        }
        return view('cartera.chequesdevueltos.index');
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
        if ($request->ajax()) {
            $data = $request->all();
            $chdevuelto = new ChDevuelto;
            if ($chdevuelto->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recupero instancia de Documento
                    $documento = Documentos::where('documentos_codigo' , ChDevuelto::$default_document)->first();
                    if (!$documento instanceof Documentos) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar documentos,por favor verifique la información ó por favor consulte al administrador.']);
                    }
                    // Recupero cheque a devolver
                    $cheque1 = ChposFechado1::find($request->id);
                    if (!$cheque1 instanceof ChposFechado1) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cheque a devolver,por favor verifique la información ó por favor consulte al administrador.']);
                    }
                    // Recupero sucursal de cheque a devolver
                    $sucursal = Sucursal::find($cheque1->chposfechado1_sucursal);
                    if (!$sucursal instanceof Sucursal) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar sucursal de cheque a devolver,por favor verifique la información ó por favor consulte al administrador.']);
                    }
                    // Recupero regional de cheque a devolver
                    $regional = Regional::find($sucursal->sucursal_regional);
                    if (!$regional instanceof Regional) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar regional de cheque a devolver,por favor verifique la información ó por favor consulte al administrador.']);
                    }
                    // Causa de devolucion
                    $causal = Causal::find($request->chdevuelto_causal);
                    if (!$causal instanceof Causal) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar causal, por favor verifique la información ó por favor consulte al administrador.']);
                    }
                    // clear marcacion en factura3
                    $cheque1->clearKey();

                    // Consecutive regional_chd
                    $consecutive = $regional->regional_chd + 1;

                    $chdevuelto->chdevuelto_chposfechado1 = $cheque1->id;
                    $chdevuelto->chdevuelto_sucursal = $sucursal->id;
                    $chdevuelto->chdevuelto_numero = $consecutive;
                    $chdevuelto->chdevuelto_documentos = $documento->id;
                    $chdevuelto->chdevuelto_fecha = $cheque1->chposfechado1_ch_fecha;
                    $chdevuelto->chdevuelto_valor = $cheque1->chposfechado1_valor;
                    $chdevuelto->chdevuelto_saldo = $cheque1->chposfechado1_valor;
                    $chdevuelto->chdevuelto_tercero = $cheque1->chposfechado1_tercero;
                    $chdevuelto->chdevuelto_causal = $causal->id;
                    $chdevuelto->chdevuelto_usuario_elaboro = Auth::user()->id;
                    $chdevuelto->chdevuelto_fh_elaboro = date('Y-m-d H:m:s');
                    $chdevuelto->save();

                    // Cambio de indicativos del cheque a devolver
                    $cheque1->chposfechado1_devuelto = true;
                    $cheque1->save();

                    // Update consecutive regional_chd in Sucursal
                    $regional->regional_chd = $consecutive;
                    $regional->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'msg' => 'Cheque posfechado devuelto con exito.']);
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $chdevuelto->errors]);
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
        $chdevuelto = ChDevuelto::getChequeDevuelto($id);
        if ($request->ajax()) {
            return response()->json($chdevuelto);
        }
        return view('cartera.chequesdevueltos.show', ['chdevuelto' => $chdevuelto]);
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
