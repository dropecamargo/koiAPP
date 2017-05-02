<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;
Use Validator;

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
    protected $fillable = ['recibo2_naturaleza', 'recibo2_conceptosrc', 'recibo2_valor','recibo2_documentos_doc','recibo2_id_doc'];

    /**
     * The attributes that are mass nullable fields to null.
     *
     * @var array
     */
    protected $nullable = ['recibo2_documentos_doc','recibo2_id_doc'];
	
	public function isValid($data)
	{
		$rules = [
			'recibo2_conceptosrc' => 'required',
			'recibo2_naturaleza' => 'required',
			'recibo2_valor' => 'required',
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}
}
