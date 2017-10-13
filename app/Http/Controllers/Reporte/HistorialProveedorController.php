<?php

namespace App\Http\Controllers\Reporte;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Base\Tercero;
use App\Models\Tesoreria\Ajustep2, App\Models\Tesoreria\Facturap1, App\Models\Tesoreria\Egreso2;
use Excel, View, App, DB;

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
            $historyProveider = [];
            
            /* Begin filters */
            if ($request->has('filter_tercero')) {
                $tercero =  Tercero::select('id', DB::raw("(CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,'',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2, (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)) ELSE tercero_razonsocial END) AS tercero_nombre"))->where('tercero_nit', $request->filter_tercero)->first();

                // initial position the array
                $i = 0;

                // querie ajuste proveedor
                $ajusteProveedor = Ajustep2::historyProveiderReport($tercero, $historyProveider, $i);
                $historyProveider = $ajusteProveedor->ajusteProveedor;
                $i = $ajusteProveedor->position;

                // querie factura proveedor
                $facturaProveedor = Facturap1::historyProveiderReport($tercero, $historyProveider, $i);
                $historyProveider = $facturaProveedor->facturaProveedor;
                $i = $facturaProveedor->position;

                // querie egresos proveedor
                $egreso = Egreso2::historyProveiderReport($tercero, $historyProveider, $i);
                $historyProveider = $egreso->egreso;
                $i = $egreso->position;


                // dd($historyProveider, $i);
            }
            
            // if ($request->has('filter_fecha_inicio') && $request->has('filter_fecha_fin')) {
            // }
            /* End filters */

            // Prepare data
            $title = "Historial del proveedor $tercero->tercero_nombre";
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
