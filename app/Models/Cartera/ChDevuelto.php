<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;
use Validator;

class ChDevuelto extends Model
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'chdevuelto';

	public $timestamps = false;

    public static $default_document = 'CHD';

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = [];

	public function isValid($data)
	{
		$rules = [
			'chdevuelto_causal' => 'required|numeric'
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}
}
