<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;
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
}
