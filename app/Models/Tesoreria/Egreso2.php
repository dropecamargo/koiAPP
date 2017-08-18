<?php

namespace App\Models\Tesoreria;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator, DB;

class Egreso2 extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'egreso2';

    public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['egreso2_tipopago','egreso2_documentos_doc'];

    /**
     * The attributes that are mass nullable fields to null.
     *
     * @var array
     */
    protected $nullable = ['egreso2_documentos_doc','egreso2_id_doc'];

	public function isValid($data)
	{
		$rules = [
			'egreso2_tipopago' => 'required_if : facturap3_id, null',
			'egreso2_tercero' => 'required'
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {

    		// if(!isset($data['egreso2_factura1'])){
	    	// 	if(empty($data['egreso2_valor'])){
	    	// 		$this->errors = trans('validation.required', ['attribute' => 'valor']);
	     	//            return false;
	    	// 	}
    		// }

            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}
}
