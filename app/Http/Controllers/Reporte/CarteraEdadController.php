<?php

namespace App\Http\Controllers\Reporte;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Base\Tercero, App\Models\Base\Sucursal, App\Models\Cartera\Factura1;
use Excel, View, App, DB;

class CarteraEdadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('type')) {

            $query = Factura1::query();
            $query->select('documentos_nombre as documento', 'factura1_numero as numero', 'sucursal_nombre as sucursal', 'factura3_cuota as cuota', 't.tercero_nit', 'tv.tercero_nit as vendedor_nit', 'factura3_valor as valor', 'factura3_saldo as saldo',
                DB::raw("(CASE WHEN t.tercero_persona = 'N' THEN CONCAT(t.tercero_nombre1,' ',t.tercero_nombre2,' ',t.tercero_apellido1,' ',t.tercero_apellido2,
                            (CASE WHEN (t.tercero_razonsocial IS NOT NULL AND t.tercero_razonsocial != '') THEN CONCAT(' - ', t.tercero_razonsocial) ELSE '' END)
                        ) ELSE t.tercero_razonsocial END) AS tercero_nombre"), DB::raw("(CASE WHEN tv.tercero_persona = 'N' THEN CONCAT(tv.tercero_nombre1,' ',tv.tercero_nombre2,' ',tv.tercero_apellido1,' ',tv.tercero_apellido2, (CASE WHEN (tv.tercero_razonsocial IS NOT NULL AND tv.tercero_razonsocial != '') THEN CONCAT(' - ', tv.tercero_razonsocial) ELSE '' END)
                        ) ELSE tv.tercero_razonsocial END) AS vendedor_nombre"),
                    DB::raw("
                        (CASE WHEN ((factura3_vencimiento - NOW()) > 360) THEN (factura3_saldo) ELSE 0 END) AS valor_m360,
                        (CASE WHEN ((factura3_vencimiento - NOW()) > 180 AND (factura3_vencimiento - NOW()) <= 360) THEN (factura3_saldo) else 0 END) AS valor_m180,
                        (CASE WHEN ((factura3_vencimiento - NOW()) > 90 AND (factura3_vencimiento - NOW()) <= 180) THEN (factura3_saldo) else 0 END) AS valor_m90,
                        (CASE WHEN ((factura3_vencimiento - NOW()) > 60 AND (factura3_vencimiento - NOW()) <= 90) THEN (factura3_saldo) else 0 END) AS valor_m60,
                        (CASE WHEN ((factura3_vencimiento - NOW()) > 30 AND (factura3_vencimiento - NOW()) <= 60) THEN (factura3_saldo) else 0 END) AS valor_m30,
                        (CASE WHEN ((factura3_vencimiento - NOW()) > 0 AND (factura3_vencimiento - NOW()) <= 30) THEN (factura3_saldo) else 0 END) AS valor_m0,

                        (CASE WHEN ((factura3_vencimiento - NOW()) <= 0 AND (factura3_vencimiento - NOW()) >= -30) THEN (factura3_saldo) else 0 END) AS valor_pv_m0,
                        (CASE WHEN ((factura3_vencimiento - NOW()) < -30 AND (factura3_vencimiento - NOW()) >= -60) THEN (factura3_saldo) else 0 END) AS valor_pv_m30,
                        (CASE WHEN ((factura3_vencimiento - NOW()) < -60 AND (factura3_vencimiento - NOW()) >= -90) THEN (factura3_saldo) else 0 END) AS valor_pv_m60,
                        (CASE WHEN ((factura3_vencimiento - NOW()) < -90 AND (factura3_vencimiento - NOW()) >= -180) THEN (factura3_saldo) else 0 END) AS valor_pv_m90,
                        (CASE WHEN ((factura3_vencimiento - NOW()) < -180 AND (factura3_vencimiento - NOW()) >= -360) THEN (factura3_saldo) else 0 END) AS valor_pv_m180,
                        (CASE WHEN ((factura3_vencimiento - NOW()) < -360) THEN (factura3_saldo) else 0 END) AS valor_pv_m360
                    ")

            );

            $query->join('tercero as t', 'factura1_tercero', '=', 't.id');
            $query->join('tercero as tv', 'factura1_vendedor', '=', 'tv.id');
            $query->join('documentos', 'factura1_documentos', '=', 'documentos.id');
            $query->join('sucursal', 'factura1_sucursal', '=', 'sucursal.id');
            $query->join('factura2', 'factura1.id', '=', 'factura2_factura1');
            $query->join('factura3', 'factura1.id', '=', 'factura3_factura1');

            /* Begin filters */
            if ($request->has('filter_tercero')) {
                $tercero = Tercero::where('tercero_nit', $request->filter_tercero)->first();
                $query->where('factura1_tercero', $tercero->id);
            }
            if ($request->has('filter_sucursal')) {
                $query->whereIn('factura1_sucursal', $request->filter_sucursal);
            }
            $carteraEdades = $query->get();

            // Prepare data
            $title = "Reporte de cartera por edades";
            $type = $request->type;

            switch ($type) {
                case 'xls':
                    Excel::create(sprintf('%s_%s_%s', 'carteraEdades', date('Y_m_d'), date('H_m_s')), function($excel) use($carteraEdades, $title, $type) {
                        $excel->sheet('Excel', function($sheet) use($carteraEdades, $title, $type) {
                            $sheet->loadView('reportes.cartera.carteraedades.reporte', compact('carteraEdades', 'title', 'type'));
                        });
                    })->download('xls');
                break;
            }
        }
        return view('reportes.cartera.carteraedades.index');
    }
}
