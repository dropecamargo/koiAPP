<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;
use Validator;

class AutorizaComercial extends Model
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'autorizaco';

	public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['autorizaco_vencimiento','autorizaco_observaciones'];

	public function isValid($data)
	{
		$rules = [
			'autorizaco_vencimiento' => 'required|date'
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}
}
