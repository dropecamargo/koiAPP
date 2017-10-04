<?php

namespace App\Http\Controllers\Reporte;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Base\Sucursal;
use App\Models\Inventario\Producto, App\Models\Inventario\Inventario;
use Excel, View, App, DB;

class MovProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('type')) {
            
            $query = Inventario::select('inventario.*', 'documentos_nombre');

            /* Begin filters */
            if ($request->has('producto_serie')) {
                // Recupero producto
                $producto = Producto::where('producto_serie', $request->producto_serie)->first();
                $query->where('inventario_serie', $producto->id);
            }

            if ($request->has('filter_sucursal')) {
                // Recupero sucursal
                $query->where('inventario_sucursal', $request->filter_sucursal);
            }
            /* End filters */

            $query->join('documentos', 'inventario_documentos', '=', 'documentos.id');
            $inventario = $query->get();
            // $inventario['data'] = $request->all();
            // dd($inventario);

            // Prepare data
            $title = "Listado de movimiento producto $producto->producto_serie - $producto->producto_nombre";
            $type = $request->type;

            switch ($type) {
                case 'xls':
                    Excel::create(sprintf('%s_%s_%s', '$inventario', date('Y_m_d'), date('H_m_s')), function($excel) use($inventario, $title, $type) {
                        $excel->sheet('Excel', function($sheet) use($inventario, $title, $type) {
                            $sheet->loadView('reportes.inventario.movproductos.reporte', compact('inventario', 'title', 'type'));
                        });
                    })->download('xls');
                break;

                case 'pdf':
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadHTML(View::make('reportes.inventario.movproductos.reporte',  compact('inventario', 'title', 'type'))->render());
                    $pdf->setPaper('letter', 'landscape')->setWarnings(false);
                    return $pdf->stream(sprintf('%s_%s_%s.pdf', '$inventario', date('Y_m_d'), date('H_m_s')));
                break;
            }
        }
        return view('reportes.inventario.movproductos.index');
    }
}
