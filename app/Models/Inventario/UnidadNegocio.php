<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator,Cache;

class UnidadNegocio extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'unidadnegocio';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_unidadnegocio';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['unidadnegocio_nombre'];

    /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = ['unidadnegocio_activo'];

    public function isValid($data)
    {
        $rules = [
            'unidadnegocio_nombre' => 'required|max:25|unique:unidadnegocio'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getUnidadesNegocio()
    {
        if (Cache::has( self::$key_cache )) {
            return Cache::get( self::$key_cache );
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = UnidadNegocio::query();
            $query->orderby('unidadnegocio_nombre', 'asc');
            $collection = $query->lists('unidadnegocio_nombre', 'id');
            $collection->prepend('', '');
            return $collection;
        });
    }
}
