<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;
use Cache, Validator;

class MedioPago extends BaseModel
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'mediopago';

	public $timestamps = false;

	/**
     * The key used by cache store.
     *
     * @var static string
     */
    public static $key_cache = '_mediopagos';

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['mediopago_nombre'];

    protected $boolean = ['mediopago_activo'];

	public function isValid($data)
	{
		$rules = [
			'mediopago_nombre' => 'required|max:25',
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}	
}
