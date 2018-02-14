<?php

namespace App\Models\Tecnico;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;
use Validator, Cache;

class ConceptoTecnico extends BaseModel
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'conceptotec';

	public $timestamps = false;

	/**
	 * The key used by cache store.
	 *
	 * @var static string
	 */
    public static $key_cache = '_conceptotec';

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['conceptotec_nombre'];

    protected $boolean = ['conceptotec_activo'];

	public function isValid($data)
	{
		$rules = [
			'conceptotec_nombre' => 'required|max:50',
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}

	public static function getConceptoTecnico()
    {
        if ( Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = ConceptoTecnico::query();
            $query->select('id','conceptotec_nombre');
            $query->where('conceptotec_activo', true);
            $query->orderBy('conceptotec_nombre','asc');
            $collection = $query->lists('conceptotec_nombre', 'id');

			$collection->prepend('', '');
        	return $collection;
        });
    }
}
