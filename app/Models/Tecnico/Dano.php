<?php

namespace App\Models\Tecnico;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator, Cache;

class Dano extends BaseModel
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'dano';

    public $timestamps = false;

	/**
	* The key used by cache store.
	*
	* @var static string
	*/
	public static $key_cache = '_danos';

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = ['dano_nombre'];

	protected $boolean = ['dano_activo'];

    public function isValid($data)
    {
        $rules = [
            'dano_nombre' => 'required|max:200|unique:dano'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getDanos()
    {
        if (Cache::has( self::$key_cache )) {
            return Cache::get( self::$key_cache );
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = Dano::query();
            $query->where('dano_activo', true);
            $query->orderBy('dano_nombre', 'asc');
            $collection = $query->lists('dano_nombre', 'id');

            $collection->prepend('', '');
            return $collection;
        });
    }
}
