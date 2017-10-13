<?php

namespace App\Models\Tesoreria;

use Illuminate\Database\Eloquent\Model;

use App\Models\Base\Tercero;
use Validator, DB;

class Ajustep1 extends Model
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'ajustep1';

	public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['ajustep1_numero', 'ajustep1_observaciones'];

    public static $default_document = 'AJUP';

    public function isValid($data)
	{
		$rules = [
			'ajustep1_regional' => 'required',
			'ajustep1_numero' => 'required',
			'ajustep1_tercero' => 'required',
			'ajustep1_conceptoajustep' => 'required'
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            // Validar Carrito
            $detalle = isset($data['detalle']) ? $data['detalle'] : null;
            if(!isset($detalle) || $detalle == null || !is_array($detalle) || count($detalle) == 0) {
                $this->errors = 'Por favor ingrese el detalle para realizar el ajuste de proveedor.';
                return false;
            }
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}

	public static function getAjustep($id){
		$query = Ajustep1::query();
		$query->select('ajustep1.*','regional_nombre','documentos_nombre','conceptoajustep_nombre', DB::raw("(CASE WHEN t.tercero_persona = 'N'
                    THEN CONCAT(t.tercero_nombre1,' ',t.tercero_nombre2,' ',t.tercero_apellido1,' ',t.tercero_apellido2,
                            (CASE WHEN (t.tercero_razonsocial IS NOT NULL AND t.tercero_razonsocial != '') THEN CONCAT(' - ', t.tercero_razonsocial) ELSE '' END)
                        )
                    ELSE t.tercero_razonsocial END)
                AS tercero_nombre"), DB::raw("CONCAT(elab.tercero_nombre1, ' ', elab.tercero_nombre2, ' ', elab.tercero_apellido1, ' ', elab.tercero_apellido2) as elaboro_nombre")
            );
		$query->join('regional','ajustep1_regional','=','regional.id');
		$query->join('conceptoajustep','ajustep1_conceptoajustep','=','conceptoajustep.id');
        $query->join('tercero as t', 'ajustep1_tercero', '=', 't.id');
        $query->join('tercero as elab', 'ajustep1_usuario_elaboro', '=', 'elab.id');
		$query->join('documentos','ajustep1_documentos','=','documentos.id');
		$query->where('ajustep1.id', $id);
		return $query->first();
	}
    /**
    * Function for reportes history client in cartera
    */
	public static function historyProveiderReport(Tercero $tercero, Array $historyProveider, $i)
	{
        $response = new \stdClass();
        $response->success = false;
        $response->ajusteProveedor = [];
        $response->position = 0;

       	$query = Ajustep1::query();
       	$query->select('ajustep1_numero', 'ajustep1_fh_elaboro', 'ajustep2_id_doc', 'ajustep2_naturaleza', 'ajustep2_valor', 'docafecta.documentos_nombre as docafecta', 'documento.documentos_nombre as documento', 'regional_nombre' );
       	$query->where('ajustep1_tercero', $tercero->id); 
        $query->join('ajustep2', 'ajustep1.id', '=', 'ajustep2_ajustep1');
        $query->join('regional', 'ajustep1_regional', '=', 'regional.id');
        $query->join('documentos as documento', 'ajustep1_documentos', '=', 'documento.id');
        $query->join('documentos as docafecta', 'ajustep2_documentos_doc', '=', 'docafecta.id');
        $ajusteProveedor = $query->get();

        foreach ($ajusteProveedor as $value) {
        	$historyProveider[$i]['documento'] = $value->documento;
        	$historyProveider[$i]['numero'] = $value->ajustep1_numero;
        	$historyProveider[$i]['regional'] = $value->regional_nombre;
        	$historyProveider[$i]['docafecta'] = $value->docafecta;
        	$historyProveider[$i]['id_docafecta'] = $value->ajustep2_id_doc;
        	$historyProveider[$i]['cuota'] = $value->ajustep2_id_doc;
        	$historyProveider[$i]['naturaleza'] = $value->ajustep2_naturaleza;
        	$historyProveider[$i]['valor'] = $value->ajustep2_valor;
        	$historyProveider[$i]['elaboro_fh'] = $value->ajustep1_fh_elaboro;
        	$i++;
        }
        $response->ajusteProveedor = $historyProveider;
        $response->position = $i;
        return $response;
	}
}
