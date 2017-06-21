<?php

namespace App\Models\Comercial;

use Illuminate\Database\Eloquent\Model;

use Validator, DB;

class GestionComercial extends Model
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'gestioncomercial';

	public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['gestioncomercial_observaciones'];

	public function isValid($data)
	{
		$rules = [
		    'gestioncomercial_conceptocom' => 'required|numeric',
		    'gestioncomercial_tercero' => 'required'
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            return true;
        }

		$this->errors = $validator->errors();
		return false;
	}

	public static function getGestionComercial($id){
		$query = GestionComercial::query();
		$query->select('gestioncomercial.*','conceptocom_nombre','c.tercero_nit as cliente_nit', 'v.tercero_nit as vendedor_nit',DB::raw("CONCAT(c.tercero_nombre1, ' ', c.tercero_nombre2, ' ', c.tercero_apellido1, ' ', c.tercero_apellido2) as tercero_nombre"),DB::raw("CONCAT(v.tercero_nombre1, ' ', v.tercero_nombre2, ' ', v.tercero_apellido1, ' ', v.tercero_apellido2) as vendedor_nombre"));
		$query->join('tercero as c', 'gestioncomercial_tercero','=', 'c.id');
		$query->join('tercero as v', 'gestioncomercial_vendedor','=', 'v.id');
		$query->join('conceptocom', 'gestioncomercial_conceptocom','=', 'conceptocom.id');
		$query->where('gestioncomercial.id', $id);
		return $query->first();

	}
}
