<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Cartera\Ajustec1, App\Models\Cartera\Ajustec2, App\Models\Cartera\ConceptoAjustec, App\Models\Cartera\Factura3;
use App\Models\Base\Tercero, App\Models\Base\Sucursal, App\Models\Base\Documentos;
use DB, Log, Cache, Datatables, Auth;

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

                    $conceptoajustec = ConceptoAjustec::find($request->ajustec1_conceptoajustec);
                    if(!$conceptoajustec instanceof ConceptoAjustec) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el concepto, verifique información ó por favor consulte al administrador.']);
                    }

                    // Consecutive
                    $consecutive = $sucursal->sucursal_ajuc + 1;

                    // ajustec
                    $ajustec->fill($data);
                    $ajustec->ajustec1_sucursal = $sucursal->id;
                    $ajustec->ajustec1_tercero = $tercero->id;
                    $ajustec->ajustec1_documentos = $documento->id;
                    $ajustec->ajustec1_conceptoajustec = $conceptoajustec->id;
                    $ajustec->ajustec1_usuario_elaboro = Auth::user()->id;
                    $ajustec->ajustec1_fh_elaboro = date('Y-m-d H:m:s');
                    $ajustec->save();

                    $detalle = isset($data['detalle']) ? $data['detalle'] : null;
                    foreach ($detalle as $item)
                    {

                        // Recuperar tercero || factura3 || documento
                        if(isset($item['factura3_id'])){
                            $tercero = Tercero::getTercero($item['ajustec2_tercero']);
                        }else{
                            $tercero = Tercero::where('tercero_nit',$item['ajustec2_tercero'])->first();
                        }
                        if(!$tercero instanceof Tercero){
                            DB::rollback();
                            return response()->json(['success'=>false, 'errors'=>'No es posible recuperar cliente, verifique información ó por favor consulte al administrador.']);
                        }

                        $documentos = Documentos::find($item['ajustec2_documentos_doc']);
                        if(!$documentos instanceof Documentos){
                            DB::rollback();
                            return response()->json(['success'=>false, 'errors'=>'No es posible recuperar documento, verifique información ó por favor consulte al administrador.']);
                        }
                            
                        $ajustec2 = new Ajustec2;
                        $ajustec2->ajustec2_ajustec1 = $ajustec->id;
                        $ajustec2->ajustec2_naturaleza = $item['ajustec2_naturaleza'];
                        $ajustec2->ajustec2_tercero = $tercero->id;
                        $ajustec2->ajustec2_documentos_doc = $documentos->id;

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
                            $factura3->save();

                            $ajustec2->ajustec2_id_doc = $factura3->id;
                        }
                        
                        if( !empty($item['factura3_valor']) ){
                            $ajustec2->ajustec2_valor = $item['factura3_valor'];
                        }else{
                            $ajustec2->ajustec2_valor = $item['ajustec2_valor'];
                        }
                        $ajustec2->save();
                    }

                    // Update consecutive sucursal_reci in Sucursal
                    $sucursal->sucursal_ajuc = $consecutive;
                    $sucursal->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $ajustec->id]);
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
