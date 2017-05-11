<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Cartera\Nota1, App\Models\Cartera\Nota2, App\Models\Cartera\ConceptoNota, App\Models\Cartera\Factura3;
use App\Models\Base\Sucursal, App\Models\Base\Tercero, App\Models\Base\Documentos;
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
                    //

                    // Consecutive
                    $consecutive = $sucursal->sucursal_nota + 1;

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

                    $nota2 = isset($data['nota2']) ? $data['nota2'] : null;
                    foreach ($nota2 as $item)
                    {
                        $factura3 = Factura3::where( 'factura3_factura1', $item['nota2_factura1'] )->join('factura1', 'factura3_factura1', '=', 'factura1.id')->select('factura3.*', 'factura1_numero')->first();
                        if( !$factura3 instanceof Factura3 ){
                            DB::rollback();
                            return response()->json(['success'=>false, 'errors'=>'No es posible recuperar el numero de la factura, por favor verifique ó consulte con el administrador.']);
                        }

                        $factura3->factura3_saldo = $factura3->factura3_saldo <= 0 ? $factura3->factura3_saldo + $item['nota2_valor'] : $factura3->factura3_saldo - $item['nota2_valor'];
                        $factura3->save();

                        $nota2 = new Nota2;
                        $nota2->fill($item);
                        $nota2->nota2_nota1 = $nota->id;
                        $nota2->nota2_documentos_doc = $item['nota2_documentos_doc'];
                        $nota2->nota2_id_doc = $factura3->id;
                        $nota2->save();
                    }

                    // Update consecutive sucursal_reci in Sucursal
                    $sucursal->sucursal_nota = $consecutive;
                    $sucursal->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $nota->id]);
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
