<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;
use App\Models\Base\Tercero;
use Validator,DB;

class ChposFechado1 extends BaseModel
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'chposfechado1';

	public $timestamps = false;

    public static $default_document = 'CHP';
	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['chposfechado1_girador','chposfechado1_valor','chposfechado1_fecha', 'chposfechado1_ch_fecha','chposfechado1_observaciones','chposfechado1_ch_numero'];

    protected $boolean = ['chposfechado1_central_riesgo'];

	public function isValid($data)
	{
		$rules = [
			'chposfechado1_girador' => 'required|max:100',
			'chposfechado1_valor' => 'required|numeric',
			'chposfechado1_fecha' => 'required',
			'chposfechado1_ch_fecha' => 'required',
			'chposfechado1_ch_numero' => 'required|max:25',
			'chposfechado1_sucursal' => 'required|numeric',
			'chposfechado1_banco' => 'required|numeric',
			'chposfechado1_numero' => 'required|numeric'
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            // Validar Carrito
            $detalle = isset($data['detalle']) ? $data['detalle'] : null;
            if(!isset($detalle) || $detalle == null || !is_array($detalle) || count($detalle) == 0) {
                $this->errors = 'Por favor ingrese el concepto para realizar cheque posfechado.';
                return false;
            }
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}


	public static function getCheque($id){
		$query = ChposFechado1::query();
		$query->select('chposfechado1.*','sucursal_nombre','banco_nombre',DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            );
		$query->join('tercero', 'chposfechado1_tercero', '=', 'tercero.id');
		$query->join('sucursal', 'chposfechado1_sucursal', '=', 'sucursal.id');
		$query->join('banco', 'chposfechado1_banco', '=', 'banco.id');
		$query->where('chposfechado1.id', $id);
        return $query->first();
	}
	/**
	* The keys in factura3 clean.
	*/
	public function clearKey(){

		$query = Factura3::query();
		$query->where('factura3_chposfechado1', $this->id);
		$factura3 = $query->get();
		foreach ($factura3 as $item) {
			$item->factura3_chposfechado1 = null;
			$item->save();
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
        $response->cheque = [];
        $response->position = 0;

        $query = ChposFechado1::query();
        $query->select('chposfechado1.*', 'docafecta.documentos_nombre as docafecta', 'docafecta.documentos_codigo as afectaCode','documento.documentos_nombre as documento', 'chposfechado2_id_doc', 'chposfechado2_valor', 'sucursal_nombre');
        $query->where('chposfechado1_tercero', $tercero->id);
        $query->join('chposfechado2', 'chposfechado1.id', '=', 'chposfechado2_chposfechado1');
        $query->join('sucursal', 'chposfechado1_sucursal', '=', 'sucursal.id');
        $query->join('documentos as documento', 'chposfechado1_documentos', '=', 'documento.id');
        $query->join('documentos as docafecta', 'chposfechado2_documentos_doc', '=', 'docafecta.id');
        $cheque = $query->get();


        foreach ($cheque as $value) {
            $chequeItem = [];
            if ($value->afectaCode == 'FACT') {
                $query = ChposFechado2::select('factura1_numero', 'factura3_cuota');
                $query->leftJoin('factura3','chposfechado2_id_doc', '=', 'factura3.id');
                $query->leftJoin('factura1','factura3_factura1', '=', 'factura1.id');
                $query->where('factura3.id', $value->chposfechado2_id_doc);
                $chequeItem = $query->first();
            }
        	$historyClient[$i]['documento'] = "$value->documento *";
        	$historyClient[$i]['numero'] = $value->chposfechado1_numero;
        	$historyClient[$i]['sucursal'] = $value->sucursal_nombre;
        	$historyClient[$i]['docafecta'] = $value->docafecta;
        	$historyClient[$i]['id_docafecta'] = empty($chequeItem) ? '-' : $chequeItem->factura1_numero;
        	$historyClient[$i]['cuota'] = empty($chequeItem) ? '-' : $chequeItem->factura1_cuota;
        	$historyClient[$i]['naturaleza'] ='C';
        	$historyClient[$i]['valor'] = $value->chposfechado2_valor;
            $historyClient[$i]['fecha'] = $value->chposfechado1_fecha;
            $historyClient[$i]['elaboro_fh'] = $value->chposfechado1_fh_elaboro;
        	$historyClient[$i]['afectaCode'] = $value->afectaCode;
        	$i++;
        }
        $response->cheque = $historyClient;
        $response->position = $i;
        return $response;
	}
}
