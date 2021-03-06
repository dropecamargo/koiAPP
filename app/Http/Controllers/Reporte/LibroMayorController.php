<?php

namespace App\Http\Controllers\Reporte;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Classes\Reports\Accounting\LibroMayor;
use View, App, Excel, Validator, DB;

class LibroMayorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('type')) {

            // Reference var
            $mes = $request->filter_month;
            $ano = $request->filter_year;

            if($mes == 1){
                $mes2 = 13;
                $ano2 = $ano-1;
            }else{
                $mes2 = $mes-1;
                $ano2 = $ano;
            }

            // Prepare sql
            $sql =
                "SELECT plancuentas_nombre as nombre ,plancuentas_cuenta as cuenta,
                    (select saldoscontables_debito_inicial
                        from saldoscontables
                        where
                        saldoscontables_mes = $mes2
                        and
                        saldoscontables_ano = $ano2
                        and
                        saldoscontables_cuenta = plancuentas.id
                    )as debitoinicial,
                    (select saldoscontables_credito_inicial
                        from saldoscontables
                        where
                        saldoscontables_mes = $mes2
                        and
                        saldoscontables_ano = $ano2
                        and
                        saldoscontables_cuenta = plancuentas.id
                    )as creditoinicial,
                    (select (saldoscontables_debito_mes)
                        from saldoscontables
                        where
                        saldoscontables_mes = $mes
                        and
                        saldoscontables_ano = $ano
                        and
                        saldoscontables_cuenta = plancuentas.id
                    )as debitomes,
                    (select (saldoscontables_credito_mes)
                        from saldoscontables
                        where
                        saldoscontables_mes = $mes
                        and
                        saldoscontables_ano = $ano
                        and
                        saldoscontables_cuenta = plancuentas.id
                    )as creditomes
                    FROM plancuentas
                    WHERE plancuentas.id IN (
                        select s.saldoscontables_cuenta
                            from saldoscontables as s
                            where
                            s.saldoscontables_mes = $mes
                            and
                            s.saldoscontables_ano = $ano
                        union
                        select s.saldoscontables_cuenta
                            from saldoscontables as s
                            where
                            s.saldoscontables_mes = $mes2
                            and
                            s.saldoscontables_ano = $ano2
                    )
                order by cuenta";

            //  Transaction querie
            $saldos = DB::select($sql);

            // Prepare data
            $title = "Libro mayor ".config('koi.meses')[$mes]." - $ano";
            $type = $request->type;

            switch ($type) {
                case 'xls':
                    Excel::create(sprintf('%s_%s_%s', 'libromayor', date('Y_m_d'), date('H_m_s')), function($excel) use($saldos, $title, $type) {
                        $excel->sheet('Excel', function($sheet) use($saldos, $title, $type) {
                            $sheet->loadView('reportes.contabilidad.libromayor.report', compact('saldos', 'title', 'type'));
                        });
                    })->download('xls');
                break;

                case 'pdf':
                    $pdf = new LibroMayor('L','mm', 'Letter');
                    $pdf->buldReport($saldos, $title);
                break;
            }
        }
        return view('reportes.contabilidad.libromayor.index');
    }
}
