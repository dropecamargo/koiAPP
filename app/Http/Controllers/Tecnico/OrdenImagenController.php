<?php

namespace App\Http\Controllers\Tecnico;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Tecnico\OrdenImagen, App\Models\Tecnico\Orden;
use DB, Log, Auth, Storage;

class OrdenImagenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if( $request->ajax() ){
            $query = OrdenImagen::query();
            $query->where('visitai_orden', $request->orden_id);
            $images = $query->get();
            
            $data = [];
            foreach ($images as $image) {
                if(Storage::has("ordenes/orden_$image->visitai_orden/$image->visitai_archivo")) {
                    
                    $object = new \stdClass();
                    $object->uuid = $image->id;
                    $object->name = $image->visitai_archivo;
                    $object->size = Storage::size("ordenes/orden_$image->visitai_orden/$image->visitai_archivo");
                    $object->thumbnailUrl = url("storage/ordenes/orden_$image->visitai_orden/$image->visitai_archivo");
                    $data[] = $object;
                }
            }
            return response()->json($data);
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
            $data = $request->all();
            $imagen = new OrdenImagen;
            
            // Recuperar orden
            $orden = Orden::find($request->orden_id);
            if(!$orden instanceof Orden || !$request->hasFile('file')){
                abort(404);
            }        

            DB::beginTransaction();
            try {
                // Recuperar file
                $file = $request->file('file');
                $name = sprintf('%s_%s', str_random(4), $file->getClientOriginalName());

                Storage::put("ordenes/orden_{$orden->id}/$name", 
                    file_get_contents($file->getRealPath())
                );

                // Retornar url href
                $url = url("storage/ordenes/orden_$orden->id/$name");

                // Insertar imagen
                $imagen->visitai_archivo = $name;
                $imagen->visitai_orden = $orden->id;
                $imagen->visitai_usuario_elaboro = Auth::user()->id;
                $imagen->visitai_fh_elaboro = date('Y-m-d H:m:s');
                $imagen->save();

                // Commit Transaction
                DB::commit();                
                return response()->json(['success' => true, 'id' => $imagen->id, 'name' => $imagen->visitai_archivo, 'url' => $url]);
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
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
                $orden = Orden::find($request->orden_id);
                if(!$orden instanceof Orden){
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar orden, por favor verifique la información del pedido o consulte al administrador.']);
                }

                $image = OrdenImagen::where('visitai.id', $id)->where('visitai_orden', $orden->id)->first();
                if(!$image instanceof OrdenImagen){
                    DB::rollback();
                    return response()->json(['success' => false, 'errors' => 'No es posible recuperar imagen, por favor verifique la información del pedido o consulte al administrador.']);
                }
                
                // Eliminar item detallepedido
                if(Storage::has("ordenes/orden_$orden->id/$image->visitai_archivo")) {
                    Storage::delete("ordenes/orden_$orden->id/$image->visitai_archivo");
                }

                $image->delete();

                DB::commit();
                return response()->json(['success' => true]);

            }catch(\Exception $e){
                DB::rollback();
                Log::error(sprintf('%s -> %s: %s', 'OrdenImagenController', 'destroy', $e->getMessage()));
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(403);
    }
}
