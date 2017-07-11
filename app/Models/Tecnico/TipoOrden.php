<?php

namespace App\Models\Tecnico;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;

use Validator,Cache,DB;

class TipoOrden extends BaseModel
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'tipoorden';

	public $timestamps = false;

	/**
	* The key used by cache store.
	*
	* @var static string
	*/
	public static $key_cache = '_tiposorden';

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = ['tipoorden_nombre'];

	protected $boolean = ['tipoorden_activo'];

    public function isValid($data)
    {
        $rules = [
            'tipoorden_nombre' => 'required|max:200'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getTiposOrden()
    {
        if (Cache::has( self::$key_cache )) {
            return Cache::get( self::$key_cache );
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = TipoOrden::query();
            $query->where('tipoorden_activo', true);
            $query->orderBy('tipoorden_nombre', 'asc');
            $collection = $query->lists('tipoorden_nombre', 'id');

            $collection->prepend('', '');
            return $collection;
        });
    }
}
