<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;
use Validator, Cache;

class PuntoVenta extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'puntoventa';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_points_of_sale';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['puntoventa_nombre', 'puntoventa_prefijo', 'puntoventa_resolucion_dian'];

    protected $boolean = ['puntoventa_activo'];

    public function isValid($data)
    {
        $rules = [
            'puntoventa_nombre' => 'required|max:200|unique:puntoventa',
            'puntoventa_prefijo' => 'max:4|unique:puntoventa'
        ];

        if ($this->exists){
            $rules['puntoventa_nombre'] .= ',puntoventa_nombre,' . $this->id;
            $rules['puntoventa_prefijo'] .= ',puntoventa_prefijo,' . $this->id;
        }else{
            $rules['puntoventa_nombre'] .= '|required';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getPuntosVenta()
    {
        if (Cache::has( self::$key_cache )) {
            return Cache::get( self::$key_cache );
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = PuntoVenta::query();
            $query->orderby('puntoventa_nombre', 'asc');
            $collection = $query->lists('puntoventa_nombre', 'id');

            return $collection;
        });
    }
}
