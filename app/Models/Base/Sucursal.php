<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator, Cache;

class Sucursal extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sucursal';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_sucursales';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['sucursal_nombre','sucursal_direccion', 'sucursal_direccion_nomenclatura','sucursal_telefono','sucursal_regional','sucursal_pedn','sucursal_entr','sucusal_tras'];

    /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = ['sucursal_activo','sucursal_ubicaciones'];


    public function isValid($data)
    {
        $rules = [
            'sucursal_nombre' => 'required|max:200|unique:sucursal',
            'sucursal_direccion'=>'required|max:200',
            'sucursal_regional' => 'required'
        ];

        if ($this->exists){
            $rules['sucursal_nombre'] .= ',sucursal_nombre,' . $this->id;
        }else{
            $rules['sucursal_nombre'] .= '|required';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }


    public static function getSucursales()
    {
        if (Cache::has( self::$key_cache )) {
            return Cache::get( self::$key_cache );
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = Sucursal::query();
            $query->orderby('sucursal_nombre', 'asc');
            $collection = $query->lists('sucursal_nombre', 'id');
            $collection->prepend('', '');
            return $collection;
        });
    }

    public static function getSucursal($id){
        $query = Sucursal::query();
        $query->select('sucursal.*','regional.*','ubicacion_nombre','sucursal.id as id');
        $query->join('regional','sucursal_regional','=','regional.id');
        $query->leftJoin('ubicacion','sucursal_defecto','=','ubicacion.id');
        $query->where('sucursal.id', $id);
        return $query->first();
    }
}
