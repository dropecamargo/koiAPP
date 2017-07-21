<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base\Sucursal;

class Rollo extends Model
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
    protected $table = 'rollo';

    public $timestamps = false;

 	public  static function actualizar(Producto $producto, $sucursal, $tipo, $lote, $fecha, $cantidad, $ubicacion)
 	{
        // Validar sucursal
        $sucursal = Sucursal::find($sucursal);
        if(!$sucursal instanceof Sucursal) {
            return "No es posible recuperar sucursal rollo, por favor verifique la información o consulte al administrador.";
        }

        // Validar unidades
        if(!is_numeric($cantidad) || $cantidad <= 0){
            return "No es posible recuperar unidades rollo, por favor verifique la información o consulte al administrador.";
        }

        switch ($tipo) {
            case 'E':
            	$rollo = new Rollo;
                $rollo->rollo_serie = $producto->id;
                $rollo->rollo_sucursal = $sucursal->id;
                $rollo->rollo_lote = $lote;
                $rollo->rollo_ubicacion = $ubicacion;
                $rollo->rollo_metros = ($rollo->rollo_metros + $cantidad);
                $rollo->rollo_saldo = ($rollo->rollo_saldo + $rollo->rollo_metros);
                $rollo->rollo_fecha = $fecha;
            break;
            case 'S':
                $rollo = Rollo::find($lote);
                if (!$rollo instanceof Rollo) {
                    return "No es posible recuperar rollo del producto $producto->producto_nombre en la sucursal $sucursal->sucursal_nombre";
                }
                // Validar disponibles
                if($cantidad > $rollo->rollo_saldo){
                    // $rollo2 = Rollo::where('rollo.id', '<>', $rollo->id)->where('rollo_serie', $producto->id)->where('rollo_sucursal', $sucursal->id)->where('rollo_ubicacion', $ubicacion)->first();
                    // if (!$rollo2 instanceof Rollo) {
                    // }
                        return "No existen suficientes unidades para salida producto {$producto->producto_nombre}, disponibles {$rollo->rollo_metros}, salida $cantidad, por favor verifique la información o consulte al administrador.";
                }
                $rollo->rollo_saldo = ($rollo->rollo_saldo - $cantidad);
            break;

            default:
                return "No es posible recuperar tipo movimiento rollo, por favor verifique la información o consulte al administrador.";
            break;
        }
		$rollo->save();

        return $rollo;
    }
}
