<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;
use Validator;

class Recibo3 extends BaseModel
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'recibo3';

	public $timestamps = false;
	
	public function isValid($data)
	{
		$rules = [];
		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            // Validar Carrito
            $recibo2 = isset($data['recibo2']) ? $data['recibo2'] : null;
            if(!isset($recibo2) || $recibo2 == null || !is_array($recibo2) || count($recibo2) == 0) {
                $this->errors = 'Por favor ingrese el detalle de concepto para realizar recibo de forma correcta.';
                return false;
            }
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}
	/*
	* Valido que exista cuota cuando es cheque  
	*/
	public function validarCheque($data){
		$result = 'OK';
		foreach ( $data['recibo2'] as $value ) {
			if ( isset($value['call']) && $value['call'] == 'recibo') {
				$cheque = ChposFechado2::where('chposfechado2_chposfechado1', $data['recibo3_cheque_id'] )->where('chposfechado2_id_doc', $value['factura3_id'])->first();
				if (!$cheque instanceof ChposFechado2) {
					$result = "Cheque numero {$data['recibo3_numero_medio']} No corresponte a la factura número {$value['factura1_numero']}";
				}else{
					$result = 'OK';
				}
			}
		}
		return $result;
	}
}
