<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Cache, Validator;

class Causal extends BaseModel
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'causal';

	public $timestamps = false;

	/**
	* The key used by cache store.
	*
	* @var static string
	*/
    public static $key_cache = '_causal';

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['causal_nombre'];

    protected $boolean = ['causal_activo'];

	public function isValid($data)
	{
		$rules = [
			'causal_nombre' => 'required|max:100|unique:causal',
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}

	public static function getCausales()
    {
        if ( Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = Causal::query();
            $query->select('id','causal_nombre');
            $query->where('causal_activo', true);
            $collection = $query->lists('causal_nombre', 'id');

			$collection->prepend('', '');
        	return $collection;
        });
    }
}
