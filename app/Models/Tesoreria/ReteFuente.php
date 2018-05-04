<?php

namespace App\Models\Tesoreria;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator, Cache;

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
    protected $fillable = ['retefuente_nombre','retefuente_tarifa_declarante_natural','retefuente_tarifa_no_declarate_natural','retefuente_tarifa_juridico','retefuente_base'];

    protected $boolean = ['retefuente_activo'];

    public function isValid($data)
    {
        $rules = [
            'retefuente_nombre' => 'required|max:100|unique:retefuente',
            'retefuente_tarifa_declarante_natural' => 'numeric',
            'retefuente_tarifa_no_declarate_natural' => 'numeric',
            'retefuente_tarifa_juridico' => 'numeric',
            'retefuente_base' => 'required|numeric'
        ];

        if ($this->exists){
            $rules['retefuente_nombre'] .= ',retefuente_nombre,' . $this->id;
        }else{
            $rules['retefuente_nombre'] .= '|required';
        }

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
}
