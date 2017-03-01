<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;

use DB, Validator;

class Producto extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'producto';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['producto_referencia', 'producto_nombre', 'producto_ref_proveedor', 'producto_categoria','producto_linea', 'producto_unidadmedida', 'producto_vidautil','producto_peso','producto_largo','producto_alto','producto_ancho','producto_barras','producto_marca','producto_modelo','producto_precio1','producto_precio2','producto_precio3','producto_impuesto'];

    /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = ['producto_maneja_serie', 'producto_metrado', 'producto_vence'];

    /**
     * The attributes that are mass nullable fields to null.
     *
     * @var array
     */
    // protected $nullable = [];

    public function isValid($data)
    {
        $rules = [
          'producto_referencia' => 'required|max:20' 
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()){
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getProduct($id)
    {
        $query = Producto::query();
        $query->select('producto.*', 'unidadmedida_sigla', 'unidadmedida_nombre','categoria_nombre','linea_nombre','modelo_nombre','marca_nombre','impuesto_nombre','impuesto_porcentaje');
        $query->join('unidadmedida','producto.producto_unidadmedida','=','unidadmedida.id');
        $query->join('categoria','producto.producto_categoria','=','categoria.id');
        $query->join('linea','producto.producto_linea','=','linea.id');
        $query->join('marca','producto.producto_marca','=','marca.id');
        $query->join('modelo','producto.producto_modelo','=','modelo.id');
        $query->join('impuesto','producto.producto_impuesto','=','impuesto.id');
        $query->where('producto.id', $id);
        return $query->first();
    }

    
}
