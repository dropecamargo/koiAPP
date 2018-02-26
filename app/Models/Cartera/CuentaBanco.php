<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Cache, Validator;

class CuentaBanco extends BaseModel
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'cuentabanco';

	public $timestamps = false;

	/**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_cuentabancos';

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['cuentabanco_nombre','cuentabanco_numero'];

    protected $boolean = ['cuentabanco_activa'];

	public function isValid($data)
	{
		$rules = [
			'cuentabanco_nombre' => 'required|max:50|unique:cuentabanco',
			'cuentabanco_banco' => 'required',
			'cuentabanco_numero' => 'required|max:25',
		];

		if ($this->exists){
			$rules['cuentabanco_nombre'] .= ',cuentabanco_nombre,'.$this->id;
		}else{
			$rules['cuentabanco_nombre'] .= '|required';
		}

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}

	public static function getCuentaBanco($id){
        $query = CuentaBanco::query();
        $query->select('cuentabanco.*','banco_nombre');
        $query->join('banco', 'cuentabanco_banco', '=', 'banco.id');
        $query->where('cuentabanco.id', $id);
        return $query->first();
	}

	public static function getCuenta()
    {
    	if ( Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever( self::$key_cache , function() {
	        $query = CuentaBanco::query();
	        $query->select('id','cuentabanco_nombre');
	        $query->where('cuentabanco_activa', true);
	        $collection = $query->lists('cuentabanco_nombre', 'id');

			$collection->prepend('', '');
	    	return $collection;
	    });
    }
}
