<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base\Sucursal;
use DB;
class Prodboderollo extends Model
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
    protected $table = 'prodboderollo';

    public $timestamps = false;

    public static function actualizar(Producto $producto, $sucursal, $tipo, $item, Lote $lote, $metros = 0, $costo = 0)
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
        $prodboderollo = Prodboderollo::where('prodboderollo_serie', $producto->id)->where('prodboderollo_sucursal', $sucursal->id)->where('prodboderollo_item', $item)->where('prodboderollo_lote', $lote->id)->first();
        if(!$prodboderollo instanceof Prodboderollo){
            // Validar metros
             if($metros <= 0){
                return "No es posible recuperar metros prodbode rollo, por favor verifique la información o consulte al administrador.";
            }else{
                $prodboderollo = new Prodboderollo;
                $prodboderollo->prodboderollo_serie = $producto->id;
                $prodboderollo->prodboderollo_sucursal = $sucursal->id;
                $prodboderollo->prodboderollo_lote = $lote->id;
                $prodboderollo->prodboderollo_item = $item;
                $prodboderollo->prodboderollo_metros = $metros;
                $prodboderollo->prodboderollo_saldo = $metros;
                $prodboderollo->prodboderollo_costo = $costo;
            }   
        }else{

            switch ($tipo) {
                case 'E':
                    $prodboderollo->prodboderollo_saldo = ($prodboderollo->prodboderollo_saldo + $metros);

                break;

                case 'S':
                    // Validar disponibles
                    if($metros > $prodboderollo->prodboderollo_saldo){
                        return "No existen suficientes unidades para salida item rollo producto {$producto->producto_serie}, item {$item}, por favor verifique la información o consulte al administrador.";
                    }
                    $prodboderollo->prodboderollo_saldo = ($prodboderollo->prodboderollo_saldo - $metros);
                break;

                default:
                    return "No es posible recuperar tipo movimiento prodbode rollo, por favor verifique la información o consulte al administrador.";
                break;
            }
        }
        $prodboderollo->save();

        return $prodboderollo;
    }
}
