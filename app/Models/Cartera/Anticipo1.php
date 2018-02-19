<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;

use App\Models\Base\Tercero;
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
}
