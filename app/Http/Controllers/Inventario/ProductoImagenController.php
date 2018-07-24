<?php

namespace App\Http\Controllers\Inventario;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Inventario\Producto, App\Models\Inventario\ProductoImagen;
use DB, Log, Storage, Auth;

class ProductoImagenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if( $request->ajax() ){
            if( $request->has('producto') ){
                $query = ProductoImagen::query();
                $query->where('productoi_producto', $request->producto);
                $imagenes = $query->get();

                $data = [];
                foreach ($imagenes as $imagen) {
                    if(Storage::has("productos/producto_$imagen->productoi_producto/$imagen->productoi_archivo")) {
                        $object = new \stdClass();
                        $object->uuid = $imagen->id;
                        $object->name = $imagen->productoi_archivo;
                        $object->size = Storage::size("productos/producto_$imagen->productoi_producto/$imagen->productoi_archivo");
                        $object->thumbnailUrl = url("storage/productos/producto_$imagen->productoi_producto/$imagen->productoi_archivo");
                        $data[] = $object;
                    }
                }
                return response()->json($data);
            }
        }
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            // Recuperar producto
            $producto = Producto::find($request->producto);
            if(!$producto instanceof Producto){
                abort(404);
            }

            // Validar que contenga imagenes
            $file = $request->file;
            if( !empty($file) ){
                DB::beginTransaction();
                try {
                    // Recuperar nombre de archivo
                    $name = str_random(4)."_{$file->getClientOriginalName()}";

                    Storage::put("productos/producto_$producto->id/$name", file_get_contents($file->getRealPath()));

                    // Retornar url href
                    $url = url("storage/productos/producto_$producto->id/$name");

                    // Insertar imagen
                    $imagen = new ProductoImagen;
                    $imagen->productoi_archivo = $name;
                    $imagen->productoi_producto = $producto->id;
                    $imagen->productoi_fh_elaboro = date('Y-m-d H:m:s');
                    $imagen->productoi_usuario_elaboro = Auth::user()->id;
                    $imagen->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $imagen->id, 'name' => $imagen->productoi_archivo, 'url' => $url]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
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
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                $productoi = ProductoImagen::find($id);
                if(!$productoi instanceof ProductoImagen){
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar la imagen del producto, por favor verifique la información o consulte al administrador.']);
                }

                $producto = Producto::find($request->producto);
                if(!$producto instanceof Producto){
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar el producto, por favor verifique la información o consulte al administrador.']);
                }

                if( $productoi->productoi_producto != $producto->id ){
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'La imagen que esta intentando eliminar no corresponde al detalle, por favor verifique la información o consulte al administrador.']);
                }

                // Eliminar item detallepedido
                if( Storage::has("productos/producto_$producto->id/$productoi->productoi_archivo") ) {
                    Storage::delete("productos/producto_$producto->id/$productoi->productoi_archivo");
                    $productoi->delete();
                }

                DB::commit();
                return response()->json(['success' => true]);
            }catch(\Exception $e){
                DB::rollback();
                Log::error("ProductoImagenController->destroy:{$e->getMessage()}");
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
