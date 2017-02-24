<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;

use Validator, Cache;

use App\Models\BaseModel;

class Unidad extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'unidadmedida';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_unidadmedida';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['unidadmedida_nombre', 'unidadmedida_sigla'];

    /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = ['unidad_medida_activo'];

    public function isValid($data)
    {
        $rules = [
            'unidadmedida_sigla' => 'required|max:4|min:1|unique:unidadmedida',
            'unidadmedida_nombre' => 'required|max:25'
        ];

        if ($this->exists){
            $rules['unidadmedida_sigla'] .= ',unidadmedida_sigla,' . $this->id;
        }else{
            $rules['unidadmedida_sigla'] .= '|required';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getUnidades()
    {
        if (Cache::has( self::$key_cache )) {
            return Cache::get( self::$key_cache );
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = Unidad::query();
            $query->orderby('unidadmedida_nombre', 'asc');
            return $query->lists('unidadmedida_nombre', 'id');
        });
    }
}
