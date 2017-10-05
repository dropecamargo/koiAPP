<?php

namespace App\Http\Controllers\Reporte;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Base\Sucursal;
use App\Models\Inventario\Producto, App\Models\Inventario\Prodbode, App\Models\Inventario\SubCategoria;
use Excel, View, App, DB;

class ExistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('type')) {

            $query = Prodbode::select('producto_serie','producto_nombre','producto_costo','producto_precio1','prodbode_cantidad');   
            $query->join('producto', 'prodbode.prodbode_serie','=','producto.id');
            $query->join('subcategoria', 'producto_subcategoria', '=', 'subcategoria.id');
            // $query->join('sucursal', 'prodbode_sucursal', '=', 'sucursal.id');
            $query->groupBy('prodbode_sucursal','prodbode_serie');

            /* Begin filters */
            if ($request->has('sub_categoria')) {
                $subcategoria = SubCategoria::find($request->subcategoria);
                if ($subcategoria instanceof SubCategoria){
                    $query->where('producto_subcategoria', $subcategoria->id );
                }
            } 
            if ($request->has('filter_sucursal')) {
                $query->whereIn('prodbode_sucursal', $request->filter_sucursal);
                $countSucursal = count($request->filter_sucursal);
            }
            /* End filters */

            $query->orderBy('producto_serie', 'asc');
            $producto['query'] = $query->get();
            // $producto['numSucursal'] = isset($countSucursal) ? $countSucursal : Sucursal::count();
            $producto['numSucursal'] = isset($countSucursal) ? $countSucursal : 3;

            // Prepare data
            $title = 'Listado de producto en inventario según la subcategoria';
            $type = $request->type;

            switch ($type) {
                case 'xls':
                    Excel::create(sprintf('%s_%s_%s', 'producto', date('Y_m_d'), date('H_m_s')), function($excel) use($producto, $title, $type) {
                        $excel->sheet('Excel', function($sheet) use($producto, $title, $type) {
                            $sheet->loadView('reportes.inventario.existencias.reporte', compact('producto', 'title', 'type'));
                        });
                    })->download('xls');
                break;

                case 'pdf':
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadHTML(View::make('reportes.inventario.existencias.reporte',  compact('producto', 'title', 'type'))->render());
                    $pdf->setPaper('letter', 'landscape')->setWarnings(false);
                    return $pdf->stream(sprintf('%s_%s_%s.pdf', 'producto', date('Y_m_d'), date('H_m_s')));
                break;
            }
        }
        return view('reportes.inventario.existencias.index');
    }
}
