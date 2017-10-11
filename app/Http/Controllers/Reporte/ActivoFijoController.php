<?php

namespace App\Http\Controllers\Reporte;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Contabilidad\ActivoFijo;
use Excel, View, App, DB;

class ActivoFijoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('type')) {
            
            $activoFijo = ActivoFijo::getActivosFijos();

            // Prepare data
            $title = "Listado de activos fijos";
            $type = $request->type;
            switch ($type) {
                case 'xls':
                    Excel::create(sprintf('%s_%s_%s', 'activoFijo', date('Y_m_d'), date('H_m_s')), function($excel) use($activoFijo, $title, $type) {
                        $excel->sheet('Excel', function($sheet) use($activoFijo, $title, $type) {
                            $sheet->loadView('reportes.inventario.activosfijos.reporte', compact('activoFijo', 'title', 'type'));
                        });
                    })->download('xls');
                break;

                case 'pdf':
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadHTML(View::make('reportes.inventario.activosfijos.reporte',  compact('activoFijo', 'title', 'type'))->render());
                    $pdf->setPaper('letter', 'landscape')->setWarnings(false);
                    return $pdf->stream(sprintf('%s_%s_%s.pdf', 'activoFijo', date('Y_m_d'), date('H_m_s')));
                break;
            }
        }
        return view('reportes.inventario.activosfijos.index');
    }
}
