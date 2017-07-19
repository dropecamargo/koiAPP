<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

use Validator, Cache;

class Regional extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'regional';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_regionales';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['regional_nombre'];

    /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = ['regional_activo'];


    public function isValid($data)
    {
        $rules = [
            'regional_nombre' => 'required|max:50'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }


    public static function getRegionales()
    {
        if (Cache::has( self::$key_cache )) {
            return Cache::get( self::$key_cache );
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = Regional::query();
            $query->orderby('regional_nombre', 'asc');
            $collection = $query->lists('regional_nombre', 'id'); 
            $collection->prepend('', '');
            return $collection;
        });
    }
}
