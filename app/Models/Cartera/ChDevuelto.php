<?php

namespace App\Models\Cartera;

use Illuminate\Database\Eloquent\Model;
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
}
