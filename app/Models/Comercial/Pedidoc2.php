<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

class Pedidoc2 extends Model
{
  	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'pedidoc2';

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
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}
}
