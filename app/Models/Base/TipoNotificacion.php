<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use Cache;

class TipoNotificacion extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tiponotificacion';

    public $timestamps = false;

    public static $key_cache = '_typenotification';

    public static function getTypes(){
        if (Cache::has( self::$key_cache )) {
            return Cache::get( self::$key_cache );
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = TipoNotificacion::query();
            $collection = $query->lists('tiponotificacion_nombre', 'id');

			$collection->prepend('', '');
        	return $collection;
        });
    }
}
