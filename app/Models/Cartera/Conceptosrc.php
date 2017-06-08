<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;
use Cache, Validator;

class Conceptosrc extends BaseModel
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'conceptosrc';

	public $timestamps = false;

	/**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_conceptosrc';

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['conceptosrc_nombre'];

    protected $boolean = ['conceptosrc_activo'];

    protected $nullable = ['conceptosrc_documentos'];


	public function isValid($data)
	{
		$rules = [
			'conceptosrc_nombre' => 'required|max:25',
			'conceptosrc_plancuentas' => 'required',
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}

	public static function getConceptosrc($id)
	{
		$query = Conceptosrc::query();
		$query->select('conceptosrc.*', 'plancuentas_nombre', 'plancuentas_cuenta', 'documentos_nombre', 'documentos_codigo');
		$query->join('plancuentas', 'conceptosrc_plancuentas', '=', 'plancuentas.id');
		$query->leftJoin('documentos', 'conceptosrc_documentos', '=', 'documentos.id');
		$query->where('conceptosrc.id', $id);
		return $query->first();
	}

	public static function getConcepto()
    {
    	if ( Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever( self::$key_cache , function() {
	        $query = Conceptosrc::query();
	        $query->select('id','conceptosrc_nombre');
	        $query->whereNotNull('conceptosrc_documentos');
	        $query->where('conceptosrc_activo', true);
	        $collection = $query->lists('conceptosrc_nombre', 'id');

			$collection->prepend('', '');
	    	return $collection;
	    });
    }
	public static function getConceptoAnticipo()
    {
    	if ( Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever( self::$key_cache , function() {
	        $query = Conceptosrc::query();
	        $query->select('id','conceptosrc_nombre');
	        $query->whereNull('conceptosrc_documentos');
	        $query->where('conceptosrc_activo', true);
	        $collection = $query->lists('conceptosrc_nombre', 'id');
			$collection->prepend('', '');
	    	return $collection;
	    });
    }
}
