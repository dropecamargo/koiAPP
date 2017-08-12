<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base\TipoNotificacion;
use Cache, Auth, DB;

class Notificacion extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notificaciones';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static function cache()
    {
        $key_cache = sprintf('%s_%s', 'notification', Auth::user()->id);
        return $key_cache;
    }

    public static function newNotificacion($tercero, $typenotificacion, $visto, $visto_fh = null, $fecha = null , $hora = null, $url, $descripcion, $title)
    {
        // Recupero instancia de Tercero(Auth::user)
        $tercero = Tercero::find($tercero);
        if(!$tercero instanceof Tercero) {
            return 'No es posible recuperar tercero, verifique información ó por favor consulte al administrador.';
        }

        // Recuperar tiponotificacion
        $typenotificacion = TipoNotificacion::where('tiponotificacion_nombre', $typenotificacion)->first();
        if(!$typenotificacion instanceof TipoNotificacion){
            return 'No es posible recuperar tipo de notificación, verifique información ó por favor consulte al administrador.';
        }

        // Create new notificacion
        $notificacion = new Notificacion;
        $notificacion->notificacion_tercero = $tercero->id;
        $notificacion->notificacion_tiponotificacion = $typenotificacion->id;
        $notificacion->notificacion_visto = $visto;
        $notificacion->notificacion_fh_visto = $visto_fh;
        $notificacion->notificacion_fecha = $fecha;
        $notificacion->notificacion_hora = $hora;
        $notificacion->notificacion_url = $url;
        $notificacion->notificacion_descripcion = $descripcion;
        $notificacion->notificacion_titulo = $title;
        $notificacion->save();

        //Forget cache
        Cache::forget( self::cache() );

        return 'OK';
    }

    public static function getNotifications(){
        if (Cache::has( self::cache() )) {
            return Cache::get( self::cache() );
        }

        return Cache::rememberForever( self::cache() , function() {
            $query = Notificacion::query();
            $query->select('notificaciones.*', DB::raw("CASE WHEN (notificacion_hora IS NOT NULL) THEN CONCAT(notificacion_fecha, ' ', DATE_FORMAT(notificacion_hora, '%H:%i')) ELSE notificacion_fecha END AS nfecha"));
            $query->where('notificacion_fecha', '<=', date('Y-m-d'));
            $query->where('notificacion_tercero', Auth::user()->id);
            $query->where('notificacion_visto', false);
            $query->orderBy('notificacion_fecha', 'desc');
            $query->limit(5);

            return $query->get();
        });
    }

    public static function getAllNotifications($id){
        $query = Notificacion::query();
        $query->select('notificaciones.*', DB::raw("CASE WHEN (notificacion_hora IS NOT NULL) THEN CONCAT(notificacion_fecha, ' ', DATE_FORMAT(notificacion_hora, '%H:%i')) ELSE notificacion_fecha END AS nfecha"));
        $query->where('notificacion_fecha', '<=', date('Y-m-d'));
        $query->where('notificacion_tercero', $id);
        $query->orderBy('notificacion_fecha', 'asc');
        return $query;
    }
}
