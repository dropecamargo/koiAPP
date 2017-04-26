<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;
use Validator;

class Pedidoc1 extends BaseModel
{
  	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'pedidoc1';

	public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['pedidoc1_numero', 'pedidoc1_fecha'];

    protected $boolean = [];

	public function isValid($data)
	{
		$rules = [
			'pedidoc1_numero' => 'required|numeric',
			'pedidoc1_fecha' => 'required|date'
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}
}
