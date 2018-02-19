<?php

namespace App\Http\Controllers\Reporte;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Tecnico\Orden;
use View, App, DB, Validator;

class OrdenesAbiertasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	if ($request->has('type')) {
    		/* Begin validation form*/
	        $validator = Validator::make($request->all(), [
	            'filter_sucursal' => 'required'
	        ]);

	        if ($validator->fails()) {
	            return redirect('/rordenesabiertas')
                    	->withErrors($validator)
                    	->withInput();
	        }
    		/* End validation*/

    		$query = Orden::query();
    		$query->select('orden_numero', 'sucursal.id AS sucursal_id','sucursal_nombre', 'producto_serie', 'producto_nombre', 'tercero_nit', DB::raw("(CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2, (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)) ELSE tercero_razonsocial END) AS tercero_nombre"));
  			$query->join('sucursal', 'orden_sucursal', '=',  'sucursal.id');
  			$query->join('tercero', 'orden_tercero', '=',  'tercero.id');
  			$query->join('producto', 'orden_serie', '=',  'producto.id');
    		$query->where('orden_abierta', true);

            /* Begin filters */
        	if ($request->has('filter_tercero')) {
        		$query->where('orden_tercero', $request->filter_tercero);
        	}

        	if ($request->has('filter_sucursal' && $request->filter_sucursal != 0 )) {
        		$query->whereIn('orden_sucursal', $request->filter_sucursal);
        	}

        	if ($request->has('filter_serie')) {
        		$query->where('orden_serie', $request->filter_serie);
        	}
            /* End filters */

            // Prepare data
            $title = "Reporte de ordenes abiertas a ".date('Y-m-d');
            $type = $request->type;
            $ordenes = $query->get();

            switch ($type) {
                case 'pdf':
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadHTML(View::make('reportes.tecnico.ordenesabiertas.reporte',  compact('ordenes', 'title', 'type'))->render());
                    $pdf->setPaper('letter', 'landscape')->setWarnings(false);
                    return $pdf->stream(sprintf('%s_%s_%s.pdf', 'ordenes', date('Y_m_d'), date('H_m_s')));
                break;
            }
    	}
        return view('reportes.tecnico.ordenesabiertas.index');
    }
}
