<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base\Sucursal;
use DB;

class Prodbodevence extends Model
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
    protected $table = 'prodbodevence';

    public $timestamps = false;

    public static function actualizar(Producto $producto, $sucursal, $tipo, $item, Lote $lote, $cantidad = 0, $costo = 0)
    {   
        // Validar sucursal
        $sucursal = Sucursal::find($sucursal);
        if(!$sucursal instanceof Sucursal) {
            return "No es posible recuperar sucursal prodbode rollo, por favor verifique la información o consulte al administrador.";
        }

        // Validar item
        if(!is_numeric($item) || $item <= 0){
            return "No es posible recuperar item prodbode rollo, por favor verifique la información o consulte al administrador.";
        }


        // Recuperar prodbode rollo
        $prodbodevence = Prodbodevence::where('prodbodevence_serie', $producto->id)->where('prodbodevence_sucursal', $sucursal->id)->where('prodbodevence_item', $item)->where('prodbodevence_lote', $lote->id)->first();
        if(!$prodbodevence instanceof Prodbodevence){
            // Validar cantidad
             if($cantidad <= 0){
                return "No es posible recuperar cantidad prodbode vence, por favor verifique la información o consulte al administrador.";
            }else{
                $prodbodevence = new Prodbodevence;
                $prodbodevence->prodbodevence_serie = $producto->id;
                $prodbodevence->prodbodevence_sucursal = $sucursal->id;
                $prodbodevence->prodbodevence_lote = $lote->id;
                $prodbodevence->prodbodevence_item = $item;
                $prodbodevence->prodbodevence_cantidad = $cantidad;
                $prodbodevence->prodbodevence_saldo = $cantidad;
                $prodbodevence->prodbodevence_costo = $costo;
            }   
        }else{

            switch ($tipo) {
                case 'E':
                    $prodbodevence->prodbodevence_saldo = ($prodbodevence->prodbodevence_saldo + $cantidad);

                break;

                case 'S':
                    // Validar disponibles
                    if($cantidad > $prodbodevence->prodbodevence_saldo){
                        return "No existen suficientes unidades para salida item rollo producto {$producto->producto_serie}, item {$item}, por favor verifique la información o consulte al administrador.";
                    }
                    $prodbodevence->prodbodevence_saldo = ($prodbodevence->prodbodevence_saldo - $cantidad);
                break;

                default:
                    return "No es posible recuperar tipo movimiento prodbode rollo, por favor verifique la información o consulte al administrador.";
                break;
            }
        }
        $prodbodevence->save();

        return $prodbodevence;
    }

}
