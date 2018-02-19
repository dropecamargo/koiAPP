<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;
use Validator,DB;

class Devolucion1 extends Model
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'devolucion1';

	public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    public static $default_document = 'DEVO';


	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['devolucion1_observaciones','devolucion1_fecha'];

	public function isValid($data)
	{
		$rules = [
		    'devolucion1_numero' => 'required|numeric'
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            return true;
        }

		$this->errors = $validator->errors();
		return false;
	}

	public static function getDevolucion($id)
	{
		$query = Devolucion1::query();
		$query->select('devolucion1.*','sucursal_nombre','tercero_nit',DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre"));
		$query->join('sucursal','devolucion1.devolucion1_sucursal','=', 'sucursal.id');
		$query->join('tercero','devolucion1.devolucion1_tercero','=', 'tercero.id');
		$query->where('devolucion1.id',$id);
		return $query->first();
	}

}
