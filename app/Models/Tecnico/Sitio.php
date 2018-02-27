<?php

namespace App\Models\Tecnico;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator, Cache;

class Sitio extends BaseModel
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
    protected $table = 'sitio';

    public $timestamps = false;

	/**
	* The key used by cache store.
	*
	* @var static string
	*/
    public static $key_cache = '_sitio';

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['sitio_nombre'];

    protected $boolean = ['sitio_activo'];

    public function isValid($data)
    {
        $rules = [
            'sitio_nombre' => 'required|max:25|unique:sitio'
        ];

        if ($this->exists){
            $rules['sitio_nombre'] .= ',sitio_nombre,' . $this->id;
        }else{
            $rules['sitio_nombre'] .= '|required';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getSitios()
    {
        if (Cache::has( self::$key_cache )) {
            return Cache::get( self::$key_cache );
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = Sitio::query();
            $query->where('sitio_activo', true);
            $query->orderBy('sitio_nombre', 'asc');
            $collection = $query->lists('sitio_nombre', 'id');

            $collection->prepend('', '');
            return $collection;
        });
    }
}
