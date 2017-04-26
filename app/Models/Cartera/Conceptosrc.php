<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;
use Validator;

class Conceptosrc extends BaseModel
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'conceptosrc';

	public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['conceptosrc_nombre'];

    protected $boolean = ['conceptosrc_activo'];

	public function isValid($data)
	{
		$rules = [
			'conceptosrc_nombre' => 'required|max:25',
			'conceptosrc_plancuentas' => 'required',
			'conceptosrc_documentos' => 'required',
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}

	public static function getConceptosrc($id)
	{
		$query = Conceptosrc::query();
		$query->select('conceptosrc.*', 'plancuentas_nombre', 'plancuentas_cuenta', 'documentos_nombre');
		$query->join('plancuentas', 'conceptosrc_plancuentas', '=', 'plancuentas.id');
		$query->join('documentos', 'conceptosrc_documentos', '=', 'documentos.id');
		$query->where('conceptosrc.id', $id);
		return $query->first();
	}
}
