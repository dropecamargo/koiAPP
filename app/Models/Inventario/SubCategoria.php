<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator,Cache;

class SubCategoria extends BaseModel
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subcategoria';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_subcategoria';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['subcategoria_nombre','subcategoria_margen_nivel1','subcategoria_margen_nivel2','subcategoria_margen_nivel3'];

    protected $boolean = ['subcategoria_activo'];

    public function isValid($data)
    {
        $rules = [
            'subcategoria_nombre' => 'required|max:25|unique:subcategoria',
            'subcategoria_categoria' => 'required',
            'subcategoria_margen_nivel1' => 'required|numeric',
            'subcategoria_margen_nivel2' => 'required|numeric',
            'subcategoria_margen_nivel3' => 'required|numeric'
        ];
        
        if ($this->exists){
            $rules['subcategoria_nombre'] .= ',subcategoria_nombre,' . $this->id;
        }else{
            $rules['subcategoria_nombre'] .= '|required';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            
            // Valid valor de margenes
            if ($data['subcategoria_margen_nivel1'] > 0) {
                if ($data['subcategoria_margen_nivel1'] <= $data['subcategoria_margen_nivel2'] || $data['subcategoria_margen_nivel1'] <= $data['subcategoria_margen_nivel3']) {
                    $this->errors = 'MARGEN NIVEL 1 debe ser mayor a los demás niveles de margenes.';
                    return false;
                }
                if ($data['subcategoria_margen_nivel2'] <= $data['subcategoria_margen_nivel3']) {
                    $this->errors = 'MARGEN NIVEL 2 debe ser mayor al MARGEN NIVEL 3.';
                    return false;
                }
            }
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
    public static function getSubCategoria ($id)
    {
        $query = SubCategoria::query();
        $query->select('subcategoria.*', 'categoria_nombre');
        $query->leftJoin('categoria', 'subcategoria_categoria', '=', 'categoria.id');
        $subcategoria = $query->where('subcategoria.id', $id)->first();
        return $subcategoria;
    }
    public static function getSubCategorias()
    {
        if ( Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = SubCategoria::query();
            $query->orderBy('subcategoria_nombre', 'asc');
            $collection = $query->lists('subcategoria_nombre', 'subcategoria.id');
            $collection->prepend('', '');
            return $collection;
        });
    }
}
