<?php

namespace App\Models\Tesoreria;

use Illuminate\Database\Eloquent\Model;

class Facturap3 extends Model
{
   /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'facturap3';

	public $timestamps = false;

	public static function storeFacturap3 (Facturap1 $facturap1){
		
		if ($facturap1->facturap1_cuotas > 0) {
			$valor = $facturap1->facturap1_apagar / $facturap1->facturap1_cuotas;
			$fecha = $facturap1->facturap1_primerpago; 
			for ($i=1; $i <= $facturap1->facturap1_cuotas; $i++) {
				$facturap3 = new Facturap3;
				$facturap3->facturap3_facturap1 = $facturap1->id;
				$facturap3->facturap3_cuota = $i;
				$facturap3->facturap3_valor = $valor;
				$facturap3->facturap3_saldo = $valor;
				$facturap3->facturap3_vencimiento = $fecha;
				$fechavencimiento = date('Y-m-d',strtotime('+1 months', strtotime($fecha)));
				$fecha = $fechavencimiento;
				$facturap3->save();
			}
			return true;
		}else{

			$facturap3 = new Facturap3;
			$facturap3->facturap3_facturap1 = $facturap1->id;
			$facturap3->facturap3_cuota = $facturap1->facturap1_cuotas;
			$facturap3->facturap3_valor = $facturap1->facturap1_apagar;
			$facturap3->facturap3_saldo = $facturap1->facturap1_apagar;
			$facturap3->facturap3_vencimiento = $facturap1->facturap1_primerpago;
			$facturap3->save();
			return true;
		}

		return false;
	}
}
