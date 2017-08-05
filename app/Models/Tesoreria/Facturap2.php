<?php

namespace App\Models\Tesoreria;

use Illuminate\Database\Eloquent\Model;
use Validator, DB;

class Facturap2 extends Model
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
    protected $table = 'facturap1';

    public $timestamps = false;

    /**
    * The default facturap if documentos.
    *
    * @var static string
    */

    public static $default_document = 'FPRO';

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = ['facturap2_base'];


    public function isValid($data)
    {
        $rules = [
        	'facturap2_base' => 'required|numeric|min:0'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
        	if ($data['facturap2_base'] <= 0 ) {
        		$this->errors = 'Valor debe ser mayor a 0';
                return false;
        	}
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getFacturap2 ($id) {
    }
}
