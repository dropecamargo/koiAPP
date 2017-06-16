<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;
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
}
