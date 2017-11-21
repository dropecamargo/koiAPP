<?php

namespace App\Http\Controllers\Comercial;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Comercial\Pedidoc1, App\Models\Comercial\Pedidoc2;
use App\Models\Inventario\Producto,App\Models\Inventario\SubCategoria;
use App\Models\Base\Tercero,App\Models\Base\Sucursal,App\Models\Base\Documentos,App\Models\Base\Contacto;
use DB, Log, Datatables, Auth, App, View;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Pedidoc1::query();
            $query->select('pedidoc1.*', 'tcontacto_direccion','sucursal_nombre', DB::raw("CONCAT(tcontacto_nombres,' ',tcontacto_apellidos) AS tcontacto_nombre"), DB::raw("CONCAT(v.tercero_nombre1, ' ', v.tercero_nombre2, ' ',v.tercero_apellido1, ' ',v.tercero_apellido2) as vendedor_nombre"),
                DB::raw("
                    CONCAT(
                        (CASE WHEN t.tercero_persona = 'N'
                            THEN CONCAT(t.tercero_nombre1,' ',t.tercero_nombre2,' ',t.tercero_apellido1,' ',t.tercero_apellido2,
                                (CASE WHEN (t.tercero_razonsocial IS NOT NULL AND t.tercero_razonsocial != '') THEN CONCAT(' - ', t.tercero_razonsocial) ELSE '' END)
                            )
                            ELSE t.tercero_razonsocial
                        END)

                    ) AS tercero_nombre"
                )
            );
            $query->join('tercero as t', 'pedidoc1.pedidoc1_tercero', '=', 't.id');
            $query->join('tercero as v', 'pedidoc1.pedidoc1_vendedor', '=', 'v.id');
            $query->join('sucursal', 'pedidoc1.pedidoc1_sucursal', '=', 'sucursal.id');
            $query->join('tcontacto', 'pedidoc1.pedidoc1_contacto', '=', 'tcontacto.id');
            $query->orderBy('pedidoc1.id', 'desc');

            return Datatables::of($query)
                ->filter(function($query) use($request) {
                    // Tercero
                    if($request->has('tercero')) {
                        $query->where('t.tercero_nit', $request->tercero);
                        $query->whereNull('pedidoc1_factura1');
                    }
                })
                ->make(true);

        }
        return view('comercial.pedidos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('comercial.pedidos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $pedidoComercial = new Pedidoc1;
            if ($pedidoComercial->isValid($data)) {
                DB::beginTransaction();
                try {

                    //Validar Documentos
                    $documento = Documentos::where('documentos_codigo', Pedidoc1::$default_document)->first();
                    if(!$documento instanceof Documentos) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar documentos,por favor verifique la información ó por favor consulte al administrador.']);
                    }
                    //Find Sucursal
                    $sucursal = Sucursal::find($request->pedidoc1_sucursal);
                    if(!$sucursal instanceof Sucursal) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar documentos,por favor verifique la información ó por favor consulte al administrador.']);
                    }
                    //Exits validate Tercero
                    $tercero = Tercero::where('tercero_nit', $request->pedidoc1_tercero)->first();
                    if (!$tercero instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar cliente, por favor verifique la información o consulte al administrador']);
                    }
                    // Validar contacto
                    $contacto = Contacto::find($request->pedidoc1_contacto);
                    if(!$contacto instanceof Contacto) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar contacto, por favor verifique la información o consulte al administrador.']);
                    }
                    // Validar tercero contacto
                    if($contacto->tcontacto_tercero != $tercero->id) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'El contacto seleccionado no corresponde al tercero, por favor seleccione de nuevo el contacto o consulte al administrador.']);
                    }

                    //Validar Vendedor
                    $vendedor = Tercero::find($request->pedidoc1_vendedor);
                    if (!$vendedor instanceof Tercero) {
                        DB::rollback();
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar vendedor, por favor verifique la información p consulte al administrador']);
                    }

                    // Consecutive
                    $consecutive = $sucursal->sucursal_pedidoc + 1;

                    //Pedidoc1
                    $pedidoComercial->fill($data);
                    $pedidoComercial->pedidoc1_sucursal = $sucursal->id;
                    $pedidoComercial->pedidoc1_numero = $consecutive;
                    $pedidoComercial->pedidoc1_documentos = $documento->id;
                    $pedidoComercial->pedidoc1_tercero = $tercero->id;
                    $pedidoComercial->pedidoc1_contacto = $contacto->id;
                    $pedidoComercial->pedidoc1_vendedor = $vendedor->id;
                    $pedidoComercial->pedidoc1_usuario_elaboro = Auth::user()->id;
                    $pedidoComercial->pedidoc1_fh_elaboro = date('Y-m-d H:m:s');
                    $pedidoComercial->save();

                    $items = isset($data['detalle']) ? $data['detalle'] : null;

                    // Pedidoc2
                    foreach ($items as $item)
                    {
                        // Validate Producto
                        $producto = Producto::where('producto_serie', $item['producto_serie'])->first();
                        if (!$producto instanceof Producto) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar producto, por favor verifique información o consulte al administrador']);
                        }
                        //SubCategoria validate
                        $subcategoria = SubCategoria::find($producto->producto_subcategoria);
                        if (!$subcategoria instanceof SubCategoria) {
                            DB::rollback();
                            return response()->json(['success' => false, 'errors' => 'No es posible recuperar subcategoria, por favor verifique información o consulte al administrador']);
                        }
                        $pedidoComercial2 = new Pedidoc2;
                        $pedidoComercial2->fill($item);
                        $pedidoComercial2->pedidoc2_precio_venta = $item['pedidoc2_precio_venta'] > 0 ? $item['pedidoc2_precio_venta'] : $item['pedidoc2_costo'];
                        $pedidoComercial2->pedidoc2_pedidoc1 = $pedidoComercial->id;
                        $pedidoComercial2->pedidoc2_producto = $producto->id;
                        $pedidoComercial2->pedidoc2_subcategoria = $subcategoria->id;
                        $pedidoComercial2->pedidoc2_margen = $subcategoria->subcategoria_margen_nivel1;
                        $pedidoComercial2->save();
                    }
                    // Update consecutive sucursal_pedidoc in Sucursal
                    $sucursal->sucursal_pedidoc = $consecutive;
                    $sucursal->save();
                    //Commit transaction
                    DB::commit();
                    return response()->json(['success' => true , 'id' => $pedidoComercial->id]);
                } catch (\Exception $e) {
                     Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $pedidoComercial->errors]);
        }
        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

        $pedidoComercial = Pedidoc1::getPedidoc($id);
        if(!$pedidoComercial instanceof Pedidoc1) {
            abort(404);
        }
         if($request->ajax()) {
            return response()->json($pedidoComercial);
        }
        return view('comercial.pedidos.show', ['pedidoComercial' => $pedidoComercial]);

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
    /**
     * Anular the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function anular(Request $request, $id)
    {
        if ($request->ajax()) {
            $pedidoc1 = Pedidoc1::findOrFail($id);
            DB::beginTransaction();
            try {

                // Pedidoc1
                $pedidoc1->pedidoc1_anular = true;
                $pedidoc1->pedidoc1_usuario_anulo = Auth::user()->id;
                $pedidoc1->pedidoc1_fh_anulo = date('Y-m-d H:m:s');
                $pedidoc1->save();

                // Commit Transaction
                DB::commit();
                return response()->json(['success' => true, 'msg' => 'Pedido comercial anulado con exito.']);
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }

    /**
     * Export pdf the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function exportar($id)
    {
        $pedidoc = Pedidoc1::getPedidoc($id);
        if(!$pedidoc instanceof Pedidoc1) {
            abort(404);
        }
        $detalle = Pedidoc2::getPedidoc2($pedidoc->id);
        $title = sprintf('Pedido comercial %s', $pedidoc->pedidoc1_numero);

        // Export pdf
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML(View::make('comercial.pedidos.export',  compact('pedidoc', 'detalle', 'title'))->render());
        return $pdf->stream(sprintf('%s_%s_%s_%s.pdf', 'pedidoc', $pedidoc->id, date('Y_m_d'), date('H_m_s')));
    }
}
