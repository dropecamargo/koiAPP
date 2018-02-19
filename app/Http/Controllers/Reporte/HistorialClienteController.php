<?php

namespace App\Http\Controllers\Reporte;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Base\Tercero, App\Models\Cartera\Ajustec2, App\Models\Cartera\Factura1, App\Models\Cartera\Anticipo1, App\Models\Cartera\Recibo1, App\Models\Cartera\Nota1, App\Models\Cartera\ChposFechado1, App\Models\Cartera\ChDevuelto;
use Excel, View, App, DB;

class HistorialClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('type')) {
            $historyClient = [];
            /* Begin filters */
            if ($request->has('filter_tercero')) {

                $tercero =  Tercero::select('id', DB::raw("(CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,'',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2, (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)) ELSE tercero_razonsocial END) AS tercero_nombre"))->where('tercero_nit', $request->filter_tercero)->first();

                // initial position the array
                $i = 0;

                // querie ajuste cartera
                $ajusteCartera = Ajustec2::historyClientReport($tercero, $historyClient, $i);
                $historyClient = $ajusteCartera->ajusteCartera;
                $i = $ajusteCartera->position;

                // querie factura
                $factura = Factura1::historyClientReport($tercero, $historyClient, $i);
                $historyClient = $factura->factura;
                $i = $factura->position;

                // querie anticipo
                $anticipo = Anticipo1::historyClientReport($tercero, $historyClient, $i);
                $historyClient = $anticipo->anticipo;
                $i = $anticipo->position;

                // querie recibos
                $recibo = Recibo1::historyClientReport($tercero, $historyClient, $i);
                $historyClient = $recibo->recibo;
                $i = $recibo->position;

                // querie notas
                $nota = Nota1::historyClientReport($tercero, $historyClient, $i);
                $historyClient = $nota->nota;
                $i = $nota->position;

                // querie cheques
                $cheque = ChposFechado1::historyClientReport($tercero, $historyClient, $i);
                $historyClient = $cheque->cheque;
                $i = $cheque->position;

                // querie cheques devueltos
                $chequeDevuelto = ChDevuelto::historyClientReport($tercero, $historyClient, $i);
                $historyClient = $chequeDevuelto->chequeDevuelto;
                $i = $chequeDevuelto->position;
            }
            /* End filters */

            // Prepare data
            $title = "Historial del cliente $tercero->tercero_nombre";
            $type = $request->type;

            switch ($type) {
                case 'xls':
                    Excel::create(sprintf('%s_%s_%s', 'historyClient', date('Y_m_d'), date('H_m_s')), function($excel) use($historyClient, $title, $type) {
                        $excel->sheet('Excel', function($sheet) use($historyClient, $title, $type) {
                            $sheet->loadView('reportes.cartera.historialclientes.reporte', compact('historyClient', 'title', 'type'));
                        });
                    })->download('xls');
                break;

                case 'pdf':
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadHTML(View::make('reportes.cartera.historialclientes.reporte',  compact('historyClient', 'title', 'type'))->render());
                    $pdf->setPaper('letter', 'landscape')->setWarnings(false);
                    return $pdf->stream(sprintf('%s_%s_%s.pdf', 'historyClient', date('Y_m_d'), date('H_m_s')));
                break;
            }
        }

        return view('reportes.cartera.historialclientes.index');
    }
}
