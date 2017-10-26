<?php

namespace App\Http\Controllers\Reporte;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Base\Sucursal;
use App\Models\Report\AuxReport;
use App\Models\Inventario\Producto, App\Models\Inventario\Prodbode, App\Models\Inventario\SubCategoria;
use Excel, View, App, DB, Log;

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
            try {
                DB::beginTransaction();

                $query = Prodbode::select('producto_serie','producto_nombre','producto_costo','producto_precio1','prodbode_cantidad', 'subcategoria_nombre', 'sucursal.id AS sucursal_id');   
                $query->join('producto', 'prodbode.prodbode_serie','=','producto.id');
                $query->join('subcategoria', 'producto_subcategoria', '=', 'subcategoria.id');
                $query->join('sucursal', 'prodbode_sucursal', '=', 'sucursal.id');
                $query->groupBy('prodbode_sucursal','prodbode_serie', 'subcategoria_nombre');

                /* Begin filters */
                if ($request->has('sub_categoria')) {
                    $query->where('producto_subcategoria', $request->sub_categoria );
                } 
                if ($request->has('filter_sucursal')) {
                    $query->whereIn('prodbode_sucursal', $request->filter_sucursal);
                    $countSucursal = count($request->filter_sucursal);
                }
                /* End filters */
                $querieSelect =  $query->get();

                foreach ($querieSelect as $key => $value) {
                    $ref = "auxreporte_integer$key";
                    $auxReport = new AuxReport;
                    $auxReport->auxreporte_varchar1 = $value->producto_serie; 
                    $auxReport->auxreporte_varchar2 = $value->producto_nombre; 
                    $auxReport->auxreporte_varchar3 = $value->subcategoria_nombre; 
                    $auxReport->auxreporte_double1 = $value->producto_costo; 
                    $auxReport->auxreporte_double2 = $value->producto_precio1; 
                    $auxReport->$ref = $value->prodbode_cantidad; 
                    $auxReport->save();
                }

                $list = AuxReport::select('auxreporte_varchar1 as serie', 'auxreporte_varchar2 as nombre', 'auxreporte_varchar3 as subcategoria','auxreporte_double1 as costo', 'auxreporte_double2 as precio',
                        DB::raw(
                            "sum(auxreporte_integer0) as unidad1, sum(auxreporte_integer1) as unidad2,
                            sum(auxreporte_integer2) as unidad3, sum(auxreporte_integer3) as unidad4,
                            sum(auxreporte_integer4) as unidad5, sum(auxreporte_integer5) as unidad6,
                            sum(auxreporte_integer6) as unidad7, sum(auxreporte_integer7) as unidad8,
                            sum(auxreporte_integer8) as unidad9, sum(auxreporte_integer9) as unidad10,
                            sum(auxreporte_integer10) as unidad11, sum(auxreporte_integer11) as unidad12,
                            sum(auxreporte_integer12) as unidad13, sum(auxreporte_integer13) as unidad14,
                            sum(auxreporte_integer14) as unidad15, sum(auxreporte_integer15) as unidad16")
                    );
                $list->groupBy('auxreporte_varchar1', 'auxreporte_varchar3');
                $list->orderBy('auxreporte_varchar1','auxreporte_varchar3');
                $producto['query'] = $list->get();
                $producto['numSucursal'] = isset($countSucursal) ? $countSucursal : Sucursal::count();
                DB::rollback();
            } catch ( \Exception $e) {
                DB::rollback();
                Log::error($e->getMessage());
                abort(500);
            }
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
