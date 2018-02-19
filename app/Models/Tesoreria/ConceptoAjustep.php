<?php

namespace App\Models\Tesoreria;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator, Cache;

class ConceptoAjustep extends BaseModel
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'conceptoajustep';

	public $timestamps = false;

	/**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_conceptoajustep';

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['conceptoajustep_nombre'];

    protected $boolean = ['conceptoajustep_activo'];

	public function isValid($data)
	{
		$rules = [
			'conceptoajustep_nombre' => 'required|max:50|unique:conceptoajustep',
		];
		if ($this->exists){
			$rules['conceptoajustep_nombre'] .= ',conceptoajustep_nombre,' . $this->id;
		}else{
			$rules['conceptoajustep_nombre'] .= '|required';
		}
		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}

	public static function getConceptoAjustep()
    {
        if ( Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = ConceptoAjustep::query();
            $query->select('id','conceptoajustep_nombre');
            $query->where('conceptoajustep_activo', true);
            $collection = $query->lists('conceptoajustep_nombre', 'id');

			$collection->prepend('', '');
        	return $collection;
        });
    }
}
