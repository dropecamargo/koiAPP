<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator,Cache;

class Categoria extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categoria';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_categoria';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['categoria_nombre'];

    protected $boolean = ['categoria_activo'];

    public function isValid($data)
    {
        $rules = [
            'categoria_nombre' => 'required|max:50|unique:categoria',
            'categoria_linea' => 'required'
        ];

        if ($this->exists){
            $rules['categoria_nombre'] .= ',categoria_nombre,' . $this->id;
        }else{
            $rules['categoria_nombre'] .= '|required';
        }
        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
    public static function getCategoria($id)
    {
        $query = Categoria::query();
        $query->select('categoria.*', 'linea_nombre');
        $query->leftJoin('linea', 'categoria_linea', '=', 'linea.id');
        $categoria = $query->where('categoria.id', $id)->first();
        return $categoria;
    }

    public static function getCategorias()
    {
        if ( Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = Categoria::query();
            $query->orderBy('categoria_nombre', 'asc');
            $collection = $query->lists('categoria_nombre', 'categoria.id');
            $collection->prepend('', '');
            return $collection;
        });
    }
}
