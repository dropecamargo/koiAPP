<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Base\Notificacion, App\Models\Base\Tercero;
use Auth, Cache, DB;

class NotificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $notifications = Notificacion::getAllNotifications( Auth::user()->id );

            if($request->has('searchDate')){
                if(!empty($request->searchDate)){
                    $notifications->whereRaw("notificacion_fecha LIKE '%{$request->searchDate}%'");
                }
            }

            if($request->has('searchType')){
                if(!empty($request->searchType)){
                    // Join temporal
                    $notifications->join('tiponotificacion', 'notificacion_tiponotificacion', '=', 'tiponotificacion.id');
                    $notifications->where('notificacion_tiponotificacion', $request->searchType);
                }
            }

            if($request->has('searchEstado')){
                if(!empty($request->searchEstado)){
                    if($request->searchEstado == 'T'){
                        $notifications->where('notificacion_visto', true);
                    }else{
                        $notifications->where('notificacion_visto', false);
                    }
                }
            }

            return response()->json($notifications->get());
        }
        return view('admin.notificaciones.main');
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
        //
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
        if($request->ajax()) {
            // Recuperar tercero
            $tercero = Tercero::find(Auth::user()->id);
            if(!$tercero instanceof Tercero){
                return response()->json(['success' => false, 'errors' => 'No es posible recuperar tercero, por favor verifique la información del asiento o consulte al administrador.']);
            }

            // Recuperar Notificacion
            $notification = Notificacion::find($request->notification);
            if(!$notification instanceof Notificacion){
                return response()->json(['success' => false, 'errors' => 'No es posible recuperar la notificación, por favor verifique la información del asiento o consulte al administrador.']);
            }

            // Validar
            if( $notification->notificacion_tercero != $tercero->id ){
                return response()->json(['success' => false, 'errors' => 'La notificación no correponde al cliente, por favor verifique la información del asiento o consulte al administrador.']);
            }

            DB::beginTransaction();
            try{
                // Update Notificacion
                $notification->notificacion_visto = true;
                $notification->notificacion_fh_visto = date('Y-m-d H:m:s');
                $notification->save();

                // Forget cache
                Cache::forget( Notificacion::cache() );

                DB::commit();
                return response()->json(['success' => true, 'id' => $notification->id, 'url' => $notification->notificacion_url]);
            }catch(\Exception $e){
                DB::rollback();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'errors' => trans('app.exception')]);
            }
        }
        abort(404);
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
