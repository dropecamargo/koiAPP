<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;

use Validator, DB;

class GestionCobro extends Model
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'gestioncobro';

	public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['gestioncobro_observaciones'];

	public function isValid($data)
	{
		$rules = [
		    'gestioncobro_conceptocob' => 'required|numeric',
		    'gestioncobro_tercero' => 'required'
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            return true;
        }

		$this->errors = $validator->errors();
		return false;
	}

	public static function getGestionCobro($id){
		$query = GestionCobro::query();
		$query->select('gestioncobro.*','conceptocob_nombre','tercero_nit',DB::raw("CONCAT(tercero_nombre1, ' ', tercero_nombre2, ' ', tercero_apellido1, ' ', tercero_apellido2) as tercero_nombre"));
		$query->join('tercero', 'gestioncobro_tercero','=', 'tercero.id');
		$query->join('conceptocob', 'gestioncobro_conceptocob','=', 'conceptocob.id');
		$query->where('gestioncobro.id', $id);
		return $query->first();

	}
}
