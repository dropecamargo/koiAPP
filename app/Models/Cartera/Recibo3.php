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

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    // protected $fillable = ['recibo2_naturaleza', 'recibo2_conceptosrc','recibo2_documentos_doc'];

    /**
     * The attributes that are mass nullable fields to null.
     *
     * @var array
     */
    // protected $nullable = ['recibo2_documentos_doc','recibo2_id_doc'];
	
	public function isValid($data)
	{
		$rules = [];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
    		
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}
}
