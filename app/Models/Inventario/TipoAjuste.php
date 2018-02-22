<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator,Cache;

class TipoAjuste extends BaseModel
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'tipoajuste';

	public $timestamps = false;
	/**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_tipoAjuste';

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = ['tipoajuste_nombre','tipoajuste_sigla','tipoajuste_tipo'];

	/**
	* The attributes that are mass boolean assignable.
	*
	* @var array
	*/
	protected $boolean = ['tipoajuste_activo'];

	public function isValid($data)
	{
		$rules = [
			'tipoajuste_nombre' => 'required|max:25|unique:tipoajuste',
			'tipoajuste_sigla' => 'required|max:3',
			'tipoajuste_tipo' => 'required|max:1',
		];

        if ($this->exists){
            $rules['tipoajuste_nombre'] .= ',tipoajuste_nombre,' . $this->id;
        }else{
            $rules['tipoajuste_nombre'] .= '|required';
        }

		$validator = Validator::make($data, $rules);
		if ($validator->passes()) {
			return true;
		}
		$this->errors = $validator->errors();
		return false;
	}

 	public static function getTiposAjustes()
    {
        if (Cache::has( self::$key_cache )) {
            return Cache::get( self::$key_cache );
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = TipoAjuste::query();
            $query->orderby('tipoajuste_nombre', 'asc');
            $collection = $query->lists('tipoajuste_nombre', 'id');
            $collection->prepend('', '');
            return $collection;
        });
    }
}
