<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use App\Models\Base\Tercero, App\Models\Contabilidad\Documento, App\Models\Contabilidad\PlanCuenta;
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
    /**
    * Function for reportes history client in cartera
    */
	public static function historyClientReport(Tercero $tercero, Array $historyClient, $i )
	{
        $response = new \stdClass();
        $response->success = false;
        $response->recibo = [];
        $response->position = 0;

        $query = Recibo1::query();
        $query->select('recibo1.*', 'docafecta.documentos_nombre as docafecta',  'docafecta.documentos_codigo as afectaCode', 'documento.documentos_nombre as documento', 'recibo2_id_doc', 'recibo2_naturaleza', 'recibo2_valor', 'sucursal_nombre');
        $query->where('recibo1_tercero', $tercero->id);
        $query->join('recibo2', 'recibo1.id', '=', 'recibo2_recibo1');
        $query->join('sucursal', 'recibo1_sucursal', '=', 'sucursal.id');
        $query->join('documentos as documento', 'recibo1_documentos', '=', 'documento.id');
        $query->join('documentos as docafecta', 'recibo2_documentos_doc', '=', 'docafecta.id');
        $recibo = $query->get();


        foreach ($recibo as $value) {
            $reciboItem = [];
            if ($value->afectaCode == 'FACT') {
                $query = Recibo2::select('factura1_numero', 'factura3_cuota');
                $query->leftJoin('factura3','recibo2_id_doc', '=', 'factura3.id');
                $query->leftJoin('factura1','factura3_factura1', '=', 'factura1.id');
                $query->where('factura3.id', $value->recibo2_id_doc);
                $reciboItem = $query->first();
            }
        	$historyClient[$i]['documento'] = $value->documento;
        	$historyClient[$i]['numero'] = $value->recibo1_numero;
        	$historyClient[$i]['sucursal'] = $value->sucursal_nombre;
        	$historyClient[$i]['docafecta'] = empty($reciboItem) ? '-' : $value->docafecta;
        	$historyClient[$i]['id_docafecta'] = empty($reciboItem) ? '-' : $reciboItem->factura1_numero;
        	$historyClient[$i]['cuota'] = empty($reciboItem) ? '-' : $reciboItem->factura3_cuota;
        	$historyClient[$i]['naturaleza'] = $value->recibo2_naturaleza;
        	$historyClient[$i]['valor'] = $value->recibo2_valor;
            $historyClient[$i]['fecha'] = $value->recibo1_fecha;
        	$historyClient[$i]['elaboro_fh'] = $value->recibo1_fh_elaboro;
            $historyClient[$i]['afectaCode'] = $value->afectaCode;
        	$i++;
        }
        $response->recibo = $historyClient;
        $response->position = $i;
        return $response;
	}
	/**
	* Prepara el detalle del asiento , cuentas (Credito , Debito)
	*/
	public function detalleAsiento(Recibo2 $detalle, Tercero $tercero, Conceptosrc $concepto)
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
		$cuenta['Naturaleza'] = $detalle->recibo2_naturaleza;
		$cuenta['Base'] = 0;
		$cuenta['Credito'] = ($detalle->recibo2_naturaleza == 'C') ? $detalle->recibo2_valor : 0;
		$cuenta['Debito'] = ($detalle->recibo2_naturaleza == 'D') ? $detalle->recibo2_valor : 0;
		$cuenta['Orden'] = '';

		return $cuenta;
	}
	/**
	* Prepara el asiento 1 y hace el cuadre de credido y debito con la cuenta bancaria(Plan cuentas) del recibo
	*/
	public function encabezadoAsiento(Tercero $tercero, CuentaBanco $cuentaBanco, $credito, $debito)
	{
		$object = new \stdClass();
		$object->data = [];
		$object->dataNif = [];
		$object->cuenta = [];

		// Recuperar documento contable
		$documento = Documento::where('documento_codigo', 'RC')->first();
		if(!$documento instanceof Documento){
			$object->error = "No es posible recuperar el prefijo $codigo en los documentos contables.";
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
