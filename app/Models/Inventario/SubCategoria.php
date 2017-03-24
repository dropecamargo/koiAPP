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
    protected $fillable = ['subcategoria_nombre'];

    protected $boolean = ['subcategoria_activo'];

    public function isValid($data)
    {
        $rules = [
            'subcategoria_nombre' => 'required|max:25'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
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
