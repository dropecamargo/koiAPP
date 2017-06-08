<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;
use App\Models\Cartera\Recibo1;
use DB, Validator;

class Recibo1 extends BaseModel
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'recibo1';

	public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['recibo1_numero', 'recibo1_fecha', 'recibo1_fecha_pago', 'recibo1_valor', 'recibo1_observaciones'];

    public static $default_document = 'RECI';

	public function isValid($data)
	{
		$rules = [
			'recibo1_sucursal' => 'required',
			'recibo1_fecha_pago' => 'required',
			'recibo1_tercero' => 'required',
			'recibo1_cuentas' => 'required',
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            // Validar Carrito
            $recibo2 = isset($data['recibo2']) ? $data['recibo2'] : null;
            if(!isset($recibo2) || $recibo2 == null || !is_array($recibo2) || count($recibo2) == 0) {
                $this->errors = 'Por favor ingrese el concepto para realizar el recibo.';
                return false;
            }
            $recibo3 = isset($data['recibo3']) ? $data['recibo3'] : null;
            if(!isset($recibo3) || $recibo3 == null || !is_array($recibo3) || count($recibo3) == 0) {
                $this->errors = 'Por favor ingrese el medio de pago para realizar el recibo.';
                return false;
            }
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}

	public static function getRecibo($id){
		$query = Recibo1::query();
		$query->select('recibo1.*','sucursal_nombre','cuentabanco_nombre',DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            );
		$query->join('tercero', 'recibo1_tercero', '=', 'tercero.id');
		$query->join('sucursal', 'recibo1_sucursal', '=', 'sucursal.id');
		$query->join('cuentabanco', 'recibo1_cuentas', '=', 'cuentabanco.id');
		$query->where('recibo1.id', $id);
        return $query->first();
	}
}
