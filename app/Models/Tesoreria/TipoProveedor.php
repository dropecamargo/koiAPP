<?php

namespace App\Models\Tesoreria;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator,Cache;

class TipoProveedor extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tipoproveedor';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_tipoproveedor';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tipoproveedor_nombre'];

    protected $boolean = ['tipoproveedor_activo'];

    public function isValid($data)
    {
        $rules = [
            'tipoproveedor_nombre' => 'required|max:50|unique:tipoproveedor',
        ];
        if ($this->exists){
            $rules['tipoproveedor_nombre'] .= ',tipoproveedor_nombre,' . $this->id;
        }else{
            $rules['tipoproveedor_nombre'] .= '|required';
        }
        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getTiposProveedores()
    {
        if ( Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = TipoProveedor::query();
            $query->orderBy('tipoproveedor_nombre', 'asc');
            $collection = $query->lists('tipoproveedor_nombre', 'tipoproveedor.id');
            $collection->prepend('', '');
            return $collection;
        });
    }
}
