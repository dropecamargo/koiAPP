<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

use Validator,Cache,DB;

class Pedido1 extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pedido1';

    public $timestamps = false;


    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['pedido1_numero','pedido1_sucursal','pedido1_tercero','pedido1_fecha','pedido1_documentos','pedido1_fecha_estimada','pedido1_anticipo','pedido1_fecha_anticipo','pedido1_observaciones'];


     /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = [ 'pedido1_anulado','pedido1_cerrado'];

    /**
     * The default contador if documentos.
     *
     * @var static string
     */
    
    public static $default_document = 'PEDN';


    public function isValid($data)
    {
        $rules = [
            'pedido1_sucursal' => 'required|numeric',
            'pedido1_tercero' => 'required|numeric',
            'pedido1_fecha' => 'required|date',
            'pedido1_fecha_estimada' => 'required|date'
        
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getPedido($id)
    {
        $query = Pedido1::query();
        $query->select('pedido1.*','tercero_nit',DB::raw("CONCAT(tercero_nombre1, ' ', tercero_nombre2, ' ', tercero_apellido1, ' ', tercero_apellido2) as tercero_nombre"));

        $query->join('tercero', 'pedido1.pedido1_tercero', '=', 'tercero.id');
        
     
        $query->where('pedido1.id', $id);
        return $query->first();
    }
}
