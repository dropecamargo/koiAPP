<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;
use Validator, Cache;

class MedioPago extends BaseModel
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'mediopago';

	public $timestamps = false;

	/**
	* The key used by cache store.
	*
	* @var static string
	*/
    public static $key_cache = '_mediopago';

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['mediopago_nombre'];

    protected $boolean = ['mediopago_activo','mediopago_ch','mediopago_ef'];

	public function isValid($data)
	{
		$rules = [
			'mediopago_nombre' => 'required|max:25',
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}

	public static function getMedioPago()
    {
    	if ( Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever( self::$key_cache , function() {
	        $query = MedioPago::query();
	        $query->select('id','mediopago_nombre');
	        $query->where('mediopago_activo', true);
	        $query->orWhere('mediopago_ch', true);
	        $query->orderBy('mediopago_nombre', 'asc');
	        $collection = $query->lists('mediopago_nombre', 'id');

			$collection->prepend('', '');
	    	return $collection;
	    });
    }	
}
