<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base\Sucursal;

class Lote extends Model
{
    /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'lote';

    public $timestamps = false;
    
    public static function actualizar(Producto $producto, $sucursal, $loteNumero, $tipo, $cantidad, $ubicacion, $fecha = null, $fechaVencimiento = null)
    {
        // Validar sucursal
        $sucursal = Sucursal::find($sucursal);
        if(!$sucursal instanceof Sucursal) {
            return "No es posible recuperar sucursal lote, por favor verifique la información o consulte al administrador.";
        }
        // Validar unidades
        if(!is_numeric($cantidad) || $cantidad <= 0){
            return "No es posible recuperar unidades lote, por favor verifique la información o consulte al administrador.";
        }
        switch ($tipo) {
            case 'E':
                $lote = Lote::where('lote_serie', $producto->id)->where('lote_sucursal', $sucursal->id)->where('lote_vencimiento', $fechaVencimiento)->where('lote_ubicacion', $ubicacion)->first();
                if (!$lote instanceof Lote) {
                    $lote = new Lote;
                    $lote->lote_serie = $producto->id;
                    $lote->lote_sucursal = $sucursal->id;
                    $lote->lote_ubicacion = $ubicacion;
                    $lote->lote_numero = $loteNumero;
                    $lote->lote_fecha = $fecha;
                    $lote->lote_vencimiento = $fechaVencimiento;
                }
                $lote->lote_cantidad = ($lote->lote_cantidad + $cantidad);
                $lote->lote_saldo = ($lote->lote_saldo + $cantidad);
            break;
            case 'S':

                if ($producto->producto_maneja_serie == true) {
                    $lote = Lote::where('lote_serie',$producto->id)->where('lote_sucursal', $sucursal->id)->where('lote_saldo', 1)->first();
                }else{
                    $lote = Lote::find($loteNumero);
                }

                if(!$lote instanceof Lote){
                    return "No es posible recuperar lote del producto $producto->producto_nombre en la sucursal $sucursal->sucursal_nombre";
                }
                // Validar disponibles
                if($cantidad > $lote->lote_saldo){
                    return "No existen suficientes unidades para salida producto {$producto->producto_nombre}, disponibles {$lote->lote_cantidad}, salida $cantidad, por favor verifique la información o consulte al administrador.";
                }
                $lote->lote_saldo = ($lote->lote_saldo - $cantidad);
            break;
            default:
                return "No es posible recuperar tipo movimiento en lote, por favor verifique la información o consulte al administrador.";
            break;
        }
        $lote->save();
        return $lote;
    }
}
