<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;

use App\Models\Base\Tercero, App\Models\Contabilidad\PlanCuenta, App\Models\Contabilidad\Documento;
use Validator, DB;

class Ajuste1 extends Model
{
   /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'ajuste1';

	public $timestamps = false;

	 /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['ajuste1_fecha','ajuste1_observaciones'];

	/**
	* The default ajuste if documentos.
	*
	* @var static string
	*/

	public static $default_document = 'AJUS';

	public function isValid($data)
	{
		$rules = [
		    'ajuste1_fecha' => 'required|date',
		    'ajuste1_numero' => 'required|numeric'
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            // Validar Carrito
            $ajuste2 = isset($data['ajuste2']) ? $data['ajuste2'] : null;
            if(!isset($ajuste2) || $ajuste2 == null || !is_array($ajuste2) || count($ajuste2) == 0) {
                $this->errors = 'Por favor ingrese el detalle para realizar el ajuste.';
                return false;
            }
            return true;
        }

		$this->errors = $validator->errors();
		return false;
	}
	public static function getAjuste($id)
	{
		$query = Ajuste1::query();
		$query->select('ajuste1.*','tipoajuste_nombre','tipoajuste_tipo','sucursal_nombre','tercero_nit',DB::raw("CONCAT(tercero_nombre1, ' ', tercero_nombre2, ' ', tercero_apellido1, ' ', tercero_apellido2) as tercero_nombre"), 'documentos_nombre');
		$query->join('tipoajuste','ajuste1_tipoajuste','=','tipoajuste.id');
		$query->join('sucursal','ajuste1_sucursal','=', 'sucursal.id');
		$query->join('documentos','ajuste1_documentos','=', 'documentos.id');
		$query->join('tercero','ajuste1_usuario_elaboro','=', 'tercero.id');
		$query->where('ajuste1.id',$id);
		return $query->first();
	}

	/**
	* Prepara el detalle del asiento , cuentas (Credito , Debito)
	*/
	public function detalleAsiento($naturaleza, $idCuenta, $valor)
	{
		$planCuenta = PlanCuenta::find($idCuenta);
		if (!$planCuenta instanceof PlanCuenta) {
			return "Error al recuperar cuenta en la preparacion del asiento";
		}
		$tercero = Tercero::find(session('empresa')->empresa_tercero);
		if(!$tercero instanceof Tercero){
			return "No es posible recuperar tercero para el asiento ";
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
		$cuenta['Credito'] = ($naturaleza == 'C') ? $valor : 0;
		$cuenta['Debito'] = ($naturaleza == 'D') ? $valor : 0;
		$cuenta['Orden'] = '';

		return $cuenta;
	}

	/**
	* Prepara el asiento 1
	*/
	public function encabezadoAsiento()
	{
		$object = new \stdClass();
		$object->data = [];
		$object->dataNif = [];

		// Recuperar documento contable
		$documento = Documento::where('documento_codigo', 'AJ')->first();
		if(!$documento instanceof Documento){
			return "No es posible recuperar el prefijo AJ en los documentos contables.";
		}
		$tercero = Tercero::find(session('empresa')->empresa_tercero);
		if(!$tercero instanceof Tercero){
			return "No es posible recuperar tercero para el asiento ";
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
