<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;

use Validator,DB;

class Anticipo1 extends Model
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'anticipo1';

	public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['anticipo1_fecha', 'anticipo1_observaciones'];

    public static $default_document = 'ANTI';

	public function isValid($data)
	{
		$rules = [
			'anticipo1_cuentas' => 'required|numeric',
			'anticipo1_numero' => 'required|numeric',
			'anticipo1_sucursal' => 'required|numeric',
			'anticipo1_vendedor' => 'required|numeric',
			'anticipo1_tercero' => 'required',
			'anticipo1_valor' => 'required',
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            // Validar Carrito
            $anticipo2 = isset($data['anticipo2']) ? $data['anticipo2'] : null;
            if(!isset($anticipo2) || $anticipo2 == null || !is_array($anticipo2) || count($anticipo2) == 0) {
                $this->errors = 'Por favor ingrese el detalle para realizar el anticipo de forma correcta.';
                return false;
            }
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}
	public static function getAnticipo($id)
	{
		$query = Anticipo1::query();
		$query->select('anticipo1.*','sucursal_nombre','cuentabanco_nombre','t.tercero_nit','v.tercero_nit as vendedor_nit',DB::raw("CONCAT(t.tercero_nombre1, ' ', t.tercero_nombre2, ' ', t.tercero_apellido1, ' ', t.tercero_apellido2) as tercero_nombre") ,DB::raw("CONCAT(v.tercero_nombre1, ' ', v.tercero_nombre2, ' ', v.tercero_apellido1, ' ', v.tercero_apellido2) as vendedor_nombre"));
		$query->join('sucursal','anticipo1.anticipo1_sucursal','=', 'sucursal.id');
		$query->join('tercero as t','anticipo1.anticipo1_tercero','=', 't.id');
		$query->join('tercero as v','anticipo1.anticipo1_vendedor','=', 'v.id');
		$query->join('cuentabanco','anticipo1.anticipo1_cuentas','=', 'cuentabanco.id');
		$query->where('anticipo1.id',$id);
		return $query->first();
	}

}
