<?php

namespace App\Http\Controllers\Reporte;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
        if( env('APP_ENV') == 'local'){
            ini_set('memory_limit', '-1');
            set_time_limit(0);
        }
        if ($request->has('type')) {
            $auxcontable = [];

            $cuentas = PlanCuenta::whereBetween('plancuentas_cuenta', [$request->filter_cuenta_inicio, $request->filter_cuenta_fin])->get();
            $startDate = strtotime($request->filter_fecha_inicial);
            $endDate = strtotime($request->filter_fecha_final);
            foreach ($cuentas as $cuenta) {

                while ($startDate <= $endDate) {
                    $query = Asiento2::query();
                    $query->select('asiento2_debito as debito', 'asiento2_credito as credito', 'asiento2_base as base','asiento1_numero',DB::raw("CONCAT(asiento1_ano,'-',asiento1_mes,'-',asiento1_dia) as date"),'tercero_nit', DB::raw("(CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,'',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2, (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)) ELSE tercero_razonsocial END) AS tercero_nombre"), 'documento_nombre', 'plancuentas.plancuentas_cuenta as cuenta');
                    $query->join('asiento1','asiento2_asiento','=','asiento1.id');
                    $query->join('tercero', 'asiento2_beneficiario', '=', 'tercero.id');
                    $query->join('documento', 'asiento1_documento', '=', 'documento.id');
                    $query->join('plancuentas', 'asiento2_cuenta', '=', 'plancuentas.id');
                    $query->where('asiento1.asiento1_ano', date('Y', $startDate));
                    $query->where('asiento1.asiento1_mes', date('m', $startDate));
                    $query->where('asiento1.asiento1_dia', date('d', $startDate));
                    $query->where('asiento2.asiento2_cuenta', $cuenta->id);
                    if ($request->has('filter_tercero')) {
                        $tercero = Tercero::where('tercero_nit',$request->filter_tercero)->first();
                        // Validate Tercero (?)
                        $query->where('asiento2_beneficiario', $tercero->id);
                    }
                    $query->orderBy('asiento1.asiento1_ano', 'desc');
                    $query->orderBy('asiento1.asiento1_mes', 'asc');
                    $query->orderBy('asiento1.asiento1_dia', 'asc');

                    if (!$query->get()->isEmpty()) {
                        $auxcontable[] = $query->get();
                    }
                    // Increment days
                    $startDate = strtotime("+1 day", $startDate);
                }
                $startDate = strtotime($request->filter_fecha_inicial);
            }
            // Prepare data
            $title = "Auxiliar contable $request->filter_fecha_inicial / $request->filter_fecha_final";
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
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadHTML(View::make('reportes.contabilidad.auxcontable.report',  compact('auxcontable', 'title', 'type'))->render());
                    $pdf->setPaper('A4', 'landscape')->setWarnings(false);
                    return $pdf->stream(sprintf('%s_%s_%s.pdf', 'auxcontable', date('Y_m_d'), date('H_m_s')));
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
