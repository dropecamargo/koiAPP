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
            // dd($request->all());
            // $query = Producto::select('producto.*', 'prodbode_cantidad', 'subcategoria_nombre', 'sucursal_nombre');
            // $query->join('sucursal', 'prodbode.prodbode_sucursal', '=', 'sucursal.id');
            // $query->join('subcategoria', 'producto_subcategoria', '=', 'subcategoria.id');
            $array = array('type' =>'pdf' , 'sub_categoria'=> 1 , 'check_sucursal_1' => '1', 'check_sucursal_2' => '2', 'check_sucursal_3' => '3', 'check_sucursal_4' => '4' );
            $data = $request->all();
            dd($data);
            $array = array_splice($data, 2);  
            $array = array_flatten($array);
            $query = Prodbode::select('producto_serie','producto_nombre','prodbode_cantidad');   
            $query->join('producto', 'prodbode.prodbode_serie','=','producto.id');
            $query->groupBy('prodbode_sucursal','prodbode_serie');
            
            /* Begin filters */
            if ($request->has('sub_categoria')) {
                $subcategoria = SubCategoria::find($request->subcategoria);
                if ($subcategoria instanceof SubCategoria){
                    $query->where('producto_subcategoria', $subcategoria->id );
                }
            }
            // Define que sucursales se escogieron
            $sucursales = Sucursal::query()->get();
            $countSucursal = 0;
            foreach ($sucursales as $sucursal) {
                if ($request->has("check_sucursal_$sucursal->id")) {
                    $countSucursal++;
                    $query->where('prodbode_sucursal', $sucursal->id);
                }
            }
            /* End filters */

            $query->orderBy('producto_serie', 'asc');
            $producto['query'] = $query->get();
            $producto['numSucursal'] = $countSucursal == 0 ? $sucursales->count() : $countSucursal;
            
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
