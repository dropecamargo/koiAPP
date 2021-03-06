<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator, Cache;

class ConceptoAjustec extends BaseModel
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'conceptoajustec';

	public $timestamps = false;

	/**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_conceptoajustec';

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['conceptoajustec_nombre'];

    protected $boolean = ['conceptoajustec_activo','conceptoajustec_sumas_iguales'];

	public function isValid($data)
	{
		$rules = [
			'conceptoajustec_nombre' => 'required|max:50|unique:conceptoajustec',
			'conceptoajustec_cuenta' => 'required',
		];

		if ($this->exists){
			$rules['conceptoajustec_nombre'] .= ',conceptoajustec_nombre,'.$this->id;
		}else{
			$rules['conceptoajustec_nombre'] .= '|required';
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
		$concepto = ConceptoAjustec::select('conceptoajustec.*', 'plancuentas_cuenta', 'plancuentas_nombre');
		$concepto->join('plancuentas', 'conceptoajustec_cuenta', '=', 'plancuentas.id');
		$concepto->where('conceptoajustec.id', $id);
		return $concepto->first();
	}
	public static function getConceptoAjustec()
    {
        if ( Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = ConceptoAjustec::query();
            $query->select('id','conceptoajustec_nombre');
            $query->where('conceptoajustec_activo', true);
            $collection = $query->lists('conceptoajustec_nombre', 'id');

			$collection->prepend('', '');
        	return $collection;
        });
    }
}
