<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Cache, Validator;

class Documentos extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'documentos';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_documentos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['documentos_codigo', 'documentos_nombre'];
    protected $boolean = ['documentos_cartera', 'documentos_contabilidad', 'documentos_comercial', 'documentos_inventario', 'documentos_tecnico', 'documentos_tesoreria'];

    public function isValid($data)
    {
        $rules = [
            'documentos_codigo' => 'required|max:4|unique:documentos',
            'documentos_nombre' => 'required|max:25'
        ];

        if ($this->exists){
            $rules['documentos_codigo'] .= ',documentos_codigo,' . $this->id;
        }else{
            $rules['documentos_codigo'] .= '|required';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getDocumentos()
    {
        if ( Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = Documentos::query();
            $query->orderBy('documentos_nombre', 'asc');
            $collection = $query->lists('documentos_nombre', 'id');

            $collection->prepend('', '');
            return $collection;
        });
    }
}
