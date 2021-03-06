<?php

namespace App\Http\Controllers\Reporte;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Classes\Reports\Accounting\LibroDiario;
use App\Models\Contabilidad\Asiento;
use View, App, Excel, Validator, DB;

class LibroDiarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('type')) {

            $startDate = strtotime($request->filter_fecha_inicial);
            $endDate = strtotime($request->filter_fecha_final);

            $asiento = [];
            while ($startDate <= $endDate) {
                // Reference variables
                $date = date('Y-m-d', $startDate);
                list( $year, $month, $day ) = explode('-', $date);

                // Querie in asiento
                $query = Asiento::query();
                $query->select(DB::raw("SUM(asiento2_debito) as debito, SUM(asiento2_credito) as credito"), 'plancuentas_nombre', 'plancuentas_cuenta');
                $query->join('asiento2', 'asiento1.id', '=', 'asiento2.asiento2_asiento');
                $query->join('plancuentas', 'asiento2.asiento2_cuenta', '=', 'plancuentas.id');
                $query->where('asiento1_ano', $year);
                $query->where('asiento1_mes', $month);
                $query->where('asiento1_dia', $day);
                $query->groupBy('plancuentas_cuenta');

                // Prepare array
                $asiento[$date] = $query->get();

                // Increment days
                $startDate = strtotime("+1 day", $startDate);
            }

            // Prepare data
            $title = "Libro diario desde $request->filter_fecha_inicial hasta $request->filter_fecha_final";
            $type = $request->type;
            $startDate = strtotime($request->filter_fecha_inicial);
            $endDate = strtotime($request->filter_fecha_final);

            switch ($type) {
                case 'xls':
                    Excel::create(sprintf('%s_%s_%s', 'libro menor', date('Y_m_d'), date('H_m_s')), function($excel) use($asiento, $title, $startDate, $endDate, $type) {
                        $excel->sheet('Excel', function($sheet) use($asiento, $title, $startDate, $endDate, $type) {
                            $sheet->loadView('reportes.contabilidad.librodiario.report', compact('asiento', 'title', 'startDate', 'endDate', 'type'));
                        });
                    })->download('xls');
                break;

                case 'pdf':
                    $pdf = new LibroDiario;
                    $pdf->buldReport($asiento, $title);
                break;
            }
        }
        return view('reportes.contabilidad.librodiario.index');
    }
}
