<?php

namespace App\Http\Controllers\Reporte;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Contabilidad\PlanCuenta;
use Excel, View, App;

class PlanCuentasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('type')) {
            $query = PlanCuenta::query();

            // Filters
            if($request->has('nivel')) {
                $query->where('plancuentas_nivel', '<=', $request->nivel);
            }

            $query->orderBy('plancuentas_cuenta', 'asc');
            $plancuentas = $query->get();

            // Prepare data
            $title = 'Listado de producto en inventario según la subcategoria';
            $type = $request->type;

            // Generate file
            switch ($type) {
                case 'xls':
                    Excel::create(sprintf('%s_%s_%s', 'plancuentas', date('Y_m_d'), date('H_m_s')), function($excel) use($plancuentas, $title, $type) {
                        $excel->sheet('Excel', function($sheet) use($plancuentas, $title, $type) {
                            $sheet->loadView('reportes.contabilidad.plancuentas.reporte', compact('plancuentas', 'title', 'type'));
                        });
                    })->download('xls');
                break;

                case 'pdf':
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadHTML(View::make('reportes.contabilidad.plancuentas.reporte',  compact('plancuentas', 'title', 'type'))->render());
                    $pdf->setPaper('A4', 'letter')->setWarnings(false);
                    return $pdf->download(sprintf('%s_%s_%s.pdf', 'plancuentas', date('Y_m_d'), date('H_m_s')));
                break;
            }
        }

        return view('reportes.contabilidad.plancuentas.index');
    }
}
