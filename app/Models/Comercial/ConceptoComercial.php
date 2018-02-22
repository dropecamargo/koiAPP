<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator, Cache;

class ConceptoComercial extends BaseModel
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'conceptocom';

	public $timestamps = false;

	/**
	 * The key used by cache store.
	 *
	 * @var static string
	 */
    public static $key_cache = '_conceptocom';

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['conceptocom_nombre'];

    protected $boolean = ['conceptocom_activo'];

	public function isValid($data)
	{
		$rules = [
			'conceptocom_nombre' => 'required|max:25|unique:conceptocom',
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}

	public static function getConceptoComercial()
    {
        if ( Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = ConceptoComercial::query();
            $query->select('id','conceptocom_nombre');
            $query->where('conceptocom_activo', true);
            $query->orderBy('conceptocom_nombre','asc');
            $collection = $query->lists('conceptocom_nombre', 'id');

			$collection->prepend('', '');
        	return $collection;
        });
    }
}
