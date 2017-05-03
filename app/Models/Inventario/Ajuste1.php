<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use Validator,DB;
class Ajuste1 extends Model
{
   /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'ajuste1';

	public $timestamps = false;

	 /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['ajuste1_fecha','ajuste1_observaciones'];	  
	
	/**
	* The default ajuste if documentos.
	*
	* @var static string
	*/

	public static $default_document = 'AJUS';

	public function isValid($data)
	{
		$rules = [
		    'ajuste1_fecha' => 'required|date',
		    'ajuste1_numero' => 'required|numeric'
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
            // Validar Carrito
            $ajuste2 = isset($data['ajuste2']) ? $data['ajuste2'] : null;
            if(!isset($ajuste2) || $ajuste2 == null || !is_array($ajuste2) || count($ajuste2) == 0) {
                $this->errors = 'Por favor ingrese el detalle para realizar el ajuste.';
                return false;
            }

            return true;
        }

		$this->errors = $validator->errors();
		return false;
	}
	public static function getAjuste($id)
	{
		$query = Ajuste1::query();
		$query->select('ajuste1.*','tipoajuste_nombre','sucursal_nombre','tercero_nit',DB::raw("CONCAT(tercero_nombre1, ' ', tercero_nombre2, ' ', tercero_apellido1, ' ', tercero_apellido2) as tercero_nombre"));
		$query->join('tipoajuste','ajuste1.ajuste1_tipoajuste','=','tipoajuste.id');
		$query->join('sucursal','ajuste1.ajuste1_sucursal','=', 'sucursal.id');
		$query->join('tercero','ajuste1.ajuste1_usuario_elaboro','=', 'tercero.id');
		$query->where('ajuste1.id',$id);
		return $query->first();
	}	
}
