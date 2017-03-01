<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;

class Pedido2 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pedido2';

    public $timestamps = false;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['pedido2_pedido1','pedido2_serie','pedido2_cantidad','pedido2_saldo','pedido2_precio']


    public function isValid($data)
    {
        $rules = [
            'pedido2_pedido1' => 'required|numeric',
            'pedido2_serie' => 'required|numeric',
            'pedido2_cantidad' => 'required|numeric',
            'pedido2_saldo' => 'required|numeric',
            'pedido2_precio' => 'numeric'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getPedido2($id)
    {
        $query = Pedido2::query();
        $query->select('pedido2.*');
       
        $query->orderBy('pedido2.id', 'asc');
        return  $query->get();
    }
}
