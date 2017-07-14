<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;
use Validator, Cache;

class Ubicacion extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ubicacion';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_ubicaciones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['ubicacion_nombre'];

    /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = ['ubicacion_activo'];


    public function isValid($data)
    {
        $rules = [
            'ubicacion_nombre' => 'required|max:25'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getUbicacion($id){

    }
}
