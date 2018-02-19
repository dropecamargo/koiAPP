<?php

namespace App\Http\Controllers\Reporte;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Base\Sucursal, App\Models\Inventario\Producto, App\Models\Inventario\Inventario;
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

            $query = Inventario::select('inventario.*', 'documentos_nombre', 'sucursal_nombre', 'username', DB::raw("SUBSTRING_INDEX(inventario_fh_elaboro, ' ', 1) as inventario_fecha"), DB::raw("SUBSTRING_INDEX(inventario_fh_elaboro, ' ', -1) as inventario_hora"));

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
            if ($request->has('filter_fecha_inicio') && $request->has('filter_fecha_fin')) {
                $query->where('inventario_fh_elaboro', '>=', $request->filter_fecha_inicio);
                $query->where('inventario_fh_elaboro', '<=', $request->filter_fecha_fin);
            }
            /* End filters */

            $query->join('documentos', 'inventario_documentos', '=', 'documentos.id');
            $query->join('sucursal', 'inventario_sucursal', '=', 'sucursal.id');
            $query->join('tercero', 'inventario_usuario_elaboro', '=', 'tercero.id');
            $inventario = $query->get();

            // Prepare data
            $title = "Listado de movimiento producto $producto->producto_serie - $producto->producto_nombre";
            $type = $request->type;

            switch ($type) {
                case 'xls':
                    Excel::create(sprintf('%s_%s_%s', 'inventario', date('Y_m_d'), date('H_m_s')), function($excel) use($inventario, $title, $type) {
                        $excel->sheet('Excel', function($sheet) use($inventario, $title, $type) {
                            $sheet->loadView('reportes.inventario.movproductos.reporte', compact('inventario', 'title', 'type'));
                        });
                    })->download('xls');
                break;

                case 'pdf':
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadHTML(View::make('reportes.inventario.movproductos.reporte',  compact('inventario', 'title', 'type'))->render());
                    $pdf->setPaper('letter', 'landscape')->setWarnings(false);
                    return $pdf->stream(sprintf('%s_%s_%s.pdf', 'inventario', date('Y_m_d'), date('H_m_s')));
                break;
            }
        }
        return view('reportes.inventario.movproductos.index');
    }
}
