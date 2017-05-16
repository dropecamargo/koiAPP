<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;
use Validator;

class ConceptoAjustec extends BaseModel
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'conceptoajustec';

	public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['conceptoajustec_nombre'];

    protected $boolean = ['conceptoajustec_activo','conceptoajustec_sumas_iguales'];

	public function isValid($data)
	{
		$rules = [
			'conceptoajustec_nombre' => 'required|max:25',
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}	

	public static function getConcepto($id)
	{
		$query = ConceptoAjustec::query();
		$query->select('conceptoajustec.*', 'plancuentas_nombre', 'plancuentas_cuenta');
		$query->join('plancuentas', 'conceptoajustec_plancuentas', '=', 'plancuentas.id');
		$query->where('conceptoajustec.id', $id);
		$concepto = $query->first();

		return $concepto;
	}
}
