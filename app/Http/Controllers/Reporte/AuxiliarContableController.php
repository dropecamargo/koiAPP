<?php

namespace App\Http\Controllers\Reporte;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Classes\Reports\Accounting\AuxiliarContable;
use App\Models\Contabilidad\Asiento2, App\Models\Contabilidad\PlanCuenta;
use App\Models\Base\Tercero;

use View, App, Excel, Validator, DB;

class AuxiliarContableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('type')) {
            list($año, $mes, $dia) = (explode('-',$request->filter_fecha_inicial));
            list($añoF, $mesF, $diaF) = (explode('-',$request->filter_fecha_final));

            $fechaI = sprintf('%s-%s-%s', intval($año), intval($mes), intval($dia));
            $fechaF = sprintf('%s-%s-%s', intval($añoF), intval($mesF), intval($diaF));

            $query = Asiento2::query();
            $query->select('asiento2_debito as debito', 'asiento2_credito as credito', 'asiento2_base as base', 'asiento1_numero', DB::raw("CONCAT(asiento1_ano,'-',asiento1_mes,'-',asiento1_dia) as date"),'tercero_nit', DB::raw("(CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,'',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2, (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)) ELSE tercero_razonsocial END) AS tercero_nombre"), 'documento_nombre', 'plancuentas_cuenta as cuenta', 'plancuentas_nombre');
            $query->join('asiento1','asiento2_asiento','=','asiento1.id');
            $query->join('tercero', 'asiento2_beneficiario', '=', 'tercero.id');
            $query->join('documento', 'asiento1_documento', '=', 'documento.id');
            $query->join('plancuentas', 'asiento2_cuenta', '=', 'plancuentas.id');
            $query->whereRaw("CONCAT(asiento1_ano,'-',asiento1_mes,'-',asiento1_dia) >= '$fechaI'");
            $query->whereRaw("CONCAT(asiento1_ano,'-',asiento1_mes,'-',asiento1_dia) <= '$fechaF'");
            $query->whereRaw("plancuentas_cuenta >= '$request->filter_cuenta_inicio'");
            $query->whereRaw("plancuentas_cuenta <= '$request->filter_cuenta_fin'");

            if ($request->has('filter_tercero')) {
                $tercero = Tercero::where('tercero_nit',$request->filter_tercero)->first();
                // Validate Tercero
                if (!$tercero instanceof Tercero) {
                    return redirect('/rauxcontable')
                    ->withErrors("No es posible recuperar tercero, por favor verifique la información o consulte al administrador.")
                    ->withInput();
                }
                $query->where('asiento2_beneficiario', $tercero->id);
            }
            $query->orderBy('asiento1.asiento1_ano', 'desc');
            $query->orderBy('asiento1.asiento1_mes', 'asc');
            $query->orderBy('asiento1.asiento1_dia', 'asc');

            // Prepare data
            $auxcontable = $query->get();
            $title = "Auxiliar contable desde $request->filter_fecha_inicial hasta $request->filter_fecha_final";
            $type = $request->type;


            switch ($type) {
                case 'xls':
                    Excel::create(sprintf('%s_%s_%s', 'auxcontable', date('Y_m_d'), date('H_m_s')), function($excel) use($auxcontable, $title, $type) {
                        $excel->sheet('Excel', function($sheet) use($auxcontable, $title, $type) {
                            $sheet->loadView('reportes.contabilidad.auxcontable.report', compact('auxcontable', 'title', 'type'));
                        });
                    })->download('xls');
                break;

                case 'pdf':
                    $pdf = new AuxiliarContable('L','mm','A4');
                    $pdf->buldReport($auxcontable, $title);
                break;
            }
        }
        return view('reportes.contabilidad.auxcontable.index');
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
}
