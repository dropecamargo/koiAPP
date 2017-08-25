<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Traslado2 extends Model
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'traslado2';

	public $timestamps = false;
	
	 /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['traslado2_cantidad'];
    
 	public function isValid($data)
    {
        $rules = [
            'traslado2_cantidad' => 'numeric|required'
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getTraslado2 ($id)
    {
        $query = Traslado2::query();
        $query->select('producto.id', 'traslado2_cantidad', 'traslado2_costo', 'producto_serie', 'producto_nombre');
        $query->join('producto', 'traslado2_producto', '=', 'producto.id');
        $query->where('traslado2_traslado1', $id);
        $traslado2 = $query->get();
        return $traslado2;
    }
}
