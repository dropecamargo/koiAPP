<?php

namespace App\Models\Tecnico;

use Illuminate\Database\Eloquent\Model;

use Validator, DB;

class GestionTecnico extends Model
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'gestiontecnico';

	public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['gestiontecnico_observaciones'];

	public function isValid($data)
	{
		$rules = [
		    'gestiontecnico_conceptotec' => 'required|numeric',
		    'gestiontecnico_tercero' => 'required',
		    'gestiontecnico_tecnico' => 'required'
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            return true;
        }

		$this->errors = $validator->errors();
		return false;
	}

	public static function getGestionTecnico($id)
	{
		$query = GestionTecnico::query();
		$query->select('gestiontecnico.*','conceptotec_nombre','c.tercero_nit as cliente_nit', 't.tercero_nit as tecnico_nit',DB::raw("CONCAT(c.tercero_nombre1, ' ', c.tercero_nombre2, ' ', c.tercero_apellido1, ' ', c.tercero_apellido2) as tercero_nombre"),DB::raw("CONCAT(t.tercero_nombre1, ' ', t.tercero_nombre2, ' ', t.tercero_apellido1, ' ', t.tercero_apellido2) as tecnico_nombre"));
		$query->join('tercero as c', 'gestiontecnico_tercero','=', 'c.id');
		$query->join('tercero as t', 'gestiontecnico_tecnico','=', 't.id');
		$query->join('conceptotec', 'gestiontecnico_conceptotec','=', 'conceptotec.id');
		$query->where('gestiontecnico.id', $id);
		return $query->first();

	}
}
