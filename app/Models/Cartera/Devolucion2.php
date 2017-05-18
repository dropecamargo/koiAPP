<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;
use Validator,DB;

class Devolucion2 extends Model
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'devolucion2';
	public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['devolucion2_cantidad', 'devolucion2_precio','devolucion2_costo','devolucion2_descuento','devolucion2_iva'];

	public function isValid($data)
	{
		$rules = [
			'devolucion2_cantidad' => 'required|numeric|min:1',
			'devolucion2_precio' => 'required|numeric|min:0',
			'devolucion2_costo' => 'numeric|min:0|required',
			'devolucion2_descuento' => 'required|numeric|min:0',
			'factura2_costo' => 'required|numeric|min:1',
			'devolucion2_iva' => 'required|numeric|min:0'
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}

	public static function modelCreate($data){
		$devolucion2 = new Devolucion2;
	    $devolucion2->id = uniqid();

	    $devolucion2->producto_nombre = $data->producto_nombre;
	    $devolucion2->producto_serie = $data->producto_serie;
	    $devolucion2->devolucion2_producto = $data->factura2_producto;
	    $devolucion2->devolucion2_cantidad = $data->factura2_cantidad;
	    $devolucion2->devolucion2_costo = $data->factura2_costo;
	    $devolucion2->devolucion2_precio = $data->factura2_precio_venta;
	    $devolucion2->devolucion2_descuento = $data->factura2_descuento_valor;
	    $devolucion2->devolucion2_iva = $data->factura2_iva_porcentaje;
	    
	    return $devolucion2;
	}
}
