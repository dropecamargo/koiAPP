<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator,Cache;

class Modelo extends BaseModel
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'modelo';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_modelos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['modelo_nombre'];

    /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = ['modelo_activo'];


    public function isValid($data)
    {
        $rules = [
            'modelo_nombre' => 'required|max:100|unique:modelo',

        ];
        if ($this->exists){
            $rules['modelo_nombre'] .= ',modelo_nombre,' . $this->id;
        }else{
            $rules['modelo_nombre'] .= '|required';
        }
        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getModelos()
    {
        if ( Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = Modelo::query();
            $query->orderBy('modelo_nombre', 'asc');
            $collection = $query->lists('modelo_nombre', 'modelo.id');
            $collection->prepend('', '');
            return $collection;
        });
    }

    /**
     * Get the attributes for the acabadospName.
     */
    public function marca()
    {
        return $this->hasOne('App\Models\Inventario\Marca', 'id' , 'modelo_marca');
    }
}
