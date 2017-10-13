<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base\Tercero;
use Validator,DB;

class ChDevuelto extends Model
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'chdevuelto';

	public $timestamps = false;

    public static $default_document = 'CHD';

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = [];

	public function isValid($data)
	{
		$rules = [
			'chdevuelto_causal' => 'required|numeric'
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}

	public static function getChequeDevuelto($id){
		$query = ChDevuelto::query();
		$query->select('chdevuelto.*','chposfechado1.*','sucursal_nombre','banco_nombre',DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            );
		$query->join('tercero', 'chdevuelto_tercero', '=', 'tercero.id');
		$query->join('sucursal', 'chdevuelto_sucursal', '=', 'sucursal.id');
        $query->join('chposfechado1', 'chdevuelto_chposfechado1', '=', 'chposfechado1.id');
        $query->join('banco','chposfechado1_banco', '=', 'banco.id');
		$query->where('chdevuelto.id', $id);
		
        return $query->first();
	}
	/**
	* Function for reportes history client in cartera
	*/
	public static function historyClientReport (Tercero $tercero, $historyClient, $i)
	{
        $response = new \stdClass();
        $response->success = false;
        $response->chequeDevuelto = [];
        $response->position = 0;

        $query = ChDevuelto::query();
        $query->select('chdevuelto_numero', 'chdevuelto_valor', 'chdevuelto_fh_elaboro','documentos_nombre', 'sucursal_nombre');
        $query->where('chdevuelto_tercero', $tercero->id);
        $query->join('sucursal', 'chdevuelto_sucursal', '=', 'sucursal.id');
        $query->join('documentos', 'chdevuelto_documentos', '=', 'documentos.id');
        $chequeDevuelto = $query->get();
        foreach ($chequeDevuelto as $value) {
        	$historyClient[$i]['documento'] = $value->documentos_nombre;
        	$historyClient[$i]['numero'] = $value->chdevuelto_numero;
        	$historyClient[$i]['sucursal'] = $value->sucursal_nombre;
        	$historyClient[$i]['docafecta'] = '-';
        	$historyClient[$i]['id_docafecta'] = '-';
        	$historyClient[$i]['cuota'] = 1;
        	$historyClient[$i]['naturaleza'] ='D';
        	$historyClient[$i]['valor'] = $value->chdevuelto_valor;
        	$historyClient[$i]['elaboro_fh'] = $value->chdevuelto_fh_elaboro;
        	$i++;
        }
        $response->chequeDevuelto = $historyClient;
        $response->position = $i;
        return $response;
	}
}
