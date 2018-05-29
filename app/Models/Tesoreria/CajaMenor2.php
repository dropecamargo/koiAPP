<?php

namespace App\Models\Tesoreria;

use Illuminate\Database\Eloquent\Model;
use Validator, DB;

class CajaMenor2 extends Model
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'cajamenor2';

	public $timestamps = false;

    /**
     * The attributes that are mass nullable fields to null.
     *
     * @var array
     */

    protected $fillable = [];


	public function isValid($data)
	{
		$rules = [
			'cajamenor2_tercero' => 'required',
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}

	public static function getCajaMenor2 ($id)
	{
		$query = CajaMenor2::query();
		$query->select('cajamenor2.*', 'conceptocajamenor_nombre', 'centrocosto_codigo', 'centrocosto_nombre', 'plancuentas_cuenta', 'plancuentas_nombre', DB::raw("(CASE WHEN tercero_persona = 'N'
				THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
						(CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
					)
				ELSE tercero_razonsocial END)
			AS tercero_nombre")
		);
		$query->join('tercero', 'cajamenor2_tercero', '=', 'tercero.id');
		$query->join('conceptocajamenor', 'cajamenor2_conceptocajamenor', '=', 'conceptocajamenor.id');
		$query->join('centrocosto', 'cajamenor2_centrocosto', '=', 'centrocosto.id');
		$query->join('plancuentas', 'cajamenor2_cuenta', '=', 'plancuentas.id');
		$query->where('cajamenor2_cajamenor1', $id);
		$cajaMenor2 = $query->get();

		return $cajaMenor2;
	}
}
