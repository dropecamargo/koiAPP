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

	    $devolucion2->id = $data->id;
	    $devolucion2->producto_nombre = $data->producto_nombre;
	    $devolucion2->producto_serie = $data->producto_serie;
	    $devolucion2->devolucion2_producto = $data->factura2_producto;
	    $devolucion2->factura2_cantidad = ($data->factura2_cantidad - $data->factura2_devueltas);
	    $devolucion2->devolucion2_costo = $data->factura2_costo;
	    $devolucion2->devolucion2_precio = $data->factura2_precio_venta;
	    $devolucion2->devolucion2_descuento = $data->factura2_descuento_valor;
	    $devolucion2->devolucion2_iva = $data->factura2_iva_porcentaje;
	    
	    return $devolucion2;
	}

	public static function getDevolucion2($id)
	{
		$query = Devolucion2::query();
		$query->select('devolucion2.*','producto_serie','producto_nombre')->where('devolucion2_devolucion1',$id);
        $query->join('producto', 'devolucion2_producto', '=' ,'producto.id');
        $query->orderBy('devolucion2.id', 'asc');
		return  $query->get();
	}

	public function store(Factura2 $factura2, $producto, $devolucion1, $cantidad){

		// Validar factura2
		if (!$factura2 instanceof Factura2) {
			return 'No es posible recuperar factura, por favor verifique información o consulte al administrador';
		}

		// Valido cantidad ingresada contra lo que esta en factura2
		if ($cantidad > $factura2->factura2_cantidad) {
			return 'La cantidad a devolver supera a la cantidad que se encuentra en la factura';
		}
		// Prepare model save
		$this->devolucion2_producto = $producto;
		$this->devolucion2_devolucion1 = $devolucion1;
		$this->devolucion2_cantidad = $cantidad;
		$this->devolucion2_costo =$factura2->factura2_costo;
		$this->devolucion2_precio = $factura2->factura2_precio_venta;
		$this->devolucion2_descuento = $factura2->factura2_descuento_valor;
		$this->devolucion2_iva = $factura2->factura2_iva_porcentaje;
		$this->save();

		// Update factura2_devueltas
		$factura2->factura2_devueltas = $cantidad + $factura2->factura2_devueltas;
		$factura2->save();
		
		return 'OK';
	}

	public static function doCalculate(Devolucion1 $devolucion1, Factura1 $factura1)
	{
        $devolucion2 = Devolucion2::where('devolucion2_devolucion1',$devolucion1->id)->get();
        if ($devolucion2->isEmpty()) {
            return 'No es posible recuperar detalle de la devolución, por favor verifique la información ó por favor consulte al administrador';
        }
        $total = 0;
        foreach ($devolucion2 as $value) {
        	$tbruto = $value->devolucion2_costo * $value->devolucion2_cantidad;
            $iva = $value->devolucion2_iva / 100;
            if ($value->devolucion2_precio > 0) {
                $iva = $value->devolucion2_precio * $iva * $value->devolucion2_cantidad; 
            }else{
                $iva = $value->devolucion2_costo * $iva * $value->devolucion2_cantidad; 
            }

            $descuento = $value->devolucion2_descuento * $value->devolucion2_cantidad; 
        	$total += ($tbruto + $iva) - $descuento;
        }
        $factura3 = Factura3::where('factura3_factura1', $factura1->id)->first();
        if (!$factura3 instanceof Factura3) {
            return 'No es posible recuperar cuotas de factura, por favor verifique la información ó por favor consulte al administrador';
        }
        // Update saldo
        $factura3->factura3_saldo = $factura3->factura3_saldo - $total;
        $factura3->save();
		return 'OK';
	}
}
