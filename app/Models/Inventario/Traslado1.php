<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use Validator,DB;

class Traslado1 extends Model
{
   /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'traslado1';

	public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['traslado1_observaciones', 'traslado1_fecha'];

	/**
	* The default pedido if documentos.
	*
	* @var static string
	*/
	public static $default_document = 'TRAS';

	public function isValid($data){
		$rules = [
		    'traslado1_fecha' => 'required|date',
		    'traslado1_numero' => 'required|numeric'
		];
		$validator = Validator::make($data, $rules);
		if ( $validator->passes() ) {
			//Validar carrito
            $traslado2 = isset($data['detalle']) ? $data['detalle'] : null;
            if(!isset($traslado2) || $traslado2 == null || !is_array($traslado2) || count($traslado2) == 0) {
                $this->errors = 'Por favor ingrese el detalle para realizar el traslado.';
                return false;
            }

            return true;
		}
		$this->errors = $validator->errors();
		return false;
	}

	public static function getTraslado($id){
        $query = Traslado1::query();
        $query->select('traslado1.*', 'o.sucursal_nombre as origen', 'd.sucursal_nombre as destino', 'u.username as username_elaboro');
        $query->join('sucursal as o', 'traslado1_origen', '=', 'o.id');
        $query->join('sucursal as d', 'traslado1_destino', '=', 'd.id');
        $query->join('tercero as u', 'traslado1_usuario_elaboro', '=', 'u.id');
        $query->where('traslado1.id', $id);
        return $query->first();
	}	
}
