<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator, Cache;

class ConceptoCob extends BaseModel
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'conceptocob';

	public $timestamps = false;

	/**
	 * The key used by cache store.
	 *
	 * @var static string
	 */
    public static $key_cache = '_conceptocob';

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['conceptocob_nombre'];

    protected $boolean = ['conceptocob_activo'];

	public function isValid($data)
	{
		$rules = [
			'conceptocob_nombre' => 'required|max:25|unique:conceptocob',
			'conceptocob_cuenta' => 'required'
		];

		if ($this->exists){
			$rules['conceptocob_nombre'] .= ',conceptocob_nombre,'.$this->id;
		}else{
			$rules['conceptocob_nombre'] .= '|required';
		}

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}
	public static function getConcepto($id)
	{
		$concepto = ConceptoCob::select('conceptocob.*', 'plancuentas_nombre', 'plancuentas_cuenta');
		$concepto->join('plancuentas', 'conceptocob_cuenta', '=', 'plancuentas.id');
		$concepto->where('conceptocob.id', $id);
		return $concepto->first();
	}
	public static function getConceptoCobro()
    {
        if ( Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = ConceptoCob::query();
            $query->select('id','conceptocob_nombre');
            $query->where('conceptocob_activo', true);
            $query->orderBy('conceptocob_nombre','asc');
            $collection = $query->lists('conceptocob_nombre', 'id');

			$collection->prepend('', '');
        	return $collection;
        });
    }
}
