<?php

namespace App\Http\Controllers\Reporte;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Cartera\Factura1, App\Models\Cartera\Devolucion1, App\Models\Comercial\PresupuestoAsesor, App\Models\Base\Regional, App\Models\Report\AuxReport;
use Excel, View, App, DB, Validator;

class SabanaDeVentasCostoController extends Controller
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
                'filter_regional' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect('/rsabanaventascostos')
                        ->withErrors($validator)
                        ->withInput();
            }
            /* End validation*/

            $validation = in_array("0", $request->filter_regional);

            // Array costos
            $arrayCostos = [];

            // Regionales
            $regionales = Regional::query()->select('regional.id', 'regional_nombre');
            !$validation ? $query->whereIn('regional.id', $request->filter_regional) : '';
            $regionales = $regionales->get();

            // Presupuesto
            // $query = PresupuestoAsesor::query();
            // $query->select(DB::raw('SUM(presupuestoasesor_valor) AS valor'), 'presupuestoasesor_regional AS regional', 'presupuestoasesor_linea AS linea', 'grupo.id as grupo',  'subgrupo.id as subgrupo');
            // $query->join('linea','presupuestoasesor_linea', '=', 'linea.id' );
            // $query->join('categoria','subcategoria_categoria', '=', 'categoria.id' );
            // $query->join('linea','categoria_linea', '=', 'linea.id' );
            // $query->join('unidadnegocio','linea_unidadnegocio', '=', 'unidadnegocio.id' );
            // $query->groupBy('regional', 'unidadnegocio', 'linea', 'categoria', 'subcategoria');
            // !$validation ? $query->whereIn('presupuestoasesor_regional', $request->filter_regional) : '';
            // $presupuestoAux = $query->get();
            // $presupuesto = [];
            //
            // // Prepare array
            // foreach ($presupuestoAux as $item) {
            //     $presupuesto = array_merge(array("$item->regional-$item->unidadnegocio-$item->linea-$item->categoria-$item->subcategoria" => $item->valor), $presupuesto);
            // }
            // Factura
            $query = Factura1::query();
            $query->select('regional.id AS regional', 'regional_nombre', 'unidadnegocio.id AS unidadnegocio','unidadnegocio_nombre', 'linea.id AS linea','linea_nombre', 'categoria.id AS categoria','categoria_nombre','subcategoria.id AS subcategoria','subcategoria_nombre',
                DB::raw('SUM(factura2_precio_venta * (factura2_cantidad - factura2_devueltas)) AS ventas'),
                DB::raw('SUM(factura2_descuento_valor * (factura2_cantidad - factura2_devueltas)) AS descuentos'),
                DB::raw('SUM(factura2_costo * (factura2_cantidad - factura2_devueltas)) AS costo'));
            $query->join('factura2', 'factura1.id', '=', 'factura2_factura1');
            $query->join('sucursal', 'factura1_sucursal', '=', 'sucursal.id');
            $query->join('regional', 'sucursal_regional', '=', 'regional.id');
            $query->join('producto', 'factura2_producto', '=', 'producto.id');
            $query->join('unidadnegocio','producto.producto_unidadnegocio', '=', 'unidadnegocio.id');
            $query->join('linea','producto.producto_linea', '=', 'linea.id');
            $query->join('categoria','producto.producto_categoria', '=', 'categoria.id');
            $query->join('subcategoria', 'producto.producto_subcategoria', '=', 'subcategoria.id');
            $query->groupBy('regional.id','producto_unidadnegocio', 'producto_linea', 'producto_categoria', 'producto_subcategoria');
            !$validation ? $query->whereIn('regional.id', $request->filter_regional) : '';
            $facturas = $query->get();

            //Insert
            $arrayCostos = AuxReport::insertInTable($facturas, $arrayCostos, 'F', false);

            // Devolucion
            $query = Devolucion1::query();
            $query->select('regional.id AS regional', 'regional_nombre', 'unidadnegocio.id AS unidadnegocio','unidadnegocio_nombre', 'linea.id AS linea','linea_nombre', 'categoria.id AS categoria','categoria_nombre','subcategoria.id AS subcategoria','subcategoria_nombre',
                DB::raw('SUM(devolucion2_precio * devolucion2_cantidad) AS devoluciones'),
                DB::raw('SUM(devolucion2_costo * devolucion2_cantidad) AS costo'));
            $query->join('devolucion2', 'devolucion1.id', '=', 'devolucion2_devolucion1');
            $query->join('sucursal', 'devolucion1_sucursal', '=', 'sucursal.id');
            $query->join('regional', 'sucursal_regional', '=', 'regional.id');
            $query->join('producto', 'devolucion2_producto', '=', 'producto.id');
            $query->join('unidadnegocio','producto.producto_unidadnegocio', '=', 'unidadnegocio.id');
            $query->join('linea','producto.producto_linea', '=', 'linea.id');
            $query->join('categoria','producto.producto_categoria', '=', 'categoria.id');
            $query->join('subcategoria', 'producto.producto_subcategoria', '=', 'subcategoria.id');
            $query->groupBy('regional.id','producto_unidadnegocio', 'producto_linea', 'producto_categoria', 'producto_subcategoria');
            !$validation ? $query->whereIn('regional.id', $request->filter_regional) : '';
            $devoluciones = $query->get();

            //Insert
            AuxReport::insertInTable($devoluciones, $arrayCostos, 'DEV', true);

            // Sabana de ventas list report
            $query = AuxReport::query();
            $query->select('auxreporte_varchar1','auxreporte_varchar2','auxreporte_varchar3','auxreporte_varchar4','auxreporte_integer1','auxreporte_integer2','auxreporte_integer3','auxreporte_integer4',
                DB::raw("SUM(auxreporte_double0) AS 1V ,SUM(auxreporte_double1) AS 1D,SUM(auxreporte_double2) AS 1d,
                        SUM(auxreporte_double3) AS 2V, SUM(auxreporte_double4) AS 2D, SUM(auxreporte_double5) AS 2d,
                        SUM(auxreporte_double6) AS 3V, SUM(auxreporte_double7) AS 3D, SUM(auxreporte_double8) AS 3d,
                        SUM(auxreporte_double9) AS 4V, SUM(auxreporte_double10) AS 4D,SUM(auxreporte_double11) AS 4d,
                        SUM(auxreporte_double12) AS 5V, SUM(auxreporte_double13) AS 5D, SUM(auxreporte_double14) AS 5d"));
            $query->groupBy('auxreporte_varchar1', 'auxreporte_varchar2', 'auxreporte_varchar3', 'auxreporte_varchar4');
            $sabanaVentas = $query->get();

            // Prepare data
            $title = "Sábana de ventas con costo";
            $type = $request->type;

            switch ($type) {
                case 'xls':
                    Excel::create(sprintf('%s_%s_%s', 'sabanaVentas', date('Y_m_d'), date('H_m_s')), function($excel) use(/*$sabanaVentas, $regionales ,*/$title, $type) {
                        $excel->sheet('Excel', function($sheet) use($sabanaVentas, $title, $type) {
                            $sheet->loadView('reportes.comercial.sabanaventascostos.reporte', compact('sabanaVentas', 'title', 'type'));
                        });
                    })->download('xls');
                break;

                case 'pdf':
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadHTML(View::make('reportes.comercial.sabanaventascostos.reporte',  compact('sabanaVentas', 'presupuesto', 'arrayCostos','regionales' ,'title', 'type'))->render());
                    $pdf->setPaper('letter', 'landscape')->setWarnings(false);
                    return $pdf->stream(sprintf('%s_%s_%s.pdf', 'sabanaVentas', date('Y_m_d'), date('H_m_s')));
                break;
            }
        }
        return view('reportes.comercial.sabanaventascostos.index');
    }
    /**
     * Function valid filter call in index resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function validFilters(Request $request, $query){
        // Prepare response
        $response = new \stdClass();

        /* Begin filters */
        if ($request->has('filter_regional') && $request->filter_regional > 0) {
            $query->whereIn('regional.id',$request->filter_regional);
        }
        /* End filters */
        $response->query = $query->get();
        return $response;
    }
}
