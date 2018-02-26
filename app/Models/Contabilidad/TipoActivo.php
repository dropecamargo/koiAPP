<?php

namespace App\Models\Contabilidad;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Cache, Validator;

class TipoActivo extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tipoactivo';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_tipoactivo';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tipoactivo_nombre','tipoactivo_vida_util'];

    protected $boolean = ['tipoactivo_activo'];

    public function isValid($data)
    {
        $rules = [
            'tipoactivo_nombre' => 'required|max:50|unique:tipoactivo',
            'tipoactivo_vida_util' => 'numeric|min:1',
        ];

        if ($this->exists){
            $rules['tipoactivo_nombre'] .= ',tipoactivo_nombre,' . $this->id;
        }else{
            $rules['tipoactivo_nombre'] .= '|required';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getTiposActivos()
    {
        if ( Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = TipoActivo::query();
            $query->orderBy('tipoactivo_nombre', 'asc');
            $collection = $query->lists('tipoactivo_nombre', 'tipoactivo.id');
            $collection->prepend('', '');
            return $collection;
        });
    }
}
