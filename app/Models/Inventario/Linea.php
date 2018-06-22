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
    protected $fillable = ['linea_nombre', 'linea_margen_nivel1', 'linea_margen_nivel2', 'linea_margen_nivel3'];

    /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = ['linea_activo'];

    public function isValid($data)
    {
        $rules = [
            'linea_nombre' => 'required|max:50|unique:linea',
            'linea_inventario' => 'required|min:1',
            'linea_costo' => 'required|min:1',
            'linea_venta' => 'required|min:1',
            'linea_margen_nivel1' => 'max:4',
            'linea_margen_nivel2' => 'max:4',
            'linea_margen_nivel3' => 'max:4',
        ];

        if ($this->exists){
            $rules['linea_nombre'] .= ',linea_nombre,' . $this->id;
        }else{
            $rules['linea_nombre'] .= '|required';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes())
        {
            // Valid valor de margenes
            if ($data['linea_margen_nivel1'] > 0) {
                if ($data['linea_margen_nivel1'] <= $data['linea_margen_nivel2'] || $data['linea_margen_nivel1'] <= $data['linea_margen_nivel3']) {
                    $this->errors = 'MARGEN NIVEL 1 debe ser mayor a los demás niveles de margenes.';
                    return false;
                }
                if ($data['linea_margen_nivel2'] <= $data['linea_margen_nivel3']) {
                    $this->errors = 'MARGEN NIVEL 2 debe ser mayor al MARGEN NIVEL 3.';
                    return false;
                }
            }
            return true;
        }
        $this->errors = $validator->errors();
        return false;
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

    public static function getline($id)
    {
        $query = Linea::query();
        $query->select('linea.*', 'plancuentas_cuenta', 'plancuentas_nombre');
        $query->leftJoin('plancuentas', 'linea_inventario', '=', 'plancuentas.id');
        $query->where('linea.id', $id);
        return $query->first();
    }

}
