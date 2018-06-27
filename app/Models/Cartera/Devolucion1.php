<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base\Tercero, App\Models\Contabilidad\PlanCuenta, App\Models\Contabilidad\Documento;
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

	/**
	* Prepara el detalle del asiento , cuentas (Credito , Debito)
	*/
	public function asientoCuentas(Tercero $tercero, $idCuenta, $naturaleza, $valor = 0, $base = 0)
	{
		// Plan de cuentas
		$planCuenta = PlanCuenta::find($idCuenta);
		if (!$planCuenta instanceof PlanCuenta) {
			return "Error al recuperar cuenta en Concepto de recibo";
		}
		if ($valor == 0) {
			$valor = $this->devolucion1_total;
		}
		$cuenta = [];
		$cuenta['Cuenta'] = $planCuenta->plancuentas_cuenta;
		$cuenta['Cuenta_Nombre'] = $planCuenta->plancuentas_nombre;
		$cuenta['Tercero'] = $tercero->tercero_nit;
		$cuenta['CentroCosto'] = '';
		$cuenta['CentroCosto_Nombre'] = '';
		$cuenta['Detalle'] = '';
		$cuenta['Naturaleza'] = $naturaleza;
		$cuenta['Base'] = $base;
		$cuenta['Credito'] = ($naturaleza == 'C') ? $valor : 0;
		$cuenta['Debito'] = ($naturaleza == 'D') ? $valor : 0;
		$cuenta['Orden'] = '';

		return $cuenta;
	}
	/**
	* Prepara el asiento 1
	*/
	public function encabezadoAsiento(Tercero $tercero)
	{
		$object = new \stdClass();
		$object->data = [];
		$object->dataNif = [];

		// Recuperar documento contable
		$documento = Documento::where('documento_codigo', 'DC')->first();
		if(!$documento instanceof Documento){
			$object->error = "No es posible recuperar el prefijo 'DC' en los documentos contables.";
			return $object;
		}

		// Data asiento
		$object->data = [
			'asiento1_mes' => (Int) date('m'),
			'asiento1_ano' => (Int) date('Y'),
			'asiento1_dia' => (Int) date('d'),
			'asiento1_numero' => $documento->documento_consecutivo + 1,
			'asiento1_folder' => $documento->documento_folder,
			'asiento1_documento' => $documento->id,
			'asiento1_documentos' => $documento->documento_codigo,
			'asiento1_id_documentos' => $this->id,
			'asiento1_beneficiario' => $tercero->tercero_nit,
		];

		// Data Asiento Nif
		if ($documento->documento_nif) {
			$object->dataNif = [
				'asienton1_mes' => (Int) date('m'),
				'asienton1_ano' => (Int) date('Y'),
				'asienton1_dia' => (Int) date('d'),
				'asienton1_numero' => $documento->documento_consecutivo + 1,
				'asienton1_folder' => $documento->documento_folder,
				'asienton1_documento' => $documento->id,
				'asienton1_documentos' => $documento->documento_codigo,
				'asienton1_id_documentos' => $this->id,
				'asienton1_beneficiario' => $tercero->tercero_nit,
			];
		}
		return $object;
	}
}
