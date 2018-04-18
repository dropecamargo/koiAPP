<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator;

class Factura2 extends BaseModel
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'factura2';

	public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['factura2_cantidad','factura2_producto_nombre', 'factura2_precio_venta','factura2_descuento_porcentaje','factura2_descuento_valor','factura2_costo','factura2_iva_porcentaje','factura2_iva_valor'];

	public function isValid($data)
	{
		$rules = [
			'factura2_cantidad' => 'required|numeric|min:1',
			'factura2_precio_venta' => 'required|numeric|min:0',
			'factura2_descuento_porcentaje' => 'numeric|min:0|required',
			'factura2_descuento_valor' => 'required|numeric|min:0',
			'factura2_costo' => 'required|numeric|min:1',
			'factura2_iva_porcentaje' => 'required|numeric|min:0',
			'factura2_iva_valor' => 'numeric|min:0'
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}

	public static function getFactura2($id)
	{
		$query = Factura2::query();
		$query->select('factura2.*','producto_serie','factura2_producto_nombre as producto_nombre', 'producto_nombre as nombre_original');
        $query->join('producto', 'factura2_producto', '=' ,'producto.id');
        $query->orderBy('factura2.id', 'asc');
		$query->where('factura2_factura1', $id);
		return $query->get();
	}

	public static function modelCreate ($data)
	{
		$factura2 = new Factura2;
	    $factura2->id = uniqid();
	    $factura2->producto_nombre = $data->producto_nombre;
	    $factura2->producto_serie = $data->producto_serie;
	    $factura2->factura2_cantidad = $data->pedidoc2_cantidad;
	    $factura2->factura2_costo = $data->pedidoc2_costo;
	    $factura2->factura2_precio_venta = $data->pedidoc2_precio_venta;
	    $factura2->factura2_descuento_valor = $data->pedidoc2_descuento_valor;
	    $factura2->factura2_descuento_porcentaje = $data->pedidoc2_descuento_porcentaje;
	    $factura2->factura2_iva_valor = $data->pedidoc2_iva_valor;
	    $factura2->factura2_iva_porcentaje = $data->pedidoc2_iva_porcentaje;
	    $factura2->factura2_linea = $data->pedidoc2_linea;
	    $factura2->factura2_margen = $data->pedidoc2_margen;
	    $factura2->producto_id = $data->pedidoc2_producto;
	    $factura2->maneja_serie = $data->producto_maneja_serie;
	    $factura2->maneja_inventario = $data->producto_unidad;
	    return $factura2;
	}
	public static function remRmpuModelCreate ($data)
	{
		$factura2 = new Factura2;
	    $factura2->id = uniqid();
	    $factura2->producto_nombre = $data->remrepu2_nombre;
	    $factura2->producto_serie = $data->remrepu2_serie;
	    $factura2->factura2_cantidad = $data->remrepu2_facturado;
	    $factura2->factura2_costo = $data->remrepu2_costo;
	    $factura2->factura2_iva_porcentaje = $data->remrepu2_iva_porcentaje;
	    return $factura2;
	}
}
