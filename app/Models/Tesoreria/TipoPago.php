<?php

namespace App\Models\Tesoreria;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator, Cache;

class TipoPago extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tipopago';

    public $timestamps = false;

    /**
 	* The key used by cache store.
 	*
 	* @var static string
 	*/
    public static $key_cache = '_tipopago';


    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['tipopago_nombre'];

    protected $boolean = ['tipopago_activo'];

    public function isValid($data)
    {
        $rules = [
            'tipopago_nombre' => 'required|max:50|unique:tipopago',
        ];
        if ($this->exists){
            $rules['tipopago_nombre'] .= ',tipopago_nombre,' . $this->id;
        }else{
            $rules['tipopago_nombre'] .= '|required';
        }
        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getTiposPagos()
    {
        if ( Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = TipoPago::query();
            $query->orderBy('tipopago_nombre', 'asc');
            $collection = $query->lists('tipopago_nombre', 'tipopago.id');
            $collection->prepend('', '');
            return $collection;
        });
    }

    public static function getTipoPago($id){
        $tipopago = TipoPago::query();
        $tipopago->select('tipopago.*', 'documentos_nombre', 'documentos_codigo');
        $tipopago->leftJoin('documentos', 'tipopago_documentos','=','documentos.id');
        $tipopago->where('tipopago.id', $id);
        return $tipopago->first();
    }
}
