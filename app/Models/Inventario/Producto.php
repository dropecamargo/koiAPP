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
    protected $fillable = ['producto_referencia', 'producto_nombre', 'producto_ref_proveedor', 'producto_categoria','producto_linea', 'producto_unidadmedida', 'producto_vidautil','producto_peso','producto_largo','producto_alto','producto_ancho','producto_barras','producto_modelo','producto_marca','producto_precio1','producto_precio2','producto_precio3','producto_impuesto', 'producto_unidadnegocio', 'producto_subcategoria'];

    /**
     * The attributes that are mass boolean assignable.
     *
     * @var array
     */
    protected $boolean = ['producto_maneja_serie', 'producto_metrado', 'producto_vence','producto_unidad'];

    /**
     * The attributes that are mass nullable fields to null.
     *
     * @var array
     */
    // protected $nullable = [];

    public function isValid($data)
    {
        $rules = [
            'producto_referencia' => 'required|max:20|unique:producto'
        ];

        if ($this->exists){
            $rules['producto_referencia'] .= ',producto_referencia,' . $this->id;
        }else{
            $rules['producto_referencia'] .= '|required';
        }

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
        $query->select('producto.*', 'unidadmedida_sigla', 'unidadmedida_nombre','categoria_nombre','unidadnegocio_nombre','subcategoria_nombre','linea_nombre','modelo_nombre','marca_nombre','impuesto_nombre','impuesto_porcentaje');
        $query->join('unidadmedida','producto.producto_unidadmedida','=','unidadmedida.id');
        $query->join('unidadnegocio','producto.producto_unidadnegocio','=','unidadnegocio.id');
        $query->join('categoria','producto.producto_categoria','=','categoria.id');
        $query->join('subcategoria','producto.producto_subcategoria','=','subcategoria.id');
        $query->join('linea','producto.producto_linea','=','linea.id');
        $query->join('marca','producto.producto_marca','=','marca.id');
        $query->join('modelo','producto.producto_modelo','=','modelo.id');
        $query->join('impuesto','producto.producto_impuesto','=','impuesto.id');
        $query->where('producto.id', $id);
        return $query->first();
    }

    public function serie($serie)
    {   $existencias = 0;
        $producto = Producto::where('producto_serie', $serie)->first();
        if($producto instanceof Producto ) {
            $existencias = DB::table('prodbode')->where('prodbode_serie', $producto->id)->sum('prodbode_cantidad');
            if ($existencias > 0) {
                return "Ya existe un producto con este número de serie {$producto->producto_serie}, por favor verifique la información del asiento o consulte al administrador.";
            }
        }else{
            $producto = $this->replicate();
            $producto->producto_serie = $serie;
            $producto->save();
        }
        return $producto;
    }

    public function costopromedio($costo = 0, $cantidad = 0, $update = true)
    {
        $suma = DB::table('prodbode')
            ->where('prodbode_serie', $this->id)
            ->sum('prodbode_cantidad');

        $totalp1 = $suma * $this->producto_costo;
        $totalp2 = $costo * $cantidad;
        $totalp3 = $cantidad + $suma;
        $costopromedio = ( $totalp1 + $totalp2 ) / $totalp3;

        if($update) {
            // Actualizar producto costo
            $this->producto_costo = $costopromedio;
            $this->save();
        }

        return $costopromedio;
    }

    /**
     * Get the prodbode record associated with the producto prodbode.
     */
    public function prodbode()
    {
        if($this->producto_maneja_serie){
            $query = Prodbode::query();
            $query->select('sucursal_nombre', DB::raw('count(sucursal_nombre) as prodbode_cantidad'), 'prodbode_reservado');
            $query->join('producto', 'prodbode.prodbode_serie', '=', 'producto.id');
            $query->join('sucursal', 'prodbode.prodbode_sucursal', '=', 'sucursal.id');

            if ($this->producto_serie == $this->producto_referencia) {
                $query->where('producto_referencia', $this->producto_serie);
            }else{
                $query->where('producto_referencia', $this->producto_referencia);
                $query->where('prodbode_serie', $this->id);
            }
            $query->whereRaw('prodbode_cantidad > 0');
            $query->groupBy('sucursal_nombre');
        }else if($this->producto_metrado){
            $query = $this->hasMany('App\Models\Inventario\Rollo', 'rollo_serie', 'id')
                        ->select('rollo.*',DB::raw('COUNT(rollo.id) AS rollo_rollos'),'sucursal_nombre')
                        ->join('sucursal','rollo.rollo_sucursal','=','sucursal.id')
                        ->whereRaw('rollo_saldo > 0')
                        ->groupBy('rollo_sucursal','rollo_saldo');
        }else{
            $query = $this->hasMany('App\Models\Inventario\Prodbode', 'prodbode_serie', 'id')
                        ->select('prodbode.*','sucursal_nombre')
                        ->join('sucursal','prodbode.prodbode_sucursal','=','sucursal.id');
        }
        return $query->get();
    }
}
