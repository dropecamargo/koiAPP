<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;
use Validator,DB;

class Pedidoc1 extends BaseModel
{
  	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'pedidoc1';

	public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['pedidoc1_fecha','pedidoc1_cuotas','pedidoc1_primerpago','pedidoc1_plazo','pedidoc1_observaciones', 'pedidoc1_bruto', 'pedidoc1_descuento','pedidoc1_iva','pedidoc1_retencion','pedidoc1_total'];


    protected $boolean = ['pedidoc1_anular'];
	/**
	* The default pediddoc if documentos.
	*
	* @var static string
	*/
	public static $default_document = 'PEDC';

	public function isValid($data)
	{
		$rules = [
			'pedidoc1_numero' => 'required|numeric',
			'pedidoc1_fecha' => 'required|date',
			'pedidoc1_cuotas' => 'required|numeric|min:0',
			'pedidoc1_plazo' => 'required|numeric|min:0',
			'pedidoc1_primerpago' => 'required|date',
			'pedidoc1_bruto' => 'required|numeric',
			'pedidoc1_descuento' => 'required|numeric',
			'pedidoc1_iva' => 'required|numeric',
			'pedidoc1_total' => 'required|numeric'
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            // Validar Carrito
            $pedidoc2 = isset($data['detalle']) ? $data['detalle'] : null;
            if(!isset($pedidoc2) || $pedidoc2 == null || !is_array($pedidoc2) || count($pedidoc2) == 0) {
                $this->errors = 'Por favor ingrese el detalle para realizar el pedido comercial.';
                return false;
            }
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}

	public static function getPedidoc($id)
	{
		$query = Pedidoc1::query();
		$query->select('pedidoc1.*','sucursal_nombre','tercero_nit',DB::raw("CONCAT(tercero_nombre1, ' ', tercero_nombre2, ' ', tercero_apellido1, ' ', tercero_apellido2) as tercero_nombre"));
		$query->join('sucursal','pedidoc1.pedidoc1_sucursal','=', 'sucursal.id');
		$query->join('tercero','pedidoc1.pedidoc1_tercero','=', 'tercero.id');
		$query->where('pedidoc1.id',$id);
		return $query->first();
	}
}
