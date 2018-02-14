<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator,Cache;

class Impuesto extends BaseModel
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
    protected $table = 'impuesto';

    public $timestamps = false;

	/**
	* The key used by cache store.
	*
	* @var static string
	*/
    public static $key_cache = '_impuesto';

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['impuesto_nombre','impuesto_porcentaje'];

    protected $boolean = ['impuesto_activo'];

    public function isValid($data)
    {
        $rules = [
            'impuesto_nombre' => 'required|max:100|unique:impuesto',
            'impuesto_porcentaje' => 'required|numeric'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getImpuestos()
    {
        if ( Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = Impuesto::query();
            $query->orderBy('impuesto_nombre', 'asc');
            $collection = $query->lists('impuesto_nombre', 'impuesto.id');
            $collection->prepend('', '');
            return $collection;

        });
    }
}
