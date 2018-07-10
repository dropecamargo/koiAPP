<?php

namespace App\Http\Controllers\Reporte;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Cobro\GestionDeudor;
use View, Excel, App, DB, Log, Auth;

class ResumenCobroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if( $request->has('type') ){
            // Gestiondeudor en rango de fecha
            $query = GestionDeudor::query();
            $query->select('gestiondeudor.*', 'conceptocob_nombre', 'tercero_nit', 'deudor_nit', DB::raw("(CASE WHEN tercero_persona = 'N'
                THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                        (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                    )
                ELSE tercero_razonsocial END)
            AS tercero_nombre, SUBSTRING_INDEX(gestiondeudor_proxima, ' ', '1') AS gestiondeudor_fecha, SUBSTRING_INDEX(gestiondeudor_proxima, ' ', '-1') AS gestiondeudor_hora, CONCAT(deudor_nombre1,' ',deudor_nombre2,' ',deudor_apellido1,' ',deudor_apellido2) AS deudor_nombre"));
            $query->join('conceptocob', 'gestiondeudor_conceptocob', '=', 'conceptocob.id');
            $query->join('deudor', 'gestiondeudor_deudor', '=', 'deudor.id');
            $query->join('tercero', 'deudor_tercero', '=', 'tercero.id');
            $query->whereBetween( DB::raw("SUBSTRING_INDEX(gestiondeudor_fh, ' ', '1')"), [$request->fecha_inicial, $request->fecha_final] );
            if( Auth::user()->hasRole('cliente') ){
                $query->where('deudor_tercero', Auth::user()->id);
            }
            $llamadas = $query->get();

                // llamadas programadas en rango de fecha
            $query = GestionDeudor::query();
            $query->select('gestiondeudor.*', 'conceptocob_nombre', 'tercero_nit', 'deudor_nit', DB::raw("(CASE WHEN tercero_persona = 'N'
                THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                        (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                    )
                ELSE tercero_razonsocial END)
            AS tercero_nombre, SUBSTRING_INDEX(gestiondeudor_proxima, ' ', '1') AS gestiondeudor_fecha, SUBSTRING_INDEX(gestiondeudor_proxima, ' ', '-1') AS gestiondeudor_hora, CONCAT(deudor_nombre1,' ',deudor_nombre2,' ',deudor_apellido1,' ',deudor_apellido2) AS deudor_nombre"));
            $query->join('conceptocob', 'gestiondeudor_conceptocob', '=', 'conceptocob.id');
            $query->join('deudor', 'gestiondeudor_deudor', '=', 'deudor.id');
            $query->join('tercero', 'deudor_tercero', '=', 'tercero.id');
            $query->whereBetween( DB::raw("SUBSTRING_INDEX(gestiondeudor_proxima, ' ', '1')"), [$request->fecha_inicial, $request->fecha_final] );
            if( Auth::user()->hasRole('cliente') ){
                $query->where('deudor_tercero', Auth::user()->id);
            }
            $llamadas_p = $query->get();

            // Preparar datos reporte
            $title = sprintf('%s', 'Reporte Resumen Cobro');
            $type = $request->type;
            $fecha_inicio = $request->fecha_inicial;
            $fecha_final = $request->fecha_final;

            // Generate file
            switch ($type) {
                case 'xls':
                    Excel::create(sprintf('%s_%s_%s', 'Reporte Resumen Cobro', date('Y_m_d'), date('H_m_s')), function($excel) use($fecha_inicio, $fecha_final, $llamadas, $llamadas_p, $title, $type){
                        $title = sprintf('%s', 'Cobros Realizados');
                        $excel->sheet('Excel', function($sheet) use($fecha_inicio, $fecha_final, $llamadas, $title, $type) {
                            $sheet->loadView('reportes.cobro.reporteresumencobro.reporte', compact('fecha_inicio','fecha_final','llamadas', 'title', 'type'));
                            $sheet->setFontSize(8);
                        });

                        $title = sprintf('%s', 'Cobros Programados');
                        $excel->sheet('Excel', function($sheet) use($fecha_inicio, $fecha_final, $llamadas_p, $title, $type) {
                            $sheet->loadView('reportes.cobro.reporteresumencobro.reporte2', compact('fecha_inicio','fecha_final','llamadas_p', 'title', 'type'));
                            $sheet->setFontSize(8);
                        });
                    })->download('xls');
                    break;
            }
        }
        return view('reportes.cobro.reporteresumencobro.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
