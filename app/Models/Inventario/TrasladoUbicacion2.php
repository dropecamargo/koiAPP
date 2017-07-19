<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;

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
}
