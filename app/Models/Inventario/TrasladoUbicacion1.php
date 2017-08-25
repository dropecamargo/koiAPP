<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use Validator,DB;

class TrasladoUbicacion1 extends Model
{
   /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'trasladou1';

	public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['trasladou1_observaciones', 'trasladou1_fecha'];

	/**
	* The default pedido if documentos.
	*
	* @var static string
	*/

	public static $default_document = 'TRAU';


	public function isValid($data){
		$rules = [
		    'trasladou1_fecha' => 'required|date',
		    'trasladou1_numero' => 'required|numeric'
		];
		$validator = Validator::make($data, $rules);
		if ( $validator->passes() ) {
			//Validar carrito
            $trasladou2 = isset($data['detalle']) ? $data['detalle'] : null;
            if(!isset($trasladou2) || $trasladou2 == null || !is_array($trasladou2) || count($trasladou2) == 0) {
                $this->errors = 'Por favor ingrese el detalle para realizar el traslado.';
                return false;
            }

            return true;
		}
		$this->errors = $validator->errors();
		return false;
	}

	public static function getTrasladoUbicacion($id){
        $query = TrasladoUbicacion1::query();
        $query->select('trasladou1.*', 'o.ubicacion_nombre as origen', 'd.ubicacion_nombre as destino', 's.sucursal_nombre','u.username as username_elaboro', 'tipotraslado_nombre');
        $query->join('tipotraslado', 'trasladou1_tipotraslado', '=', 'tipotraslado.id');
        $query->join('sucursal as s', 'trasladou1_sucursal', '=', 's.id');
        $query->leftJoin('ubicacion as o', 'trasladou1_origen', '=', 'o.id');
        $query->leftJoin('ubicacion as d', 'trasladou1_destino', '=', 'd.id');
        $query->join('tercero as u', 'trasladou1_usuario_elaboro', '=', 'u.id');
        $query->where('trasladou1.id', $id);
        return $query->first();
	}	
}
