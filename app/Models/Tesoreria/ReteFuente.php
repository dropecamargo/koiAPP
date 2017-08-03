<?php

namespace App\Models\Tesoreria;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator,Cache;

class ReteFuente extends BaseModel
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
    protected $table = 'retefuente';

    public $timestamps = false;

	/**
	* The key used by cache store.
	*
	* @var static string
	*/
    public static $key_cache = '_retefuente';

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['retefuente_nombre','retefuente_tarifa_natural','retefuente_tarifa_juridico','retefuente_base'];

    protected $boolean = ['retefuente_activo'];

    public function isValid($data)
    {
        $rules = [
            'retefuente_nombre' => 'required|max:100',
            'retefuente_tarifa_natural' => 'numeric',
            'retefuente_tarifa_juridico' => 'numeric',
            'retefuente_base' => 'required|numeric'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getReteFuentes()
    {
        if ( Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = ReteFuente::query();
            $query->orderBy('retefuente_nombre', 'asc');
            $collection = $query->lists('retefuente_nombre', 'retefuente.id');
            $collection->prepend('', '');
            return $collection;
           
        });
    }
    public static function getRetencionFuente($id){
        $retefuente = ReteFuente::query();
        $retefuente->select('retefuente.*', 'plancuentas_cuenta','plancuentas_nombre');
        $retefuente->join('plancuentas', 'retefuente_plancuentas','=','plancuentas.id');
        $retefuente->where('retefuente.id', $id);
        return $retefuente->first();
    }
}
