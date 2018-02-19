<?php

namespace App\Models\Contabilidad;

use Illuminate\Database\Eloquent\Model;
use Validator, Cache;

class Folder extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'folder';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['folder_codigo', 'folder_nombre'];

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_folders';

    public function isValid($data)
    {
        $rules = [
            'folder_codigo' => 'required|max:4|min:1|unique:folder',
            'folder_nombre' => 'required|max:50'
        ];

        if ($this->exists){
            $rules['folder_codigo'] .= ',folder_codigo,' . $this->id;
        }else{
            $rules['folder_codigo'] .= '|required';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getFolders()
    {
        if (Cache::has( self::$key_cache )) {
            return Cache::get( self::$key_cache );
        }

        return Cache::rememberForever( self::$key_cache, function() {
            $query = Folder::query();
            $query->orderby('folder_nombre', 'asc');
            $collection = $query->lists('folder_nombre', 'id');

            $collection->prepend('', '');
            return $collection;
        });
    }
}
