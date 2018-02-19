<?php

namespace App\Models\Tesoreria;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Facturap4 extends Model
{
   	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'facturap4';

	public $timestamps = false;

	// Validate data
    public function isValid($data)
    {
        $rules = [
        	'facturap4_centrocosto' => 'required|numeric'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    // Get attributes de facturap4 in facturap1
    public function getFacturap4 ($id) {
    	return $this->hasMany('App\Models\Facturap1', 'id', 'facturap4_facturap1')->where('facturap4_facturap1', $id)->get();
    }
}
