<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Validator;

class Recibo2 extends BaseModel
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'recibo2';

	public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['recibo2_naturaleza', 'recibo2_conceptosrc','recibo2_documentos_doc'];

    /**
     * The attributes that are mass nullable fields to null.
     *
     * @var array
     */
    protected $nullable = ['recibo2_documentos_doc','recibo2_id_doc'];

	public function isValid($data)
	{
		$rules = [];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
    		if(!isset($data['recibo2_factura1'])){
	    		if(empty($data['recibo2_valor'])){
	    			$this->errors = trans('validation.required', ['attribute' => 'valor']);
	                return false;
	    		}

	    		if(empty($data['recibo2_naturaleza'])){
	    			$this->errors = trans('validation.required', ['attribute' => 'naturaleza']);
	                return false;
	    		}
    		}

            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}
}
