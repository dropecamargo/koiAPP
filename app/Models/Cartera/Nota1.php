<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;
use Validator;

class Nota1 extends BaseModel
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'nota1';

	public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['nota1_numero', 'nota1_fecha', 'nota1_observaciones'];

    public function isValid($data)
	{
		$rules = [
			'nota1_fecha' => 'date',
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            // Validar Carrito
            $nota2 = isset($data['nota2']) ? $data['nota2'] : null;
            if(!isset($nota2) || $nota2 == null || !is_array($nota2) || count($nota2) == 0) {
                $this->errors = 'Por favor ingrese el detalle para realizar la nota.';
                return false;
            }
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}
}
