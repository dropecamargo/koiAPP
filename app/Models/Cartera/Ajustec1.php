<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;

use App\Models\Base\Tercero, App\Models\Contabilidad\Documento, App\Models\Contabilidad\PlanCuenta;
use Validator, DB;

class Ajustec1 extends Model
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'ajustec1';

	public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['ajustec1_fecha','ajustec1_observaciones'];

    public static $default_document = 'AJUC';

    public function isValid($data)
	{
		$rules = [
			'ajustec1_sucursal' => 'required',
			'ajustec1_numero' => 'required',
			'ajustec1_tercero' => 'required',
			'ajustec1_conceptoajustec' => 'required',
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            // Validar Carrito
            $detalle = isset($data['detalle']) ? $data['detalle'] : null;
            if(!isset($detalle) || $detalle == null || !is_array($detalle) || count($detalle) == 0) {
                $this->errors = 'Por favor ingrese el detalle para realizar el ajuste de cartera.';
                return false;
            }
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}

	public static function getAjustec($id){
		$query = Ajustec1::query();
		$query->select('ajustec1.*','sucursal_nombre','documentos_nombre','conceptoajustec_nombre', DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            );
		$query->join('sucursal','ajustec1_sucursal','=','sucursal.id');
		$query->join('conceptoajustec','ajustec1_conceptoajustec','=','conceptoajustec.id');
		$query->join('tercero','ajustec1_tercero','=','tercero.id');
		$query->join('documentos','ajustec1_documentos','=','documentos.id');
		$query->where('ajustec1.id', $id);
		return $query->first();
	}

	/**
	* Prepara el detalle del asiento , cuentas (Credito , Debito)
	*/
	public function detalleAsiento(Tercero $tercero, $id_cuenta, $naturaleza)
	{
		// Plan de cuentas
		$planCuenta = PlanCuenta::find($id_cuenta);
		if (!$planCuenta instanceof PlanCuenta) {
			return "Error al recuperar cuenta en la preparacion del asiento";
		}

		$cuenta = [];
		$cuenta['Cuenta'] = $planCuenta->plancuentas_cuenta;
		$cuenta['Cuenta_Nombre'] = $planCuenta->plancuentas_nombre;
		$cuenta['Tercero'] = $tercero->tercero_nit;
		$cuenta['CentroCosto'] = '';
		$cuenta['CentroCosto_Nombre'] = '';
		$cuenta['Detalle'] = '';
		$cuenta['Naturaleza'] = $naturaleza;
		$cuenta['Base'] = 0;
		$cuenta['Credito'] = ($naturaleza == 'C') ? $this->ajustec1_valor : 0;
		$cuenta['Debito'] = ($naturaleza == 'D') ? $this->ajustec1_valor : 0;
		$cuenta['Orden'] = '';

		return $cuenta;
	}
	/**
	* Prepara el asiento 1 e invoca detalle del asiento(cuentas) para asi prepararlo
	*/
	public function encabezadoAsiento(Tercero $tercero, ConceptoAjustec $conceptoAjustec)
	{
		$object = new \stdClass();
		$object->data = [];
		$object->dataNif = [];
		$object->cuenta = [];

		// Recuperar documento contable
		$documento = Documento::where('documento_codigo', 'AJUSC')->first();
		if(!$documento instanceof Documento){
			return "No es posible recuperar el prefijo AJUSC en los documentos contables.";
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
		$object->cuenta[] = $this->detalleAsiento($tercero, $conceptoAjustec->conceptoajustec_cuenta, 'D');
		$object->cuenta[] = $this->detalleAsiento($tercero, session('empresa')->empresa_cuentacartera, 'C');
		return $object;
	}
}
