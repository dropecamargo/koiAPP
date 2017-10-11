<?php

namespace App\Http\Controllers\Reporte;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Base\Tercero;
use App\Models\Cartera\Ajustec2;
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
            $query = null;
            $historyClient = null;
            /* Begin filters */
            if ($request->has('filter_tercero')) {

                $tercero =  Tercero::select('id', DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre"))->where('tercero_nit', $request->filter_tercero)->first();
                
                $query = Ajustec2::query();
                $query->select('ajustec2.*', 'documentos_nombre', 'ajustec1_numero','ajustec1_fh_elaboro' ,'conceptoajustec_plancuentas');
                $query->where('ajustec2_tercero', $tercero->id);
                $query->join('tercero', 'ajustec2_tercero', '=', 'tercero.id');
                $query->join('ajustec1', 'ajustec1.id', '=', 'ajustec2_ajustec1');
                $query->join('documentos', 'documentos.id', '=', 'ajustec2_documentos_doc');
                $query->join('conceptoajustec', 'conceptoajustec.id', '=', 'ajustec1_conceptoajustec');
                $historyClient = $query->get();
                // dd($historyClient);
                // if ($request->has('filter_fecha_inicio') && $request->has('filter_fecha_fin')) {
                // }
            }
            /* End filters */

            // dd($request->all()); 

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
