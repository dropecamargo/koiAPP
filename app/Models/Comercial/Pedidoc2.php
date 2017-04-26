<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

use Validator, DB;

class Pedidoc2 extends Model
{
  	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'pedidoc2';

	public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['pedidoc2_cantidad', 'pedidoc2_precio_venta','pedidoc2_descuento_porcentaje','pedidoc2_descuento_valor'];
    
	public function isValid($data)
	{
		$rules = [
			'pedidoc2_cantidad' => 'required|numeric|min:1',
			'pedidoc2_precio_venta' => 'required|numeric|min:1',
			'pedidoc2_descuento_porcentaje' => 'numeric|min:1|required',
			'pedidoc2_descuento_valor' => 'required|numeric|min:1'
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}
}
