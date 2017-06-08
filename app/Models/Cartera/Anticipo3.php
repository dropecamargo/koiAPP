<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;

use Validator;

class Anticipo3 extends Model
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'anticipo3';

	public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['anticipo3_naturaleza', 'anticipo3_valor'];
	
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
