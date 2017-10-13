<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;
use App\Models\Base\Tercero;
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
        $query->select('nota1.*', 'docafecta.documentos_nombre as docafecta', 'documento.documentos_nombre as documento', 'nota2_id_doc', 'nota2_valor', 'sucursal_nombre');
        $query->where('nota1_tercero', $tercero->id);
        $query->join('nota2', 'nota1.id', '=', 'nota2_nota1');
        $query->join('sucursal', 'nota1_sucursal', '=', 'sucursal.id');
        $query->join('documentos as documento', 'nota1_documentos', '=', 'documento.id');
        $query->join('documentos as docafecta', 'nota2_documentos_doc', '=', 'docafecta.id');
        $nota = $query->get();


        foreach ($nota as $value) {
        	$historyClient[$i]['documento'] = $value->documento;
        	$historyClient[$i]['numero'] = $value->nota1_numero;
        	$historyClient[$i]['sucursal'] = $value->sucursal_nombre;
        	$historyClient[$i]['docafecta'] = $value->docafecta;
        	$historyClient[$i]['id_docafecta'] = $value->nota2_id_doc;
        	$historyClient[$i]['cuota'] = 0;
        	$historyClient[$i]['naturaleza'] ='D';
        	$historyClient[$i]['valor'] = $value->nota2_valor;
        	$historyClient[$i]['elaboro_fh'] = $value->nota1_fh_elaboro;
        	$i++;
        }
        $response->nota = $historyClient;
        $response->position = $i;
        return $response;
	}
}
