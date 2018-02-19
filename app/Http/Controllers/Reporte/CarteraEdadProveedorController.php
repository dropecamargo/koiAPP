<?php

namespace App\Http\Controllers\Reporte;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Base\Tercero, App\Models\Base\Regional, App\Models\Tesoreria\Facturap1;
use Excel, View, App, DB;

class CarteraEdadProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('type')) {
            $query = Facturap1::query();
            $query->select('documentos_nombre as documento', 'facturap1_numero as numero', 'regional_nombre as regional', 'facturap3_cuota as cuota', 't.tercero_nit', 'facturap3_valor as valor', 'facturap3_saldo as saldo',
                DB::raw("(CASE WHEN t.tercero_persona = 'N' THEN CONCAT(t.tercero_nombre1,' ',t.tercero_nombre2,' ',t.tercero_apellido1,' ',t.tercero_apellido2,(CASE WHEN (t.tercero_razonsocial IS NOT NULL AND t.tercero_razonsocial != '') THEN CONCAT(' - ', t.tercero_razonsocial) ELSE '' END)) ELSE t.tercero_razonsocial END) AS tercero_nombre"),
                DB::raw("
                    (CASE WHEN ((facturap3_vencimiento - NOW()) > 360) THEN (facturap3_saldo) ELSE 0 END) AS valor_m360,
                    (CASE WHEN ((facturap3_vencimiento - NOW()) > 180 AND (facturap3_vencimiento - NOW()) <= 360) THEN (facturap3_saldo) else 0 END) AS valor_m180,
                    (CASE WHEN ((facturap3_vencimiento - NOW()) > 90 AND (facturap3_vencimiento - NOW()) <= 180) THEN (facturap3_saldo) else 0 END) AS valor_m90,
                    (CASE WHEN ((facturap3_vencimiento - NOW()) > 60 AND (facturap3_vencimiento - NOW()) <= 90) THEN (facturap3_saldo) else 0 END) AS valor_m60,
                    (CASE WHEN ((facturap3_vencimiento - NOW()) > 30 AND (facturap3_vencimiento - NOW()) <= 60) THEN (facturap3_saldo) else 0 END) AS valor_m30,
                    (CASE WHEN ((facturap3_vencimiento - NOW()) > 0 AND (facturap3_vencimiento - NOW()) <= 30) THEN (facturap3_saldo) else 0 END) AS valor_m0,

                    (CASE WHEN ((facturap3_vencimiento - NOW()) <= 0 AND (facturap3_vencimiento - NOW()) >= -30) THEN (facturap3_saldo) else 0 END) AS valor_pv_m0,
                    (CASE WHEN ((facturap3_vencimiento - NOW()) < -30 AND (facturap3_vencimiento - NOW()) >= -60) THEN (facturap3_saldo) else 0 END) AS valor_pv_m30,
                    (CASE WHEN ((facturap3_vencimiento - NOW()) < -60 AND (facturap3_vencimiento - NOW()) >= -90) THEN (facturap3_saldo) else 0 END) AS valor_pv_m60,
                    (CASE WHEN ((facturap3_vencimiento - NOW()) < -90 AND (facturap3_vencimiento - NOW()) >= -180) THEN (facturap3_saldo) else 0 END) AS valor_pv_m90,
                    (CASE WHEN ((facturap3_vencimiento - NOW()) < -180 AND (facturap3_vencimiento - NOW()) >= -360) THEN (facturap3_saldo) else 0 END) AS valor_pv_m180,
                    (CASE WHEN ((facturap3_vencimiento - NOW()) < -360) THEN (facturap3_saldo) else 0 END) AS valor_pv_m360
                ")
            );

            $query->join('tercero as t', 'facturap1_tercero', '=', 't.id');
            $query->join('documentos', 'facturap1_documentos', '=', 'documentos.id');
            $query->join('regional', 'facturap1_regional', '=', 'regional.id');
            $query->join('facturap3', 'facturap1.id', '=', 'facturap3_facturap1');

            /* Begin filters */
            if ($request->has('filter_tercero')) {
                $tercero = Tercero::where('tercero_nit', $request->filter_tercero)->first();
                $query->where('facturap1_tercero', $tercero->id);
            }
            if ($request->has('filter_regional')) {
                $query->where('facturap1_regional', $request->filter_regional);
            }
            $carteraProveedor = $query->get();

            // Prepare data
            $title = "Reporte de cartera proveedores";
            $type = $request->type;

            switch ($type) {
                case 'xls':
                    Excel::create(sprintf('%s_%s_%s', 'carteraProveedor', date('Y_m_d'), date('H_m_s')), function($excel) use($carteraProveedor, $title, $type) {
                        $excel->sheet('Excel', function($sheet) use($carteraProveedor, $title, $type) {
                            $sheet->loadView('reportes.tesoreria.carteraproveedores.reporte', compact('carteraProveedor', 'title', 'type'));
                        });
                    })->download('xls');
                break;
            }
        }
        return view('reportes.tesoreria.carteraproveedores.index');
    }
}
