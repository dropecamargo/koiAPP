<?php

namespace App\Models\Tesoreria;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator,Cache;

class TipoGasto extends BaseModel
{
    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'tipogasto';

    public $timestamps = false;

    /**
    * The key used by cache store.
    *
    * @var static string
    */
    public static $key_cache = '_tipogasto';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['tipogasto_nombre'];

    protected $boolean = ['tipogasto_activo'];

    public function isValid($data)
    {
        $rules = [
            'tipogasto_nombre' => 'required|max:50|unique:tipogasto'
        ];
        if ($this->exists){
            $rules['tipogasto_nombre'] .= ',tipogasto_nombre,' . $this->id;
        }else{
            $rules['tipogasto_nombre'] .= '|required';
        }
        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getTiposGastos()
    {
        if ( Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = TipoGasto::query();
            $query->orderBy('tipogasto_nombre', 'asc');
            $collection = $query->lists('tipogasto_nombre', 'tipogasto.id');
            $collection->prepend('', '');
            return $collection;
        });
    }
}
