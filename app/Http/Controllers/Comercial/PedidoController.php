<?php

namespace App\Http\Controllers\Comercial;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Comercial\Pedidoc1, App\Models\Comercial\Pedidoc2;
use App\Models\Inventario\Producto,App\Models\Inventario\SubCategoria;
use App\Models\Base\Tercero,App\Models\Base\Sucursal,App\Models\Base\Documentos,App\Models\Base\Contacto;

use DB,Log,Datatables,Auth;

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
            return Datatables::of($query)->make(true);
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
                        $pedidoComercial2->pedidoc2_pedidoc1 = $pedidoComercial->id;
                        $pedidoComercial2->pedidoc2_producto = $producto->id;
                        $pedidoComercial2->pedidoc2_subcategoria = $subcategoria->id;
                        $pedidoComercial2->save();  
                    }
                    // Update consecutive sucursal_pedidoc in Sucursal
                    $sucursal->sucursal_pedidoc = $consecutive;
                    $sucursal->save();
                    //Commit transaction
                    DB::rollback();
                    return response()->json(['success' => false , 'errors' => 'TODO OK']);
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
    public function show($id)
    {
        //
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
}
