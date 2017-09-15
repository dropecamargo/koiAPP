<?php

namespace App\Models\Contabilidad;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

use Validator, Cache;

class Documento extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'documento';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['documento_codigo', 'documento_nombre', 'documento_folder', 'documento_tipo_consecutivo'];

    /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = ['documento_nif', 'documento_actual'];

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_documentos';

    public function isValid($data)
    {
        $rules = [
            'documento_codigo' => 'required|max:20|min:1|unique:documento',
            'documento_nombre' => 'required|max:200',
            'documento_folder' => 'required',
            'documento_tipo_consecutivo' => 'required|max:1'
        ];

        if ($this->exists){
            $rules['documento_codigo'] .= ',documento_codigo,' . $this->id;
        }else{
            $rules['documento_codigo'] .= '|required';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getDocument($id)
    {
        $query = Documento::query();
        $query->select('documento.*', 'folder_nombre');
        $query->leftJoin('folder', 'documento_folder', '=', 'folder.id');
        $query->where('documento.id', $id);
        return $query->first();
    }

    public static function getDocuments()
    {
        if (Cache::has( self::$key_cache )) {
            return Cache::get( self::$key_cache );    
        }

        return Cache::rememberForever( self::$key_cache, function() {
            $query = Documento::query();
            $query->orderby('documento_nombre', 'asc');
            $collection = $query->lists('documento_nombre', 'id');
            
            $collection->prepend('', '');
            return $collection;
        });
    }
}
