<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;
use Cache, Validator;

class Banco extends BaseModel
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'banco';

	public $timestamps = false;

	/**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_bancos';

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['banco_nombre'];

    protected $boolean = ['banco_activo'];

	public function isValid($data)
	{
		$rules = [
			'banco_nombre' => 'required|max:25',
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}

	public static function getBancos()
    {
        if ( Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = Banco::query();
            $query->select('id','banco_nombre');
            $query->where('banco_activo', true);
            $collection = $query->lists('banco_nombre', 'id');

			$collection->prepend('', '');
        	return $collection;
        });
    }
}
