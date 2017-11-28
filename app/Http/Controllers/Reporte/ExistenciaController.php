<?php

namespace App\Http\Controllers\Reporte;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Base\Sucursal;
use App\Models\Report\AuxReport;
use App\Models\Inventario\Producto, App\Models\Inventario\Prodbode, App\Models\Inventario\SubCategoria;
use Excel, View, App, DB, Log, Validator, Auth;

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
                /* Begin validator form*/
                $validator = Validator::make($request->all(), [
                    'filter_sucursal' => 'required',
                    'filter_subcategoria' => 'required'
                ]);

                if ($validator->fails()) {
                    return redirect('/rexistencias')
                    ->withErrors($validator)
                    ->withInput();
                }
                /* End validator */

                // Validation filters
                $validation = in_array("0", $request->filter_sucursal);
                $validationSub = in_array("0", $request->filter_subcategoria);

                // Sucursales
                $query = Sucursal::query();
                $query->select('sucursal.id', 'sucursal_nombre');
                $query->orderBy('sucursal.id', 'asc');
                !$validation ? $query->whereIn('id', $request->filter_sucursal) : '';
                $sucursales = $query->get();

                // Prodbode
                $query = Prodbode::query();
                $query->select('prodbode_serie as id_producto','prodbode_sucursal','producto_serie','producto_nombre','producto_costo','producto_precio1 as venta', 'subcategoria_nombre');
                $query->join('producto', 'prodbode.prodbode_serie','=','producto.id');
                $query->join('subcategoria', 'producto_subcategoria', '=', 'subcategoria.id');
                $query->groupBy('prodbode_sucursal','prodbode_serie', 'producto_subcategoria');
                $query->orderBy('prodbode_serie', 'asc');

                // Use filters
                !$validation ? $query->whereIn('prodbode_sucursal', $request->filter_sucursal) : '';
                !$validationSub ? $query->whereIn('producto_subcategoria', $request->filter_subcategoria) : '';
                $prodbode =  $query->get();

            } catch ( \Exception $e) {
                DB::rollback();
                Log::error($e->getMessage());
                abort(500);
            }

            // Prepare data
            $title = 'Listado de producto en inventario según la subcategoria';
            $type = $request->type;
            $user = Auth::user()->username;

            switch ($type) {
                case 'xls':
                    Excel::create(sprintf('%s_%s_%s', 'producto', date('Y_m_d'), date('H_m_s')), function($excel) use($prodbode, $sucursales, $user, $title, $type) {
                        $excel->sheet('Excel', function($sheet) use($prodbode, $sucursales, $user, $title, $type) {
                            $sheet->loadView('reportes.inventario.existencias.reporte', compact('prodbode', 'sucursales','user','title', 'type'));
                        });
                    })->download('xls');
                break;

                case 'pdf':
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadHTML(View::make('reportes.inventario.existencias.reporte',  compact('prodbode', 'sucursales','user','title', 'type'))->render());
                    $pdf->setPaper('letter', 'landscape')->setWarnings(false);
                    return $pdf->stream(sprintf('%s_%s_%s.pdf', 'producto', date('Y_m_d'), date('H_m_s')));
                break;
            }
        }
        return view('reportes.inventario.existencias.index');
    }
}
