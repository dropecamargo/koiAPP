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

	public static function getFactura2($id)
	{
		$query = Factura2::query();
		$query->select('factura2.*','producto_serie','producto_nombre')->where('factura2_factura1',$id);
        $query->join('producto', 'factura2_producto', '=' ,'producto.id');
        $query->orderBy('factura2.id', 'asc');
		return  $query->get();
	}

	public static function modelCreate($data){
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
	    $factura2->factura2_subcategoria = $data->pedidoc2_subcategoria;
	    $factura2->factura2_margen = $data->pedidoc2_margen;
	    return $factura2;
	}
}
