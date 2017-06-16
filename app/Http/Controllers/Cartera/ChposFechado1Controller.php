<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Cartera\ChposFechado1,App\Models\Cartera\ChposFechado2,App\Models\Cartera\Factura1,App\Models\Cartera\Factura3,App\Models\Cartera\Banco;
use App\Models\Base\Tercero,App\Models\Base\Documentos,App\Models\Base\Sucursal;

use DB, Log, Datatables,Auth;

class ChposFechado1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = ChposFechado1::query();
            $query->select('chposfechado1.*', 'tercero_nit', 'tercero_razonsocial', 'tercero_nombre1', 'tercero_nombre2', 'tercero_apellido1', 'tercero_apellido2','sucursal_nombre','banco_nombre',DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            );
            $query->join('tercero','chposfechado1_tercero', '=', 'tercero.id');
            $query->join('banco','chposfechado1_banco', '=', 'banco.id');
            $query->join('sucursal','chposfechado1_sucursal', '=', 'sucursal.id');
            return Datatables::of($query)->make(true);
        }
        return view('cartera.cheques.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cartera.cheques.create');
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
            $cheque1 = new ChposFechado1;
            if ($cheque1->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Recupero instancia de Documento  
                    $documento = Documentos::where('documentos_codigo' , ChposFechado1::$default_document)->first();
                    if (!$documento instanceof Documentos) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar documentos,por favor verifique la información ó por favor consulte al administrador.']);
                    }
                    // Recupero instancia de Sucursal  
                    $sucursal = Sucursal::find($request->chposfechado1_sucursal);
                    if(!$sucursal instanceof Sucursal) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar sucursal, verifique información ó por favor consulte al administrador.']);
                    }
                    // Recupero instancia de Tercero(cliente)  
                    $tercero = Tercero::where('tercero_nit', $request->chposfechado1_tercero)->first();
                    if(!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cliente, verifique información ó por favor consulte al administrador.']);
                    }  
                    // Recupero instancia de Banco
                    $banco = Banco::find($request->chposfechado1_banco);
                    if (!$banco instanceof Banco) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar banco, verifique información ó por favor consulte al administrador.']);
                    }

                    $consecutive = $sucursal->sucursal_chp + 1;

                    // chposfechado1
                    $cheque1->fill($data);
                    $cheque1->chposfechado1_sucursal =  $sucursal->id;
                    $cheque1->chposfechado1_numero =  $consecutive;
                    $cheque1->chposfechado1_documentos =  $documento->id;
                    $cheque1->chposfechado1_tercero =  $tercero->id;
                    $cheque1->chposfechado1_banco =  $banco->id;
                    $cheque1->chposfechado1_central_riesgo =  ($request->chposfechado1_central_riesgo == "1") ? 1 :'';
                    $cheque1->chposfechado1_usuario_elaboro = Auth::user()->id;
                    $cheque1->chposfechado1_fh_elaboro = date('Y-m-d H:m:s');
                    $cheque1->save();

                    //  chposfechado2
                    foreach ($data['detalle'] as $item)
                    {
                        $cheque2 = new ChposFechado2;
                        $cheque2->fill($item);
                        $cheque2->chposfechado2_chposfechado1 = $cheque1->id;
                        if( isset($item['factura3_id']) ){
                            $factura3 = Factura3::find( $item['factura3_id'] );
                            if( !$factura3 instanceof Factura3 ){
                                DB::rollback();
                                return response()->json(['success'=>false, 'errors'=>'No es posible recuperar el numero de la factura, por favor verifique ó consulte con el administrador.']);
                            }

                            $factura = Factura1::where( 'id', $factura3->factura3_factura1 )->where('factura1_tercero', $tercero->id)->first();
                            if( !$factura instanceof Factura1 ){
                                DB::rollback();
                                return response()->json(['success'=>false, 'errors'=>"La factura #$factura3->factura1_numero ingresada no corresponde al cliente, por favor verifique ó consulte con el administrador."]);   
                            }

                            $factura3->factura3_chposfechado1 = $cheque1->id;
                            $factura3->save();

                            $cheque2->chposfechado2_id_doc = $factura3->id;
                        }

                        if(!empty($item['factura3_valor'])){
                            $cheque2->chposfechado2_valor = $item['factura3_valor'];
                        }else{
                            $cheque2->chposfechado2_valor = $item['chposfechado2_valor'];
                        }
                        $cheque2->save();
                    }
                    // Update consecutive sucursal_chp in Sucursal
                    $sucursal->sucursal_chp = $consecutive;
                    $sucursal->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $cheque1->id ]);
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $cheque1->errors]);
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
        $cheque = ChposFechado1::getCheque($id);
        if ($request->ajax()) {
            return response()->json($cheque);
        }
        return view('cartera.cheques.show', ['chposfechado1' => $cheque]);
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
            $chposfechado1 = ChposFechado1::findOrFail($id);
            DB::beginTransaction();
            try {
                // Cheque posfechado
                $chposfechado1->chposfechado1_anulado = true;
                $chposfechado1->chposfechado1_activo = false;
                $chposfechado1->chposfechado1_usuario_anulo = Auth::user()->id;
                $chposfechado1->chposfechado1_fh_anulo = date('Y-m-d H:m:s');
                $chposfechado1->save();
                // Quita llaves de factura 3
                if(!$chposfechado1->clearKey()){
                    DB::rollback();
                    return response()->json(['success' => false , 'errors' => 'Cheque posfechado NO puede ser anulado']);
                }

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'msg' => 'Cheque posfechado anulado con exito.']);
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
