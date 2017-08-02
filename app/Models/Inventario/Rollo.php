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

 	public  static function actualizar(Producto $producto, $sucursal, $tipo, $lote, $fecha, $cantidad, $ubicacion, $cantRollo = 0)
 	{
        $response = new \stdClass();
        $response->success = false;
        $response->rollos = [];
        $response->cantidad = [];

        // Validar sucursal
        $sucursal = Sucursal::find($sucursal);
        if(!$sucursal instanceof Sucursal) {
            $response->error = "No es posible recuperar sucursal rollo, por favor verifique la información o consulte al administrador.";
            return $response;
        }

        // Validar unidades
        if(!is_numeric($cantidad) || $cantidad <= 0){
            $response->error = "No es posible recuperar unidades rollo, por favor verifique la información o consulte al administrador.";
            return $response;
        }

        switch ($tipo) {
            case 'E':
                while ($cantidad > 0) {
                    $rollo = new Rollo;
                    $rollo->rollo_serie = $producto->id;
                    $rollo->rollo_sucursal = $sucursal->id;
                    $rollo->rollo_lote = $lote;
                    $rollo->rollo_ubicacion = $ubicacion;
                    $rollo->rollo_fecha = $fecha;

                    if ($cantRollo == 0) {
                        $rollo->rollo_metros = $cantidad;
                        $rollo->rollo_saldo = $rollo->rollo_metros;
                    }else if($cantRollo > 0 && $cantidad <= $cantRollo){
                        $rollo->rollo_metros = $cantRollo;
                        $rollo->rollo_saldo = $cantidad;
                    }else{
                        $rollo->rollo_metros = $cantRollo;
                        $rollo->rollo_saldo = $cantidad;
                    }
                    $cantidad = $cantidad - $rollo->rollo_saldo;
                    $rollo->save();
                    $response->success = true; 
                    $response->rollos[] = $rollo->id;
                    $response->cantidad[] = $rollo->rollo_saldo;
                }
            break;
            case 'S':
                $rollo = Rollo::find($lote);
                if (!$rollo instanceof Rollo) {
                    $response->error = "No es posible recuperar rollo del producto $producto->producto_nombre en la sucursal $sucursal->sucursal_nombre";
                    return $response;
                }
                // Validar disponibles
                if($cantidad > $rollo->rollo_saldo){
                    $rollo2 = Rollo::where('rollo_saldo',$rollo->rollo_saldo)->where('rollo_saldo','>', 0)->where('rollo_serie', $producto->id)->where('rollo_sucursal', $sucursal->id)->where('rollo_ubicacion', $rollo->rollo_ubicacion)->get();

                    if ( $rollo2->isEmpty() ) {
                        $response->error = "No existen suficientes unidades para salida producto {$producto->producto_nombre}, disponibles {$rollo->rollo_metros}, salida $cantidad, por favor verifique la información o consulte al administrador.";
                        return $response; 
                    }

                    $metros = 0;
                    $item = 0;
                    foreach ($rollo2 as $model) {
                        if (($item + $model->rollo_saldo) > $cantidad) {
                            $metros = $cantidad - $item;
                            $model->rollo_saldo = $model->rollo_saldo - $metros;
                            $model->save();
                            $response->rollos[] = $model->id;
                            $response->cantidad[] = $metros;
                            break;
                        }
                        $aux = $metros;
                        $metros = $metros - $model->rollo_saldo;
                        $item += $model->rollo_saldo;
                        $model->rollo_saldo = ($aux - $metros) - $model->rollo_saldo;
                        $model->save();
                        $response->rollos[] = $model->id;
                        $response->cantidad[] = ($aux - $metros);
                    }
                }else{
                    $rollo->rollo_saldo = ($rollo->rollo_saldo - $cantidad);
                    $rollo->save();
                    $response->rollos[] = $rollo->id;
                    $response->cantidad[] = $cantidad;
                }

                $response->success = true;
                $response->rollo_ubicacion = $rollo->rollo_ubicacion;
                $response->rollo_lote = $rollo->rollo_lote;
                $response->rollo_metros = $rollo->rollo_metros;
            break;

            default:
                $response->error = "No es posible recuperar tipo movimiento rollo, por favor verifique la información o consulte al administrador.";
                return $response;
            break;
        }
        return $response;
    }
}
