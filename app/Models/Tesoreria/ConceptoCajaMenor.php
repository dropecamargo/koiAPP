<?php

namespace App\Models\Tesoreria;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;
use Validator, Cache, DB;

class ConceptoCajaMenor extends BaseModel
{
    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'conceptocajamenor';

    public $timestamps = false;

    /**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_conceptocajamenor';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['conceptocajamenor_nombre'];

    protected $boolean = ['conceptocajamenor_activo'];

    public function isValid($data)
    {
        $rules = [
            'conceptocajamenor_nombre' => 'required|max:50|unique:conceptocajamenor',
            'conceptocajamenor_administrativo' => 'required',
            'conceptocajamenor_ventas' => 'required',
        ];

        if ($this->exists){
            $rules['conceptocajamenor_nombre'] .= ",conceptocajamenor_nombre, $this->id";
        }else{
            $rules['conceptocajamenor_nombre'] .= '|required';
        }

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getConceptsCajaMenor()
    {
        if ( Cache::has(self::$key_cache)) {
            return Cache::get(self::$key_cache);
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = ConceptoCajaMenor::query();
            $query->select('id','conceptocajamenor_nombre');
            $query->where('conceptocajamenor_activo', true);
            $collection = $query->lists('conceptocajamenor_nombre', 'id');

            $collection->prepend('', '');
            return $collection;
        });
    }

    public static function getConceptoCajaMenor($id){
        $query = ConceptoCajaMenor::query();
        $query->select('conceptocajamenor.*', DB::raw("CONCAT(a.plancuentas_cuenta, ' - ' ,a.plancuentas_nombre) AS cuenta_administrativa, CONCAT(v.plancuentas_cuenta, ' - ' ,v.plancuentas_nombre) AS cuenta_ventas") );
        $query->join('plancuentas as a', 'conceptocajamenor_administrativo', '=', 'a.id');
        $query->join('plancuentas as v', 'conceptocajamenor_ventas', '=', 'v.id');
        $query->where('conceptocajamenor.id', $id);
        return $query->first();
    }
}
