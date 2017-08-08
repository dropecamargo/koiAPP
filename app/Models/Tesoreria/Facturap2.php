<?php

namespace App\Models\Tesoreria;

use Illuminate\Database\Eloquent\Model;
use Validator, DB;

class Facturap2 extends Model
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
    protected $table = 'facturap2';

    public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = [];


    public function isValid($data)
    {
        $rules = [
            'facturap2_base_impuesto' => 'numeric',
        	'facturap2_base_retefuente' => 'numeric'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            $base = isset($data['facturap2_base_impuesto']) ? $data['facturap2_base_impuesto'] : $data['facturap2_base_retefuente'];
        	if ($base <= 0 ) {
        		$this->errors = 'Valor debe ser mayor a 0';
                return false;
        	}
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getFacturap2 ($id) {
        $facturap2 = Facturap2::query();
        $facturap2->select('facturap2.*', 'impuesto_nombre', 'retefuente_nombre');
        $facturap2->leftJoin('impuesto','facturap2_impuesto', '=', 'impuesto.id');
        $facturap2->leftJoin('retefuente', 'facturap2_retefuente', '=', 'retefuente.id');
        $facturap2->where('facturap2_facturap1', $id);
        return $facturap2->get();
    }

    public function calculateBase (Facturap1 $facturap1 , $porcentaje) {
        $porcentage = ( $porcentaje / 100 ); 
        return $facturap1->facturap1_base * $porcentage;
    }
}
