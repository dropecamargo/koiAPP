<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator,Cache;

class TipoTraslado extends BaseModel
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'tipotraslado';

	public $timestamps = false;
	
	/**
 	* the key used by cache store.
 	*
 	* @var static string
 	*/
    public static $key_cache = '_tipotraslado';

	/**
	* the attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = ['tipotraslado_nombre','tipotraslado_sigla'];

	/**
	* The attributes that are mass boolean assignable.
	*
	* @var array
	*/
	protected $boolean = ['tipotraslado_activo'];

	public function isValid($data)
	{
		$rules = [
			'tipotraslado_nombre' => 'required|max:25|unique:tipotraslado',
			'tipotraslado_sigla' => 'required|max:3',
		];

		$validator = Validator::make($data, $rules);
		if ($validator->passes()) {
			return true;
		}
		$this->errors = $validator->errors();
		return false;
	}
 	public static function getTiposTraslados()
    {
        if (Cache::has( self::$key_cache )) {
            return Cache::get( self::$key_cache );
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = TipoTraslado::query();
            $query->orderby('tipotraslado_nombre', 'asc');
            $collection = $query->lists('tipotraslado_nombre', 'id');
            $collection->prepend('', '');
            return $collection;
        });
    }
}
