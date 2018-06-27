<?php

namespace App\Models\Tesoreria;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base\Tercero, App\Models\Contabilidad\PlanCuenta, App\Models\Contabilidad\CentroCosto, App\Models\Contabilidad\Documento, App\Models\Cartera\CuentaBanco;
use Validator, DB;

class CajaMenor1 extends Model
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'cajamenor1';

	public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['cajamenor1_observaciones', 'cajamenor1_fecha', 'cajamenor1_fondo', 'cajamenor1_efectivo', 'cajamenor1_provisionales', 'cajamenor1_reembolso'];

    public static $default_document = 'CM';

    public function isValid($data)
	{
		$rules = [
			'cajamenor1_regional' => 'required',
			'cajamenor1_numero' => 'required',
			'cajamenor1_tercero' => 'required',
			'cajamenor1_cuentabanco' => 'required',
			'cajamenor1_fondo' => 'required'
			// 'cajamenor1_efectivo' => 'required',
			// 'cajamenor1_provisionales' => 'required',
			// 'cajamenor1_reembolso' => 'required'
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}

	public static function getCajaMenor($id){
		$query = CajaMenor1::query();
		$query->select('cajamenor1.*','regional_nombre','documentos_nombre', 'cuentabanco_nombre', 't.tercero_nit as tercero_nit', DB::raw("(CASE WHEN t.tercero_persona = 'N'
					THEN CONCAT(t.tercero_nombre1,' ',t.tercero_nombre2,' ',t.tercero_apellido1,' ',t.tercero_apellido2,
							(CASE WHEN (t.tercero_razonsocial IS NOT NULL AND t.tercero_razonsocial != '') THEN CONCAT(' - ', t.tercero_razonsocial) ELSE '' END)
						)
					ELSE t.tercero_razonsocial END)
				AS tercero_nombre, CONCAT(elab.tercero_nombre1, ' ', elab.tercero_nombre2, ' ', elab.tercero_apellido1, ' ', elab.tercero_apellido2) as elaboro_nombre")
			);
		$query->join('cuentabanco','cajamenor1_cuentabanco','=','cuentabanco.id');
		$query->join('regional','cajamenor1_regional','=','regional.id');
		$query->join('tercero as t', 'cajamenor1_tercero', '=', 't.id');
		$query->join('tercero as elab', 'cajamenor1_usuario_elaboro', '=', 'elab.id');
		$query->join('documentos','cajamenor1_documentos','=','documentos.id');
		$query->where('cajamenor1.id', $id);
		return $query->first();
	}
	/**
	* Prepara el detalle del asiento , cuentas (Credito , Debito)
	*/
	public function detalleAsiento(CajaMenor2 $detalle, Tercero $tercero, PlanCuenta $planCuenta, CentroCosto $centroCosto)
	{
		$cuenta = [];
		$cuenta['Cuenta'] = $planCuenta->plancuentas_cuenta;
		$cuenta['Cuenta_Nombre'] = $planCuenta->plancuentas_nombre;
		$cuenta['Tercero'] = $tercero->tercero_nit;
		$cuenta['CentroCosto'] = $centroCosto->id;
		$cuenta['CentroCosto_Nombre'] = '';
		$cuenta['Detalle'] = '';
		$cuenta['Naturaleza'] = 'D';
		$cuenta['Base'] = 0;
		$cuenta['Credito'] = 0;
		$cuenta['Debito'] = $detalle->cajamenor2_subtotal + $detalle->cajamenor2_iva - ($detalle->cajamenor2_retefuente + $detalle->cajamenor2_reteica + $detalle->cajamenor2_reteiva);
		$cuenta['Orden'] = '';

		return $cuenta;
	}
	/**
	* Prepara el asiento 1 y hace el cuadre de credido y debito con la cuenta bancaria(Plan cuentas) del recibo
	*/
	public function encabezadoAsiento(Tercero $tercero, CuentaBanco $cuentaBanco)
	{
		$object = new \stdClass();
		$object->data = [];
		$object->dataNif = [];
		$object->cuenta = [];

		// Recuperar documento contable
		$documento = Documento::where('documento_codigo', 'RE')->first();
		if(!$documento instanceof Documento){
			$object->error = "No es posible recuperar el prefijo 'RE' en los documentos contables.";
			return $object;
		}

		// Plan de cuentas
		$planCuenta = PlanCuenta::find($cuentaBanco->cuentabanco_cuenta);
		if (!$planCuenta instanceof PlanCuenta) {
			return "Error al recuperar plan de cuenta en Cuenta de banco";
		}

		// Cuadre entre debito y credito para el asiento
		$cuadre = [];
		$cuadre['Cuenta'] = $planCuenta->plancuentas_cuenta;
		$cuadre['Cuenta_Nombre'] = $planCuenta->plancuentas_nombre;
		$cuadre['Tercero'] = $tercero->tercero_nit;
		$cuadre['CentroCosto'] = '';
		$cuadre['CentroCosto_Nombre'] = '';
		$cuadre['Detalle'] = '';
		$cuadre['Naturaleza'] = 'C';
		$cuadre['Base'] = 0;
		$cuadre['Credito'] = $this->cajamenor1_reembolso;
		$cuadre['Debito'] = 0;
		$cuadre['Orden'] = '';
		$object->cuenta = $cuadre;
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
