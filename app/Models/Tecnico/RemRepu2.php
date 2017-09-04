<?php

namespace App\Models\Tecnico;

use Illuminate\Database\Eloquent\Model;

use App\Models\Inventario\Prodbode, App\Models\Tecnico\RemRepu, App\Models\Inventario\Producto, App\Models\Inventario\Lote, App\Models\Inventario\Inventario, App\Models\Base\Sucursal, App\Models\Base\Documentos;
use Validator, Auth, DB;

class RemRepu2 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'remrepu2';

    public $timestamps = false;


     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['remrepu2_cantidad'];

    public function isValid($data)
    {
        $rules = [
            'remrepu2_cantidad' => 'required_if:remrepu2_facturado_tec,""|numeric|min:1',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getRemRepu2 () 
    {
        $remrepu2 = RemRepu2::query();
        $remrepu2->select('remrepu2.*', 'producto_precio1 AS remrepu2_costo', 'impuesto_porcentaje AS remrepu2_iva_porcentaje' ,'producto_nombre AS remrepu2_nombre', 'producto_serie AS remrepu2_serie', 'remrepu1_numero', 'sucursal_nombre', 'remrepu1_tipo');
        $remrepu2->join('producto', 'remrepu2_producto','=','producto.id');
        $remrepu2->join('impuesto', 'producto_impuesto','=','impuesto.id');
        $remrepu2->join('remrepu1', 'remrepu2_remrepu1','=','remrepu1.id');
        $remrepu2->join('sucursal', 'remrepu1_sucursal','=','sucursal.id');
        return $remrepu2;
    }

    public static function createLegalizacion($child, $facturado, $nofacturado, $devuelto, $usado) {
        // Recuperar Remrepu
        $father = RemRepu::find($child->remrepu2_remrepu1);
        if(!$father instanceof Remrepu){
            return "No es posible recuperar remision, por favor verifique la informacion o consulte al administrador.";
        }

        // Recupero instancia de sucursal
        $origen  = Sucursal::find($father->remrepu1_sucursal);
        if (!$origen instanceof Sucursal) {
            return 'No es posible recuperar la sucursal de origen, por favor verifique la información ó consulte al administrador.';
        }

        // Consecutive sucursal_remr
        $consecutive = $origen->sucursal_remr + 1;

        // Duplicate remrepu and store remrepu2
        $item = $father->replicate();
        $item->remrepu1_sucursal = $origen->id;
        $item->remrepu1_numero = $consecutive;
        $item->remrepu1_tipo = 'L';
        $item->save();

        $remrepu2 = new RemRepu2;
        $remrepu2->remrepu2_producto = $child->remrepu2_producto;
        $remrepu2->remrepu2_remrepu1 = $item->id;
        $remrepu2->remrepu2_cantidad = 0;
        $remrepu2->remrepu2_facturado = $facturado;
        $remrepu2->remrepu2_no_facturado = $nofacturado;
        $remrepu2->remrepu2_devuelto = $devuelto;
        $remrepu2->remrepu2_usado = $usado;
        $remrepu2->save();

        if ( $devuelto > 0 ) {
            // Recuperar sucursal => destino
            $provisional = Sucursal::where('sucursal_nombre', '091 PROVISIONAL')->first();
            if(!$provisional instanceof Sucursal) {
                return 'No es posible recuperar la sucursal de destino, por favor verifique la información ó consulte al administrador.';
            }

            // Recuperar instancia de producto
            $producto = Producto::find($remrepu2->remrepu2_producto);
            if(!$producto instanceof Producto) {
                return 'No es posible recuperar el producto, por favor verifique la información ó consulte al administrador.';
            }

            // Validar Documento
            $documento = Documentos::where('documentos_codigo', RemRepu::$default_document)->first();
            if(!$documento instanceof Documentos) {
                return 'No es posible recuperar documentos, por favor verifique la información ó por favor consulte al administrador.';
            }

            //Recuperar lote & ubicacion
            $lote = Lote::where('lote_serie', $producto->id)->where('lote_sucursal', $provisional->id)->where('lote_saldo', '>' , '0')->first();
            if(!$lote instanceof Lote){
                return 'No es posible recuperar el lote, por favor verifique la información ó por favor consulte al administrador.';
            }

            // Detalle traslado Prodbode origen y destino
            $prodbodeOrigen = Prodbode::actualizar($producto, $provisional->id, 'S', $devuelto, $lote->lote_ubicacion);
            if(!$prodbodeOrigen instanceof Prodbode) {
                return $prodbodeOrigen;
            }

            $prodbodeDestino = Prodbode::actualizar($producto, $origen->id, 'E', $devuelto, $provisional->sucursal_defecto);
            if(!$prodbodeDestino instanceof Prodbode) {
                return $prodbodeDestino;
            }

            if ( $producto->producto_maneja_serie == false && $producto->producto_vence == false && $producto->producto_metrado == false && $producto->producto_unidad == true ) {
                if ($devuelto > 0) {
                    // Individualiza en lote
                    $result = Lote::actualizar($producto, $provisional->id, $lote->id, 'S', $devuelto, null, null, null);
                    if (!$result instanceof Lote) {
                        return $result;
                    }

                    // Inventario
                    $inventario = Inventario::movimiento($producto, $provisional->id, $lote->lote_ubicacion, 'REMR', $item->id, 0, $devuelto, [], [], 0, 0,$lote->id, []);
                    if ($inventario != 'OK') {
                        return $inventario;
                    }

                    /**
                    * Entrada sucursal destino
                    */
                    $result = Lote::actualizar($producto, $origen->id, $lote->lote_numero, 'E', $devuelto, $origen->sucursal_defecto, date('Y-m-d'), $lote->lote_vencimiento);
                    if (!$result instanceof Lote) {
                        return $result;
                    }
                    // Inventario
                    $inventario = Inventario::movimiento($producto, $origen->id, $origen->sucursal_defecto, 'REMR', $item->id, $devuelto, 0, [], [], 0, 0, $lote->id, []);
                    if ($inventario != 'OK') {
                        return $inventario;
                    }
                }
            }
        }

        // Update sucursal_remr
        $origen->sucursal_remr = $consecutive;
        $origen->save();

        return 'OK';
    }

    public static function trasladoRemRepu($father, $child, $cantidad) {
        // Recuperar Sucursal origen
        $origen  = Sucursal::find($father->remrepu1_sucursal);
        if (!$origen instanceof Sucursal) {
            return 'No es posible recuperar la sucursal de origen, por favor verifique la información ó consulte al administrador.';
        }

        // Consecutive sucursal_remr
        $consecutive = $origen->sucursal_remr + 1;

        // Recuperar sucursal => destino
        $destino = Sucursal::where('sucursal_nombre', '091 PROVISIONAL')->first();
        if(!$destino instanceof Sucursal) {
            return 'No es posible recuperar la sucursal de destino, por favor verifique la información ó consulte al administrador.';
        }

        // Recuperar instancia de producto
        $producto = Producto::find($child->remrepu2_producto);
        if(!$producto instanceof Producto) {
            return 'No es posible recuperar el producto, por favor verifique la información ó consulte al administrador.';
        }

        // Validar Documento
        $documento = Documentos::where('documentos_codigo', RemRepu::$default_document)->first();
        if(!$documento instanceof Documentos) {
            return 'No es posible recuperar documentos, por favor verifique la información ó por favor consulte al administrador.';
        }
        //Recuperar lote & ubicacion
        $lote = Lote::where('lote_serie', $producto->id)->where('lote_sucursal', $origen->id)->where('lote_saldo', '>' , '0')->first();
        if(!$lote instanceof Lote){
            return 'No es posible recuperar el lote, por favor verifique la información ó por favor consulte al administrador.';
        }

        // Detalle traslado Prodbode origen y destino
        $prodbodeOrigen = Prodbode::actualizar($producto, $origen->id, 'S', $cantidad, $lote->lote_ubicacion);
        if(!$prodbodeOrigen instanceof Prodbode) {
            return $prodbodeOrigen;
        }

        $prodbodeDestino = Prodbode::actualizar($producto, $destino->id, 'E', $cantidad, $destino->sucursal_defecto);
        if(!$prodbodeDestino instanceof Prodbode) {
            return $prodbodeDestino;
        }

        if ( $producto->producto_maneja_serie == false && $producto->producto_vence == false && $producto->producto_metrado == false && $producto->producto_unidad == true ) {
            // Individualiza en lote
            $result = Lote::actualizar($producto, $origen->id, $lote->id, 'S', $cantidad, null, null, null);
            if (!$result instanceof Lote) {
                return $result;
            }

            // Inventario
            $inventario = Inventario::movimiento($producto, $origen->id, $lote->lote_ubicacion, 'REMR', $father->id, 0, $cantidad, [], [], 0, 0,$lote->id, []);
            if ($inventario != 'OK') {
                return $inventario;
            }

            /**
            * Entrada sucursal destino
            */
            $result = Lote::actualizar($producto, $destino->id, $lote->lote_numero, 'E', $cantidad, $destino->sucursal_defecto, date('Y-m-d'), $lote->lote_vencimiento);
            if (!$result instanceof Lote) {
                return $result;
            }
            // Inventario
            $inventario = Inventario::movimiento($producto, $destino->id, $destino->sucursal_defecto, 'REMR', $father->id, $cantidad, 0, [], [], 0, 0, $lote->id, []);
            if ($inventario != 'OK') {
                return $inventario;
            }
        }

        // Update sucursal_remr
        $origen->sucursal_remr = $consecutive;
        $origen->save();

        return 'OK';
    }
}
