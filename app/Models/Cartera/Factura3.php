<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;
use Validator;

class Factura3 extends BaseModel
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'factura3';

	public $timestamps = false;

	public static function storeFactura3 (Factura1 $factura1){
		if ($factura1->factura1_cuotas > 0) {
			$valor = $factura1->factura1_total / $factura1->factura1_cuotas;
			$fecha = $factura1->factura1_primerpago; 
			for ($i=0; $i < $factura1->factura1_cuotas; $i++) {
				$factura3 = new Factura3;
				$factura3->factura3_factura1 = $factura1->id;
				$factura3->factura3_cuota = $i;
				$factura3->factura3_valor = $valor;
				$factura3->factura3_saldo = $valor;
				$factura3->factura3_vencimiento = $fecha;
				$factura3->save();
				
				// Prepare interval each 30 days
				$fecha =  $factura3->factura3_vencimiento;
				$fecha = date_create($fecha + '');
				date_add($fecha, date_interval_create_from_date_string('30 days'));
			}
			return true;
		}else{

			$factura3 = new Factura3;
			$factura3->factura3_factura1 = $factura1->id;
			$factura3->factura3_cuota = $factura1->factura1_cuotas;
			$factura3->factura3_valor = $factura1->factura1_total;
			$factura3->factura3_saldo = $factura1->factura1_total;
			$factura3->factura3_vencimiento = $factura1->factura1_primerpago;
			$factura3->save();
			return true;
		}

		return false;
	}
}
