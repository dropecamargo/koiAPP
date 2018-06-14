<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;

use App\Models\Base\Tercero, App\Models\Contabilidad\Documento, App\Models\Contabilidad\PlanCuenta;
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
		$query->select('anticipo1.*','sucursal_nombre','cuentabanco_nombre','t.tercero_nit','v.tercero_nit as vendedor_nit',DB::raw("(CASE WHEN t.tercero_persona = 'N'
                    THEN CONCAT(t.tercero_nombre1,' ',t.tercero_nombre2,' ',t.tercero_apellido1,' ',t.tercero_apellido2,
                            (CASE WHEN (t.tercero_razonsocial IS NOT NULL AND t.tercero_razonsocial != '') THEN CONCAT(' - ', t.tercero_razonsocial) ELSE '' END)
                        )
                    ELSE t.tercero_razonsocial END)
                AS tercero_nombre") ,DB::raw("CONCAT(v.tercero_nombre1, ' ', v.tercero_nombre2, ' ', v.tercero_apellido1, ' ', v.tercero_apellido2) as vendedor_nombre"));
		$query->join('sucursal','anticipo1.anticipo1_sucursal','=', 'sucursal.id');
		$query->join('tercero as t','anticipo1.anticipo1_tercero','=', 't.id');
		$query->join('tercero as v','anticipo1.anticipo1_vendedor','=', 'v.id');
		$query->join('cuentabanco','anticipo1.anticipo1_cuentas','=', 'cuentabanco.id');
		$query->where('anticipo1.id',$id);
		return $query->first();
	}
    /**
    * Function for reportes history client in cartera
    */
	public static function historyClientReport(Tercero $tercero, Array $historyClient, $i)
	{
        $response = new \stdClass();
        $response->success = false;
        $response->anticipo = [];
        $response->position = 0;

        $query = Anticipo1::query();
        $query->select('anticipo1.*', 'sucursal_nombre', 'documentos_nombre');
	    $query->join('sucursal', 'anticipo1_sucursal', '=', 'sucursal.id');
        $query->join('documentos', 'anticipo1_documentos', '=', 'documentos.id');
        $query->where('anticipo1_tercero', $tercero->id);
        $anticipo = $query->get();

        foreach ($anticipo as $value) {
        	$historyClient[$i]['documento'] = $value->documentos_nombre;
        	$historyClient[$i]['numero'] = $value->anticipo1_numero;
        	$historyClient[$i]['sucursal'] = $value->sucursal_nombre;
        	$historyClient[$i]['docafecta'] = $value->documentos_nombre;
        	$historyClient[$i]['id_docafecta'] = $value->anticipo1_numero;
        	$historyClient[$i]['cuota'] = 0;
        	$historyClient[$i]['naturaleza'] = 'D';
        	$historyClient[$i]['valor'] = $value->anticipo1_valor;
            $historyClient[$i]['fecha'] = $value->anticipo1_fecha;
        	$historyClient[$i]['elaboro_fh'] = $value->anticipo1_fh_elaboro;
        	$i++;
        }

        $response->anticipo = $historyClient;
        $response->position = $i;
        return $response;
	}

	/**
	* Prepara el detalle del asiento , cuentas (Credito , Debito)
	*/
	public function detalleAsiento(Anticipo3 $detalle, Tercero $tercero, Conceptosrc $concepto)
	{
		// Plan de cuentas
		$planCuenta = PlanCuenta::find($concepto->conceptosrc_cuenta);
		if (!$planCuenta instanceof PlanCuenta) {
			return "Error al recuperar cuenta en Concepto de recibo";
		}

		$cuenta = [];
		$cuenta['Cuenta'] = $planCuenta->plancuentas_cuenta;
		$cuenta['Cuenta_Nombre'] = $planCuenta->plancuentas_nombre;
		$cuenta['Tercero'] = $tercero->tercero_nit;
		$cuenta['CentroCosto'] = '';
		$cuenta['CentroCosto_Nombre'] = '';
		$cuenta['Detalle'] = '';
		$cuenta['Naturaleza'] = $detalle->anticipo3_naturaleza;
		$cuenta['Base'] = 0;
		$cuenta['Credito'] = ($detalle->anticipo3_naturaleza == 'C') ? $detalle->anticipo3_valor : 0;
		$cuenta['Debito'] = ($detalle->anticipo3_naturaleza == 'D') ? $detalle->anticipo3_valor : 0;
		$cuenta['Orden'] = '';

		return $cuenta;
	}
	/**
	* Prepara el asiento 1 y hace el cuadre de credito y debito con la cuenta bancaria(Plan cuentas) del anticicpo
	*/
	public function encabezadoAsiento(Tercero $tercero, CuentaBanco $cuentaBanco, $credito, $debito)
	{
		$object = new \stdClass();
		$object->data = [];
		$object->dataNif = [];
		$object->cuenta = [];

		// Recuperar documento contable
		$documento = Documento::where('documento_codigo', 'ANTC')->first();
		if(!$documento instanceof Documento){
			$object->error = "No es posible recuperar el prefijo ANTC en los documentos contables.";
			return $object;
		}


		// Cuadre entre debito y credito para el asiento
		if ($credito != $debito) {
			// Plan de cuentas
			$planCuenta = PlanCuenta::find($cuentaBanco->cuentabanco_cuenta);
			if (!$planCuenta instanceof PlanCuenta) {
				return "Error al recuperar plan de cuenta en Cuenta de banco";
			}
			$cuadre = [];
			$cuadre['Cuenta'] = $planCuenta->plancuentas_cuenta;
			$cuadre['Cuenta_Nombre'] = $planCuenta->plancuentas_nombre;
			$cuadre['Tercero'] = $tercero->tercero_nit;
			$cuadre['CentroCosto'] = '';
			$cuadre['CentroCosto_Nombre'] = '';
			$cuadre['Detalle'] = '';
			$cuadre['Naturaleza'] = ($credito > $debito) ? 'D' : 'C';
			$cuadre['Base'] = 0;
			$cuadre['Credito'] = ($debito > $credito) ? $debito - $credito : 0;
			$cuadre['Debito'] = ($credito > $debito) ? $credito - $debito  : 0;
			$cuadre['Orden'] = '';
			$object->cuenta = $cuadre;
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
