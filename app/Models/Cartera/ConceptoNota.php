<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator, Cache;

class ConceptoNota extends BaseModel
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'conceptonota';

	public $timestamps = false;

	/**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_conceptonota';

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['conceptonota_nombre'];

    protected $boolean = ['conceptonota_activo'];

	public function isValid($data)
	{
		$rules = [
		    'conceptonota_nombre' => 'required|max:50|unique:conceptonota',
		];

		if ($this->exists){
			$rules['conceptonota_nombre'] .= ',conceptonota_nombre,'.$this->id;
		}else{
			$rules['conceptonota_nombre'] .= '|required';
		}

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}

	public static function getConcepto()
    {
    	if ( Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever( self::$key_cache , function() {
	        $query = ConceptoNota::query();
	        $query->select('id','conceptonota_nombre');
	        $query->where('conceptonota_activo', true);
	        $collection = $query->lists('conceptonota_nombre', 'id');

			$collection->prepend('', '');
	    	return $collection;
	    });
    }
}
