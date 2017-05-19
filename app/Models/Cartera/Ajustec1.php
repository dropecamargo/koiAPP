<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;
use Validator, DB;

class Ajustec1 extends BaseModel
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'ajustec1';

	public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['ajustec1_numero', 'ajustec1_observaciones'];

    public static $default_document = 'AJUC';

    public function isValid($data)
	{
		$rules = [
			'ajustec1_sucursal' => 'required',
			'ajustec1_numero' => 'required',
			'ajustec1_tercero' => 'required',
			'ajustec1_conceptoajustec' => 'required',
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            // Validar Carrito
            $detalle = isset($data['detalle']) ? $data['detalle'] : null;
            if(!isset($detalle) || $detalle == null || !is_array($detalle) || count($detalle) == 0) {
                $this->errors = 'Por favor ingrese el detalle para realizar el recibo.';
                return false;
            }
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}

	public static function getAjustec($id){
		$query = Ajustec1::query();
		$query->select('ajustec1.*','sucursal_nombre','documentos_nombre','conceptoajustec_nombre', DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            );
		$query->join('sucursal','ajustec1_sucursal','=','sucursal.id');
		$query->join('conceptoajustec','ajustec1_conceptoajustec','=','conceptoajustec.id');
		$query->join('tercero','ajustec1_tercero','=','tercero.id');
		$query->join('documentos','ajustec1_documentos','=','documentos.id');
		$query->where('ajustec1.id', $id);
		return $query->first();
	}
}