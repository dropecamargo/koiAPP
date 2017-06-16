<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;
use Validator;

class ChposFechado2 extends Model
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'chposfechado2';

	public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['chposfechado2_conceptosrc','chposfechado2_documentos_doc'];

	public function isValid($data)
	{
		$rules = ['chposfechado2_conceptosrc' => 'required|numeric'];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}
}
