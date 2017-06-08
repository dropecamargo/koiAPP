<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;
use Validator;

class Anticipo2 extends BaseModel
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'anticipo2';

	public $timestamps = false;

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
