<?php

namespace App\Models\Tecnico;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator, Cache, DB;

class Prioridad extends BaseModel
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
    protected $table = 'prioridad';

    public $timestamps = false;

	/**
	* The key used by cache store.
	*
	* @var static string
	*/
    public static $key_cache = '_prioridad';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['prioridad_nombre'];

    protected $boolean = ['prioridad_activo'];

    public function isValid($data)
    {
        $rules = [
            'prioridad_nombre' => 'required|max:200|unique:prioridad'
        ];

        if ($this->exists){
            $rules['prioridad_nombre'] .= ',prioridad_nombre,' . $this->id;
        }else{
            $rules['prioridad_nombre'] .= '|required';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getPrioridad()
    {
        if (Cache::has( self::$key_cache )) {
            return Cache::get( self::$key_cache );
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = Prioridad::query();
            $query->where('prioridad_activo', true);
            $query->orderBy('prioridad_nombre', 'asc');
            $collection = $query->lists('prioridad_nombre', 'id');

            $collection->prepend('', '');
            return $collection;
        });
    }
}
