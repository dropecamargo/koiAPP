<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;
use App\Models\Base\Tercero;
use Validator;

class Ajustec2 extends BaseModel
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'ajustec2';

	public $timestamps = false;

    /**
     * The attributes that are mass nullable fields to null.
     *
     * @var array
     */
    protected $nullable = ['ajustec2_id_doc'];

	public function isValid($data)
	{
		$rules = [
			'ajustec2_tercero' => 'required',
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}
    /**
    * Function for reportes history client in cartera
    */
	public static function historyClientReport(Tercero $tercero, Array $historyClient, $i ) 
	{
        $response = new \stdClass();
        $response->success = false;
        $response->ajusteCartera = [];
        $response->position = 0;

        $query = Ajustec2::query();
        $query->select('ajustec2.*', 'docafecta.documentos_nombre as docafecta', 'docafecta.documentos_codigo as afectaCode' ,'documento.documentos_nombre as documento','ajustec1_numero','ajustec1_fh_elaboro' ,'ajustec1_fecha','conceptoajustec_plancuentas', 'sucursal_nombre');
        $query->where('ajustec2_tercero', $tercero->id);
        $query->join('ajustec1', 'ajustec1.id', '=', 'ajustec2_ajustec1');
        $query->join('sucursal', 'ajustec1.ajustec1_sucursal', '=', 'sucursal.id');
        $query->join('documentos as documento', 'ajustec1.ajustec1_documentos', '=', 'documento.id');
        $query->join('documentos as docafecta', 'ajustec2.ajustec2_documentos_doc', '=', 'docafecta.id');
        $query->join('conceptoajustec', 'conceptoajustec.id', '=', 'ajustec1_conceptoajustec');
        $ajusteCartera = $query->get();


        foreach ($ajusteCartera as $value) {
            $ajusteCartera2 = [];
            if ($value->afectaCode == 'FACT') {
                $query = Ajustec2::select('factura1_numero', 'factura3_cuota');
                $query->leftJoin('factura3','ajustec2_id_doc', '=', 'factura3.id');
                $query->leftJoin('factura1','factura3_factura1', '=', 'factura1.id');
                $query->where('factura3.id', $value->ajustec2_id_doc);
                $ajusteCartera2 = $query->first();
            }
        	$historyClient[$i]['documento'] = $value->documento;
        	$historyClient[$i]['numero'] = $value->ajustec1_numero;
        	$historyClient[$i]['sucursal'] = $value->sucursal_nombre;
        	$historyClient[$i]['docafecta'] = $value->docafecta;
        	$historyClient[$i]['id_docafecta'] = empty($ajusteCartera2) ? '-' : $ajusteCartera2->factura1_numero;
        	$historyClient[$i]['cuota'] = empty($ajusteCartera2) ? '-' : $ajusteCartera2->factura3_cuota;
        	$historyClient[$i]['naturaleza'] = $value->ajustec2_naturaleza;
        	$historyClient[$i]['valor'] = $value->ajustec2_valor;
        	$historyClient[$i]['fecha'] = $value->ajustec1_fecha;
            $historyClient[$i]['elaboro_fh'] = $value->ajustec1_fh_elaboro;
            $historyClient[$i]['afectaCode'] = $value->afectaCode;
            
        	$i++;
        }
        $response->ajusteCartera = $historyClient;
        $response->position = $i;
        return $response;
	}
}
