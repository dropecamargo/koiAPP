<?php

namespace App\Models\Tesoreria;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;
use Validator;

class Ajustep2 extends BaseModel
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'ajustep2';

	public $timestamps = false;

    /**
     * The attributes that are mass nullable fields to null.
     *
     * @var array
     */
    protected $nullable = ['ajustep2_id_doc'];

	public function isValid($data)
	{
		$rules = [
			'ajustep2_tercero' => 'required',
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}
}
