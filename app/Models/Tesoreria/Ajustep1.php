<?php

namespace App\Models\Tesoreria;

use Illuminate\Database\Eloquent\Model;

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
		$query->select('ajustep1.*','regional_nombre','documentos_nombre','conceptoajustep_nombre', DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre")
            );
		$query->join('regional','ajustep1_regional','=','regional.id');
		$query->join('conceptoajustep','ajustep1_conceptoajustep','=','conceptoajustep.id');
		$query->join('tercero','ajustep1_tercero','=','tercero.id');
		$query->join('documentos','ajustep1_documentos','=','documentos.id');
		$query->where('ajustep1.id', $id);
		return $query->first();
	}
}
