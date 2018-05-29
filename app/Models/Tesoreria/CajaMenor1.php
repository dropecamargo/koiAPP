<?php

namespace App\Models\Tesoreria;

use Illuminate\Database\Eloquent\Model;
use Validator, DB;

class CajaMenor1 extends Model
{
    /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'cajamenor1';

	public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['cajamenor1_observaciones'];

    public static $default_document = 'CM';

    public function isValid($data)
	{
		$rules = [
			'cajamenor1_regional' => 'required',
			'cajamenor1_numero' => 'required',
			'cajamenor1_tercero' => 'required'
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            // Validar Carrito
            $detalle = isset($data['detalle']) ? $data['detalle'] : null;
            if(!isset($detalle) || $detalle == null || !is_array($detalle) || count($detalle) == 0) {
                $this->errors = 'Por favor ingrese el detalle para realizar caja menor.';
                return false;
            }
            return true;
        }
		$this->errors = $validator->errors();
		return false;
	}

	public static function getCajaMenor($id){
		$query = CajaMenor1::query();
		$query->select('cajamenor1.*','regional_nombre','documentos_nombre', DB::raw("(CASE WHEN t.tercero_persona = 'N'
					THEN CONCAT(t.tercero_nombre1,' ',t.tercero_nombre2,' ',t.tercero_apellido1,' ',t.tercero_apellido2,
							(CASE WHEN (t.tercero_razonsocial IS NOT NULL AND t.tercero_razonsocial != '') THEN CONCAT(' - ', t.tercero_razonsocial) ELSE '' END)
						)
					ELSE t.tercero_razonsocial END)
				AS tercero_nombre"), DB::raw("CONCAT(elab.tercero_nombre1, ' ', elab.tercero_nombre2, ' ', elab.tercero_apellido1, ' ', elab.tercero_apellido2) as elaboro_nombre")
			);
		$query->join('regional','cajamenor1_regional','=','regional.id');
		$query->join('tercero as t', 'cajamenor1_tercero', '=', 't.id');
		$query->join('tercero as elab', 'cajamenor1_usuario_elaboro', '=', 'elab.id');
		$query->join('documentos','cajamenor1_documentos','=','documentos.id');
		$query->where('cajamenor1.id', $id);
		return $query->first();
	}
}
