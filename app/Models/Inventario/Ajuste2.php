<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use Validator,DB;
class Ajuste2 extends Model
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'ajuste2';

	public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = ['ajuste2_cantidad_entrada','ajuste2_cantidad_salida','ajuste2_costo'];	

	public function isValid($data)
	{
		$rules = [
		    'ajuste2_cantidad_entrada' => 'numeric',
		    'ajuste2_cantidad_salida' => 'numeric',
		    'ajuste2_costo' => 'numeric',
		    'ajuste2_costo_promedio' => 'numeric'
		];

		$validator = Validator::make($data, $rules);
		if ($validator->passes()) {
		    return true;
		}
		$this->errors = $validator->errors();
		return false;
	}

	public static function getAjuste2($id)
	{
		$query = Ajuste2::query();
		$query->select('ajuste2.*','producto_serie','producto_nombre')->where('ajuste2_ajuste1',$id);
        $query->join('producto', 'ajuste2_producto', '=' ,'producto.id');
        $query->orderBy('ajuste2.id', 'asc');
		return  $query->get();
	}

}
