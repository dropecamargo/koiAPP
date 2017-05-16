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
			for ($i=1; $i <= $factura1->factura1_cuotas; $i++) {
				$factura3 = new Factura3;
				$factura3->factura3_factura1 = $factura1->id;
				$factura3->factura3_cuota = $i;
				$factura3->factura3_valor = $valor;
				$factura3->factura3_saldo = $valor;
				$factura3->factura3_vencimiento = $fecha;
				$fechavencimiento = date('Y-m-d',strtotime('+1 months', strtotime($fecha)));
				$fecha = $fechavencimiento;
				$factura3->save();
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
