<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;
use App\Models\Base\Tercero, App\Models\Contabilidad\PlanCuenta, App\Models\Contabilidad\Documento;
use Validator,DB;

class Factura1 extends BaseModel
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'factura1';

	public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    public static $default_document = 'FACT';

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['factura1_cuotas','factura1_primerpago','factura1_plazo','factura1_observaciones','factura1_bruto','factura1_descuento','factura1_iva','factura1_retencion','factura1_total', 'factura1_fecha'];


    protected $boolean = ['factura1_anular'];

	public function isValid($data)
	{
		$rules = [
		    'factura1_sucursal' => 'required|numeric',
		    'factura1_numero' => 'required|numeric',
		    'factura1_puntoventa' => 'required|numeric',
			'factura1_cuotas' => 'required|numeric|min:0',
			'factura1_plazo' => 'required|numeric|min:0',
			'factura1_primerpago' => 'required|date',
			'factura1_descuento' => 'numeric',
			'factura1_bruto' => 'numeric',
			'factura1_iva' => 'numeric',
			'factura1_total' => 'numeric'
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            // Validar Carrito
            $factura2 = isset($data['factura2']) ? $data['factura2'] : null;
            if(!isset($factura2) || $factura2 == null || !is_array($factura2) || count($factura2) == 0) {
                $this->errors = 'Por favor ingrese el detalle para realizar la factura2.';
                return false;
            }

            return true;
        }

		$this->errors = $validator->errors();
		return false;
	}
	public static function getFactura($id)
	{
		$query = Factura1::query();
		$query->select('factura1.*','sucursal_nombre','puntoventa_numero','puntoventa_prefijo','puntoventa_resolucion_dian','puntoventa_footer1','puntoventa_footer2','puntoventa_observacion','puntoventa_encabezado','puntoventa_frase','tercero_direccion','tercero_fax', 'tercero_municipio' , DB::raw("CONCAT(municipio_nombre, ' - ', departamento_nombre) as municipio_nombre"), 'tercero_telefono1','tercero_telefono2','tercero_celular','tercero_nit', 'tercero_digito',DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre"));
		$query->join('sucursal','factura1.factura1_sucursal','=', 'sucursal.id');
		$query->join('tercero','factura1.factura1_tercero','=', 'tercero.id');
		$query->join('puntoventa','factura1.factura1_puntoventa','=', 'puntoventa.id');
		$query->leftJoin('municipio','tercero_municipio','=', 'municipio.id');
        $query->leftJoin('departamento', 'municipio.departamento_codigo', '=', 'departamento.departamento_codigo');
		$query->where('factura1.id',$id);
		return $query->first();
	}

	public function validar(){
		// Valido Fecha
		$diferencia =  strtotime('now')-strtotime($this->factura1_fh_elaboro);
		$diferencia_dias = intval((($diferencia/60)/60)/24);
		if ($diferencia_dias > 30) {
			return false;
		}
		// Valido atributos de estos models
		$factura2 = Factura2::where('factura2_factura1', $this->id)->first();
		$factura3 = Factura3::where('factura3_factura1', $this->id)->get();

		if ($factura2->factura2_devueltas > 0) {
			return false;
		}
		// Update saldo factura3
		foreach ($factura3 as $value) {
			if (($value->factura3_valor - $value->factura3_saldo) > 0) {
				return false;
			}
			$value->factura3_saldo = 0;
			$value->save();
		}

		return true;
	}
	/**
	* Function for reportes history client in cartera
	*/
	public static function historyClientReport(Tercero $tercero, Array $historyClient, $i )
	{
     	$response = new \stdClass();
        $response->success = false;
        $response->factura = [];
        $response->position = 0;

        $query = Factura1::query();
        $query->select('factura1.*', 'sucursal_nombre', 'documentos_nombre');
        $query->join('sucursal', 'factura1_sucursal', '=', 'sucursal.id');
        $query->join('documentos', 'factura1_documentos', '=', 'documentos.id');
        $query->where('factura1_tercero', $tercero->id);
        $factura = $query->get();

        foreach ($factura as $value) {
        	$historyClient[$i]['documento'] = $value->documentos_nombre;
        	$historyClient[$i]['numero'] = $value->factura1_numero;
        	$historyClient[$i]['sucursal'] = $value->sucursal_nombre;
        	$historyClient[$i]['docafecta'] = '-';
        	$historyClient[$i]['id_docafecta'] = '-';
        	$historyClient[$i]['cuota'] = '-';
        	$historyClient[$i]['naturaleza'] = 'D'; //Factura siempre es de tipo debito
        	$historyClient[$i]['valor'] = ($value->factura1_bruto + $value->factura1_iva) - $value->factura1_descuento - $value->factura1_retencion;
        	$historyClient[$i]['elaboro_fh'] = $value->factura1_fh_elaboro;
            $historyClient[$i]['fecha'] = $value->factura1_fecha;
        	$historyClient[$i]['afectaCode'] = $value->afectaCode;
        	$i++;
        }

     	$response->factura = $historyClient;
        $response->position = $i;
        return $response;
	}
	/**
	* Prepara el detalle del asiento , cuentas (Credito , Debito)
	*/
	public function asientoCuentas(Tercero $tercero, $idCuenta, $naturaleza, $valor = 0, $base = 0)
	{
		// Plan de cuentas
		$planCuenta = PlanCuenta::find($idCuenta);
		if (!$planCuenta instanceof PlanCuenta) {
			\Log::info($idCuenta);
			return "Error al recuperar cuenta en Concepto de recibo";
		}
		if ($valor == 0) {
			$valor = $this->factura1_total;
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
		$documento = Documento::where('documento_codigo', 'FS')->first();
		if(!$documento instanceof Documento){
			$object->error = "No es posible recuperar el prefijo 'FS' en los documentos contables.";
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
