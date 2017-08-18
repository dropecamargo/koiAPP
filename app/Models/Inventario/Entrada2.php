<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use Validator; 

class Entrada2 extends Model
{
   /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'entrada2';

	public $timestamps = false;

		/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = ['entrada2_cantidad','entrada2_costo'];	

	public function isValid($data)
	{
		$rules = [
		    'entrada2_cantidad' => 'required|numeric',
		    'entrada2_costo' => 'required|numeric'
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
    		// Valid entrada
	     	$dataEntrada = isset($data['entrada']) ? $data['entrada'] : null;
	     	$entrada = new Entrada1;

            if(!$entrada->isValid($dataEntrada)) {
                $this->errors = $entrada->errors;
                return false;
            }

            if ($data['entrada2_cantidad'] <= 0) {
            	$this->errors = 'La cantidad de producto no puede ser menor o igual a 0';
                return false;
            }
        	if ($data['entrada2_costo'] <= 0) {
            	$this->errors = 'El costo del producto no puede ser menor o igual a 0';
                return false;
            }

            return true;
        }

		$this->errors = $validator->errors();
		return false;
	}

	public static function getEntrada2($id) 
	{
		$query = Entrada2::query();
		$query->select('entrada2.*', 'producto_serie', 'producto_nombre');
		$query->where('entrada2_entrada1', $id);
        $query->join('producto', 'entrada2_producto', '=' ,'producto.id');
        $query->orderBy('entrada2.id', 'asc');
		return $query->get();
	}
}
