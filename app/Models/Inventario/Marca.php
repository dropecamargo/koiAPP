<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator,Cache;

class Marca extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'marca';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_marcas';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['marca_nombre'];

    protected $boolean = ['marca_activo'];

    public function isValid($data)
    {
        $rules = [
            'marca_nombre' => 'required|max:100|unique:marca'
        ];
        if ($this->exists){
			$rules['marca_nombre'] .= ',marca_nombre,' . $this->id;
		}else{
			$rules['marca_nombre'] .= '|required';
		}
        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getMarcas()
    {
        if ( Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = Marca::query();
            $query->orderBy('marca_nombre', 'asc');
            $collection = $query->lists('marca_nombre', 'marca.id');
            $collection->prepend('', '');
            return $collection;
        });
    }
}
