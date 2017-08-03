<?php

namespace App\Models\Tesoreria;

use Illuminate\Database\Eloquent\Model;
use Validator, Cache;

class Facturap1 extends Model
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
    protected $table = 'facturap1';

    public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['facturap1_fecha','facturap1_vencimiento','facturap1_factura','facturap1_primerpago','facturap1_subtotal','facturap1_descuento','facturap1_base','facturap1_impuestos', 'facturap1_reteniones','facturap1_apagar','facturap1_cuotas'];


    public function isValid($data)
    {
        $rules = [
            'facturap1_fecha' => 'required|date',
            'facturap1_vencimiento' => 'required|date',
            'facturap1_factura' => 'max:20',
            'facturap1_primerpago' => 'date'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
}
