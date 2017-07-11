<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

use Validator,Cache, DB;

class Servicio extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'servicio';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_servicios';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['servicio_nombre'];

    protected $boolean = ['servicio_activo'];

    public function isValid($data)
    {
        $rules = [
            'servicio_nombre' => 'required|max:25'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getServicios()
    {
        if ( Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = Servicio::query();
            $query->where('servicio_activo', true);
            $query->orderBy('servicio_nombre', 'asc');
            $collection = $query->lists('servicio_nombre', 'servicio.id');
            $collection->prepend('', '');
            return $collection;
        });
    }}
