<?php

namespace App\Http\Controllers\Reporte;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HistorialProveedorController extends Controller
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
            $historyProveider = null;
            
            /* Begin filters */
            if ($request->has('filter_tercero')) {

            }
            
            if ($request->has('filter_fecha_inicio') && $request->has('filter_fecha_fin')) {

            }
            /* End filters */

            // dd($request->all()); 

            // Prepare data
            $title = "Historial del proveedor...";
            $type = $request->type;

            switch ($type) {
                case 'xls':
                    Excel::create(sprintf('%s_%s_%s', 'historyProveider', date('Y_m_d'), date('H_m_s')), function($excel) use($historyProveider, $title, $type) {
                        $excel->sheet('Excel', function($sheet) use($historyProveider, $title, $type) {
                            $sheet->loadView('reportes.tesoreria.historialproveedores.reporte', compact('historyProveider', 'title', 'type'));
                        });
                    })->download('xls');
                break;

                case 'pdf':
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadHTML(View::make('reportes.tesoreria.historialproveedores.reporte',  compact('historyProveider', 'title', 'type'))->render());
                    $pdf->setPaper('letter', 'landscape')->setWarnings(false);
                    return $pdf->stream(sprintf('%s_%s_%s.pdf', 'historyProveider', date('Y_m_d'), date('H_m_s')));
                break;
            }
        }
        return view('reportes.tesoreria.historialproveedores.index');
    }
}
