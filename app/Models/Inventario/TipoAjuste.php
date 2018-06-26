<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel, App\Models\Inventario\TipoAjuste2;
use Validator, Cache, DB;

class TipoAjuste extends BaseModel
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'tipoajuste';

	public $timestamps = false;
	/**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_tipoAjuste';

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = ['tipoajuste_nombre','tipoajuste_sigla','tipoajuste_tipo'];

	/**
	* The attributes that are mass boolean assignable.
	*
	* @var array
	*/
	protected $boolean = ['tipoajuste_activo', 'tipoajuste_calculaiva'];

	public function isValid($data)
	{
		$rules = [
			'tipoajuste_nombre' => 'required|max:25|unique:tipoajuste',
			'tipoajuste_sigla' => 'required|max:3|unique:tipoajuste',
			'tipoajuste_tipo' => 'required|max:1',
			'tipoajuste_cuenta' => 'required_if:tipoajuste_tipo,E|required_if:tipoajuste_tipo,S|min:1|numeric',
		];

        if ($this->exists){
            $rules['tipoajuste_nombre'] .= ',tipoajuste_nombre,' . $this->id;
            $rules['tipoajuste_sigla'] .= ',tipoajuste_sigla,' . $this->id;
        }else{
            $rules['tipoajuste_nombre'] .= '|required';
            $rules['tipoajuste_sigla'] .= '|required';
        }

		$validator = Validator::make($data, $rules);
		if ($validator->passes()) {
			// Validar carrito
            $detalle = isset($data['detalle']) ? $data['detalle'] : null;
            if(!isset($detalle) || $detalle == null || !is_array($detalle) || count($detalle) == 0) {
                $this->errors = 'Por favor ingrese al menos un tipo de producto.';
                return false;
            }
			return true;
		}
		$this->errors = $validator->errors();
		return false;
	}

 	public static function getTiposAjustes()
    {
        if (Cache::has( self::$key_cache )) {
            return Cache::get( self::$key_cache );
        }

        return Cache::rememberForever( self::$key_cache , function() {
            $query = TipoAjuste::query();
            $query->orderby('tipoajuste_nombre', 'asc');
            $query->where('tipoajuste_activo', true);
            $collection = $query->lists('tipoajuste_nombre', 'id');

            $collection->prepend('', '');
            return $collection;
        });
    }
 	public static function getTipoAjuste($id)
    {
        $query = TipoAjuste::query();
        $query->select('tipoajuste.*', 'plancuentas_cuenta', 'plancuentas_nombre');
        $query->leftJoin('plancuentas', 'tipoajuste_cuenta', '=', 'plancuentas.id');
        $query->where('tipoajuste.id', $id);
    	return $query->first();
    }

	public function getTypesProducto()
	{
		$query = TipoAjuste2::query();
		$query->select(DB::raw("GROUP_CONCAT(tipoproducto_codigo SEPARATOR ',') AS tipoajuste_tipoproducto"));
		$query->join('tipoproducto', 'tipoajuste2_tipoproducto', '=', 'tipoproducto.id');
		$query->where('tipoajuste2_tipoajuste', $this->id);
		return $query->first();
	}
}
