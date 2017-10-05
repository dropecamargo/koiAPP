<?php

namespace App\Http\Controllers\Reporte;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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

            $query = null;
            $carteraEdades = null;
            
            /* Begin filters */
            if ($request->has('filter_tercero')) {

            }
            if ($request->has('filter_sucursal')) {
                
            }
            if ($request->has('filter_mes') && $request->has('filter_mes')) {

            }

            if ($request->has('filter_tipo')) {

            }
            /* End filters */

            // dd($request->all()); 

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
