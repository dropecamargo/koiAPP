<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;
use Validator,DB;

class Devolucion1 extends Model
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'devolucion1';

	public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    public static $default_document = 'DEVO';


	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['devolucion1_observaciones','devolucion1_bruto','devolucion1_descuento','devolucion1_iva','devolucion1_retencion','devolucion1_total','devolucion1_fecha'];

	public function isValid($data)
	{
		$rules = [
		    'devolucion1_numero' => 'required|numeric',
			'devolucion1_descuento' => 'required|numeric',
			'devolucion1_bruto' => 'required|numeric',
			'devolucion1_iva' => 'required|numeric',
			'devolucion1_total' => 'required|numeric'
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            // Validar Carrito
            $devolucion2 = isset($data['devolucion2']) ? $data['devolucion2'] : null;
            if(!isset($devolucion2) || $devolucion2 == null || !is_array($devolucion2) || count($devolucion2) == 0) {
                $this->errors = 'Por favor ingrese el detalle para realizar la devolucion.';
                return false;
            }

            return true;
        }

		$this->errors = $validator->errors();
		return false;
	}

}
