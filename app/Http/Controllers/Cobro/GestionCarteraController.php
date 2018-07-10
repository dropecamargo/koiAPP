<?php

namespace App\Http\Controllers\Cobro;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Base\Tercero, App\Models\Cobro\ContactoDeudor, App\Models\Cobro\Deudor, App\Models\Cobro\DocumentoCobro;
use DB, Log, App, Excel;

class GestionCarteraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cobro.gestioncarteras.index');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        if( isset($request->file) ){
            // Begin validator type file && tercero required
            if ( !in_array($request->file->guessClientExtension(), ['xls', 'xml', 'xlsx', 'csv']) ){
                return response()->json(['success' => false, 'errors' => "Por favor, seleccione un archivo excel valido, los formatos valido son: xls, xml, csv, xlsx."]);
            }

            // Validar que hayan ingresado tercero
            if( !$request->has('searchgestioncartera_tercero') ){
                return response()->json(['success' => false, 'errors' => "Por favor ingrese un tercero para importar."]);
            }


            DB::beginTransaction();
            try {
                // Recuperar Tercero
                $tercero = Tercero::where('tercero_nit', $request->searchgestioncartera_tercero)->first();
                if(!$tercero instanceof Tercero){
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => "No es posible recuperar el tercero con documento '$request->searchgestioncartera_tercero', por favor verifique la información o consulte al administrador."]);
                }

                // Recuperar archivo excel y recorrerlo
                $excel = Excel::load($request->file)->get();
                foreach ($excel as $row) {

                    // Campos para deudor
                    if(!empty($row->deudornit)){
                        $deudor = new Deudor;
                        $deudor->deudor_tercero = $tercero->id;
                        $deudor->deudor_nit = $row->deudornit;
                        $deudor->deudor_digito = $row->deudordigito;
                        $deudor->deudor_razonsocial = $row->deudorrazonsocial;
                        $deudor->deudor_nombre1 = !empty($row->deudornombre1) ? $row->deudornombre1 : '';
                        $deudor->deudor_nombre2 = !empty($row->deudornombre2) ? $row->deudornombre2 : '';
                        $deudor->deudor_apellido1 = !empty($row->deudorapellido1) ? $row->deudorapellido1 : '';
                        $deudor->deudor_apellido2 = !empty($row->deudorapellido2) ? $row->deudorapellido2 : '';
                        $deudor->save();
                    }

                    // Campos para el documento cobro
                    $docdeudor = Deudor::where('deudor_nit', $row->documentonitdeudor)->where('deudor_tercero', $tercero->id)->first();
                    if($docdeudor instanceof Deudor){
                        $documentocobro = new DocumentoCobro;
                        $documentocobro->documentocobro_deudor = $docdeudor->id;
                        $documentocobro->documentocobro_tipo = $row->documentotipo;
                        $documentocobro->documentocobro_numero = $row->documentonumero;
                        $documentocobro->documentocobro_expedicion = $row->documentoexpedicion;
                        $documentocobro->documentocobro_vencimiento = $row->documentovencimiento;
                        $documentocobro->documentocobro_cuota = $row->documentocuota;
                        $documentocobro->documentocobro_valor = $row->documentovalor;
                        $documentocobro->documentocobro_saldo = $row->documentosaldo;
                        $documentocobro->save();
                    }

                    // Campos para el contacto del deudor
                    $contacdeudor = Deudor::where('deudor_nit', $row->contactonitdeudor)->first();
                    if($contacdeudor instanceof Deudor){
                        $contactodeudor = new ContactoDeudor;
                        $contactodeudor->contactodeudor_deudor = $contacdeudor->id;
                        $contactodeudor->contactodeudor_nombre = $row->contactonombre;
                        $contactodeudor->contactodeudor_direccion = $row->contactodireccion;
                        $contactodeudor->contactodeudor_telefono = $row->contactotelefono;
                        $contactodeudor->contactodeudor_movil = $row->contactomovil;
                        $contactodeudor->contactodeudor_email = $row->contactoemail;
                        $contactodeudor->contactodeudor_cargo = $row->contactocargo;
                        $contactodeudor->save();
                    }
                }

                DB::commit();
                return response()->json(['success'=> true, 'msg'=> 'Se importo con exito el archivo.']);
            } catch (\Exception $e) {
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        return response()->json(['success' => false, 'errors' => "Por favor, seleccione un archivo."]);
    }
}
