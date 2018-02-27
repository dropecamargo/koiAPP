<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator,Cache;

class TipoProducto extends BaseModel
{
    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'tipoproducto';

    public $timestamps = false;
    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_tipoproductos';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['tipoproducto_codigo', 'tipoproducto_nombre'];

    /**
    * The attributes that are mass boolean assignable.
    *
    * @var array
    */
    protected $boolean = ['tipoproducto_activo'];

    public function isValid($data)
    {
        $rules = [
            'tipoproducto_codigo' => 'required|max:2|unique:tipoproducto',
            'tipoproducto_nombre' => 'required|max:200',
        ];

        if ($this->exists){
            $rules['tipoproducto_codigo'] .= ',tipoproducto_codigo,' . $this->id;
        }else{
            $rules['tipoproducto_codigo'] .= '|required';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getTiposProducto()
    {
        if (Cache::has( self::$key_cache )) {
            return Cache::get( self::$key_cache );
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = TipoProducto::query();
            $query->where('tipoproducto_activo', true);
            $query->orderby('tipoproducto_nombre', 'asc');

            $collection = $query->lists('tipoproducto_nombre', 'id');
            $collection->prepend('', '');
            return $collection;
        });
    }
}
