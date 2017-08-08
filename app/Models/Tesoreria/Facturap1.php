<?php

namespace App\Models\Tesoreria;

use Illuminate\Database\Eloquent\Model;
use Validator, DB;

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
    * The default facturap if documentos.
    *
    * @var static string
    */

    public static $default_document = 'FPRO';

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['facturap1_fecha','facturap1_vencimiento','facturap1_factura','facturap1_primerpago','facturap1_subtotal','facturap1_descuento','facturap1_impuestos', 'facturap1_retenciones','facturap1_apagar','facturap1_cuotas', 'facturap1_observaciones'];


    public function isValid($data)
    {
        $rules = [
            'facturap1_fecha' => 'required|date',
            'facturap1_vencimiento' => 'required|date',
            'facturap1_factura' => 'max:20',
            'facturap1_primerpago' => 'date',
            'facturap1_subtotal' => 'required|numeric',
            'facturap1_descuento' => 'required|numeric',
            'facturap1_cuotas' => 'required|numeric',
            'facturap1_retenciones' => 'numeric',
            'facturap1_tipogasto' => 'required',
            'facturap1_tipoproveedor' => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            // Validar Carrito
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getFacturap ($id) {
        $facturap1 = Facturap1::query();
        $facturap1->select('facturap1.*', DB::raw("(CASE WHEN tercero_persona = 'N' THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2, (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END) )  ELSE tercero_razonsocial END) AS tercero_nombre"), 'tercero_nit','tercero_persona','tipogasto_nombre', 'tipoproveedor_nombre', 'regional_nombre');

        $facturap1->join('tercero', 'facturap1_tercero', '=', 'tercero.id');
        $facturap1->join('tipogasto', 'facturap1_tipogasto', '=', 'tipogasto.id');
        $facturap1->join('tipoproveedor', 'facturap1_tipoproveedor', '=', 'tipoproveedor.id');
        $facturap1->join('regional', 'facturap1_regional', '=', 'regional.id');
        $facturap1->where('facturap1.id', $id);
        return $facturap1->first();
    }
}
