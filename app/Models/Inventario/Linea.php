<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

use Validator, Cache;

class Linea extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'linea';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_linea';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['linea_nombre'];

    /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = ['linea_activo'];

    public function isValid($data)
    {
        $rules = [
            'linea_nombre' => 'required|max: 25|unique:linea',
            'linea_unidadnegocio' => 'required'
        ];

        if ($this->exists){
            $rules['linea_nombre'] .= ',linea_nombre,' . $this->id;
        }else{
            $rules['linea_nombre'] .= '|required';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes())
        {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
    
    public static function getLine ($id)
    {
        $query = Linea::query();
        $query->select('linea.*', 'unidadnegocio_nombre');
        $query->leftJoin('unidadnegocio', 'linea_unidadnegocio', '=', 'unidadnegocio.id');
        $line = $query->where('linea.id', $id)->first();
        return $line;
    }

    public static function getlineas()
    {
        if ( Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = Linea::query();
            $query->orderBy('linea_nombre', 'asc');
            $collection = $query->lists('linea_nombre', 'linea.id');
            $collection->prepend('', '');
            return $collection;
        });
    }

}
