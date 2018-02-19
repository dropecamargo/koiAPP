<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;
use Validator;

class AutorizaCa extends Model
{
   	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'autorizaca';

	public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['autorizaca_vencimiento','autorizaca_plazo','autorizaca_cupo','autorizaca_observaciones'];

	public function isValid($data)
	{
		$rules = [
		    'autorizaca_vencimiento' => 'required|date',
		    'autorizaca_plazo' => 'required|numeric',
		    'autorizaca_cupo' => 'required|numeric'
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}
}
