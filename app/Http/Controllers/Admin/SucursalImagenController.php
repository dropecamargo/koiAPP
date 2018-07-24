<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Base\Sucursal, App\Models\Base\SucursalImagen;
use DB, Log, Storage, Auth;

class SucursalImagenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if( $request->ajax() ){
            if( $request->has('sucursal') ){
                $query = SucursalImagen::query();
                $query->where('sucursali_sucursal', $request->sucursal);
                $imagenes = $query->get();

                $data = [];
                foreach ($imagenes as $imagen) {
                    if(Storage::has("sucursales/sucursal_$imagen->sucursali_sucursal/$imagen->sucursali_archivo")) {
                        $object = new \stdClass();
                        $object->uuid = $imagen->id;
                        $object->name = $imagen->sucursali_archivo;
                        $object->size = Storage::size("sucursales/sucursal_$imagen->sucursali_sucursal/$imagen->sucursali_archivo");
                        $object->thumbnailUrl = url("storage/sucursales/sucursal_$imagen->sucursali_sucursal/$imagen->sucursali_archivo");
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
            // Recuperar sucursal
            $sucursal = Sucursal::find($request->sucursal);
            if(!$sucursal instanceof Sucursal){
                abort(404);
            }

            // Validar que contenga imagenes
            $file = $request->file;
            if( !empty($file) ){
                DB::beginTransaction();
                try {
                    // Recuperar nombre de archivo
                    $name = str_random(4)."_{$file->getClientOriginalName()}";

                    Storage::put("sucursales/sucursal_$sucursal->id/$name", file_get_contents($file->getRealPath()));

                    // Retornar url href
                    $url = url("storage/sucursales/sucursal_$sucursal->id/$name");

                    // Insertar imagen
                    $imagen = new SucursalImagen;
                    $imagen->sucursali_archivo = $name;
                    $imagen->sucursali_sucursal = $sucursal->id;
                    $imagen->sucursali_fh_elaboro = date('Y-m-d H:m:s');
                    $imagen->sucursali_usuario_elaboro = Auth::user()->id;
                    $imagen->save();

                    // Commit Transaction
                    DB::commit();
                    return response()->json(['success' => true, 'id' => $imagen->id, 'name' => $imagen->sucursali_archivo, 'url' => $url]);
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
    public function destroy(Rquest $request, $id)
    {
        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                $sucursali = SucursalImagen::find($id);
                if(!$sucursali instanceof SucursalImagen){
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar la imagen de la sucursal, por favor verifique la información o consulte al administrador.']);
                }

                $sucursal = Sucursal::find($request->sucursal);
                if(!$sucursal instanceof Sucursal){
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar la sucursal, por favor verifique la información o consulte al administrador.']);
                }

                if( $sucursali->sucursali_sucursal != $sucursal->id ){
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'La imagen que esta intentando eliminar no corresponde al detalle, por favor verifique la información o consulte al administrador.']);
                }

                // Eliminar item detalle
                if( Storage::has("sucursales/sucursal_$sucursal->id/$sucursali->sucursali_archivo") ) {
                    Storage::delete("sucursales/sucursal_$sucursal->id/$sucursali->sucursali_archivo");
                    $sucursali->delete();
                }

                DB::commit();
                return response()->json(['success' => true]);
            }catch(\Exception $e){
                DB::rollback();
                Log::error("SucursalImagenController->destroy:{$e->getMessage()}");
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
