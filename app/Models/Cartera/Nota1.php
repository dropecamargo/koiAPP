<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use App\Models\Base\Tercero, App\Models\Contabilidad\Documento, App\Models\Contabilidad\PlanCuenta;
use Validator, DB;

class Nota1 extends BaseModel
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'nota1';

	public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['nota1_numero', 'nota1_fecha', 'nota1_observaciones'];

    public static $default_document = 'NOTA';

    public function isValid($data)
	{
		$rules = [
			'nota1_fecha' => 'date',
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            // Validar Carrito
            $nota2 = isset($data['nota2']) ? $data['nota2'] : null;
            if(!isset($nota2) || $nota2 == null || !is_array($nota2) || count($nota2) == 0) {
                $this->errors = 'Por favor ingrese el detalle para realizar la nota.';
                return false;
            }
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}

	public static function getNota($id){
		$query = Nota1::query();
		$query->select('nota1.*', 'conceptonota_nombre', 'sucursal_nombre', DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            );
		$query->join('sucursal','nota1_sucursal','=','sucursal.id');
		$query->join('tercero','nota1_tercero','=','tercero.id');
		$query->join('conceptonota','nota1_conceptonota','=','conceptonota.id');
		$query->where('nota1.id', $id);
		return $query->first();
	}
    /**
    * Function for reportes history client in cartera
    */
	public static function historyClientReport(Tercero $tercero, Array $historyClient, $i )
	{
        $response = new \stdClass();
        $response->success = false;
        $response->nota = [];
        $response->position = 0;

        $query = Nota1::query();
        $query->select('nota1.*', 'docafecta.documentos_nombre as docafecta', 'docafecta.documentos_codigo as afectaCode', 'documento.documentos_nombre as documento', 'nota2_id_doc', 'nota2_valor', 'sucursal_nombre');
        $query->where('nota1_tercero', $tercero->id);
        $query->join('nota2', 'nota1.id', '=', 'nota2_nota1');
        $query->join('sucursal', 'nota1_sucursal', '=', 'sucursal.id');
        $query->join('documentos as documento', 'nota1_documentos', '=', 'documento.id');
        $query->join('documentos as docafecta', 'nota2_documentos_doc', '=', 'docafecta.id');
        $nota = $query->get();

        foreach ($nota as $value) {
            $notaItem = [];
            if ($value->afectaCode == 'FACT') {
                $query = Nota2::select('factura1_numero', 'factura3_cuota');
                $query->leftJoin('factura3','nota2_id_doc', '=', 'factura3.id');
                $query->leftJoin('factura1','factura3_factura1', '=', 'factura1.id');
                $query->where('factura3.id', $value->nota2_id_doc);
                $notaItem = $query->first();
            }
        	$historyClient[$i]['documento'] = $value->documento;
        	$historyClient[$i]['numero'] = $value->nota1_numero;
        	$historyClient[$i]['sucursal'] = $value->sucursal_nombre;
        	$historyClient[$i]['docafecta'] = empty($notaItem) ? '-' : $value->docafecta;
        	$historyClient[$i]['id_docafecta'] = empty($notaItem) ? '-' : $notaItem->factura1_numero;
        	$historyClient[$i]['cuota'] = empty($notaItem) ? '-' : $notaItem->factura1_cuota;
        	$historyClient[$i]['naturaleza'] ='D';
        	$historyClient[$i]['valor'] = $value->nota2_valor;
            $historyClient[$i]['fecha'] = $value->nota1_fecha;
        	$historyClient[$i]['elaboro_fh'] = $value->nota1_fh_elaboro;
            $historyClient[$i]['afectaCode'] = $value->afectaCode;

        	$i++;
        }
        $response->nota = $historyClient;
        $response->position = $i;
        return $response;
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
		$cuenta['Credito'] = ($naturaleza == 'C') ? $this->nota1_valor : 0;
		$cuenta['Debito'] = ($naturaleza == 'D') ? $this->nota1_valor : 0;
		$cuenta['Orden'] = '';

		return $cuenta;
	}
	/**
	* Prepara el asiento 1 e invoca detalle del asiento(cuentas) para asi prepararlo 
	*/
	public function encabezadoAsiento(Tercero $tercero, ConceptoNota $conceptoNota)
	{
		$object = new \stdClass();
		$object->data = [];
		$object->dataNif = [];
		$object->cuenta = [];

		// Recuperar documento contable
		$documento = Documento::where('documento_codigo', 'NC')->first();
		if(!$documento instanceof Documento){
			return "No es posible recuperar el prefijo NC en los documentos contables.";
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
		$object->cuenta[] = $this->detalleAsiento($tercero, $conceptoNota->conceptonota_cuenta, 'D');
		$object->cuenta[] = $this->detalleAsiento($tercero, session('empresa')->empresa_cuentacartera, 'C');
		return $object;
	}
}
