<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;

use Validator;

class TrasladoUbicacion2 extends Model
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'trasladou2';

	public $timestamps = false;
	
	 /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['trasladou2_cantidad'];
    
 	public function isValid($data)
    {
        $rules = [
            'trasladou2_cantidad' => 'numeric|required'
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getTrasladoUbicacion2($id)
    {
        $query = TrasladoUbicacion2::query();
        $query->select('producto.id', 'trasladou2_cantidad', 'producto_serie', 'producto_nombre');
        $query->join('producto', 'trasladou2_producto', '=', 'producto.id');
        $query->where('trasladou2_trasladou1', $id);
        $trasladou2 = $query->get();
        return $trasladou2;
    }

}
