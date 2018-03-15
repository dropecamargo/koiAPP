<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use DB, Validator, Log;

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
    protected $fillable = ['producto_referencia', 'producto_nombre', 'producto_ref_proveedor', 'producto_vidautil', 'producto_peso', 'producto_largo', 'producto_alto', 'producto_ancho', 'producto_barras', 'producto_precio1', 'producto_precio2', 'producto_precio3', 'producto_impuesto'];

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
    protected $nullable = ['producto_servicio', 'producto_tercero', 'producto_contacto', 'producto_vencimiento'];

    public function isValid($data)
    {
        $rules = [
            'producto_referencia' => 'required|max:20',
            'producto_serie' => 'unique:producto',
            'producto_linea' => 'required',
            'producto_grupo' => 'required',
            'producto_subgrupo' => 'required',
            'producto_tipoproducto' => 'required',
            'producto_marca' => 'required',
            'producto_modelo' => 'required',
            'producto_impuesto' => 'required'
        ];

        if ($this->exists){
            $rules['producto_serie'] .= ",producto_serie,$this->id";
        }
        
        $validator = Validator::make($data, $rules);
        if ($validator->passes()){
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }
    public static function isValidReferencia($referencia)
    {
        $rules = [
            'producto_referencia' => 'required|max:15|min:1|unique:producto'
        ];

        $validator = Validator::make($referencia, $rules);
        if ($validator->passes()) {
            return true;
        }
        return false;
    }

    public static function getProduct($id)
    {
        $query = Producto::query();
        $query->select('producto.*', 'unidadmedida_sigla', 'grupo_nombre', 'subgrupo_nombre', 'tipoproducto_nombre', 'unidadmedida_nombre', 'linea_nombre', 'modelo_nombre', 'marca_nombre', 'impuesto_nombre', 'impuesto_porcentaje', 'tercero_nit',
                DB::raw("(CASE WHEN tercero_persona = 'N'
                    THEN CONCAT(tercero_nombre1,' ',tercero_nombre2,' ',tercero_apellido1,' ',tercero_apellido2,
                            (CASE WHEN (tercero_razonsocial IS NOT NULL AND tercero_razonsocial != '') THEN CONCAT(' - ', tercero_razonsocial) ELSE '' END)
                        )
                    ELSE tercero_razonsocial END)
                AS tercero_nombre"), DB::raw("CONCAT(tcontacto_nombres,' ',tcontacto_apellidos) AS tcontacto_nombre"), 'tcontacto_telefono','servicio_nombre');
        $query->join('unidadmedida','producto_unidadmedida','=','unidadmedida.id');
        $query->join('grupo', 'producto_grupo', '=', 'grupo.id');
        $query->join('subgrupo', 'producto_subgrupo', '=', 'subgrupo.id');
        $query->join('linea', 'producto_linea', '=', 'linea.id');
        $query->join('tipoproducto', 'producto_tipoproducto', '=', 'tipoproducto.id');
        $query->join('marca', 'producto_marca', '=', 'marca.id');
        $query->join('modelo', 'producto_modelo', '=', 'modelo.id');
        $query->leftJoin('tercero', 'producto_tercero', '=', 'tercero.id');
        $query->leftJoin('tcontacto', 'producto_contacto', '=', 'tcontacto.id');
        $query->leftJoin('servicio', 'producto_servicio', '=', 'servicio.id');
        $query->join('impuesto', 'producto_impuesto', '=', 'impuesto.id');
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
            $query->select('sucursal_nombre', DB::raw('COUNT(sucursal_nombre) as prodbode_cantidad'), 'prodbode_reservado');
            $query->join('producto', 'prodbode.prodbode_serie', '=', 'producto.id');
            $query->join('sucursal', 'prodbode.prodbode_sucursal', '=', 'sucursal.id');

            if ($this->producto_serie == $this->producto_referencia) {
                $query->where('producto_referencia', $this->producto_serie);
            }else{
                $query->where('producto_referencia', $this->producto_referencia);
                $query->where('prodbode_serie', $this->id);
            }
            $query->whereRaw('prodbode_cantidad > 0');
        }else if($this->producto_metrado){
            $query = $this->hasMany('App\Models\Inventario\Prodbode', 'prodbode_serie', 'id')
                    ->select('prodbode.*','sucursal_nombre', DB::raw('SUM(prodbode_metros) AS prodbode_metros'), 'prodbode_reservado')
                    ->join('sucursal','prodbode.prodbode_sucursal','=','sucursal.id')
                    ->where('prodbode_metros', '>', 0);
        }else{
            $query = $this->hasMany('App\Models\Inventario\Prodbode', 'prodbode_serie', 'id')
                    ->select('prodbode.*','sucursal_nombre', DB::raw('SUM(prodbode_cantidad) AS prodbode_cantidad'),'prodbode_reservado')
                    ->join('sucursal','prodbode.prodbode_sucursal','=','sucursal.id')
                    ->where('prodbode_cantidad', '>', 0);
        }
        $query->groupBy('sucursal_nombre');
        return $query->get();
    }

    public function tipoproducto(){
        return $this->hasOne('App\Models\Inventario\TipoProducto', 'id', 'producto_tipoproducto');
    }
}
