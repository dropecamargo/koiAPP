<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use Validator,Cache;
use App\Models\BaseModel;

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
            'marca_nombre' => 'required|max:200'
        ];

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
