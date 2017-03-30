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

    public static function actualizar(Producto $producto, $sucursal, $tipo,$metros = 0, $costo = 0,$lote)
    {   

        // Validar sucursal
        $sucursal = Sucursal::find($sucursal);
        if(!$sucursal instanceof Sucursal) {
            return "No es posible recuperar sucursal prodbode rollo, por favor verifique la información o consulte al administrador.";
        }
        $items = DB::table('prodboderollo')->where('prodboderollo_serie', $producto->id)->where('prodboderollo_sucursal', $sucursal->id)->where('prodboderollo_lote',$lote)->max('prodboderollo_item');
        $items++;

    	// Validar item
        if(!is_numeric($items) || $items <= 0){
            return "No es posible recuperar item prodbode rollo, por favor verifique la información o consulte al administrador.";
        }

        // Validar metros
        if($metros <= 0){
            return "No es posible recuperar metros prodbode rollo, por favor verifique la información o consulte al administrador.";
        }

        // Recuperar prodbode rollo
    	$prodboderollo = Prodboderollo::where('prodboderollo_serie', $producto->id)->where('prodboderollo_sucursal', $sucursal->id)->where('prodboderollo_item', $items)->where('prodboderollo_lote', $lote)->first();

		if(!$prodboderollo instanceof Prodboderollo){
        	$prodboderollo = new Prodboderollo;
	        $prodboderollo->prodboderollo_serie = $producto->id;
	        $prodboderollo->prodboderollo_sucursal = $sucursal->id;
	        $prodboderollo->prodboderollo_item = $items;
	        $prodboderollo->prodboderollo_metros = $metros;
            $prodboderollo->prodboderollo_saldo = $metros;
	        $prodboderollo->prodboderollo_costo = $costo;
            $prodboderollo->prodboderollo_lote = $lote;
            $prodboderollo->prodboderollo_fecha_lote =date('Y-m-d');
    	}else{

	    	switch ($tipo) {
	    		case 'E':
			        $prodboderollo->prodboderollo_saldo = ($prodboderollo->prodboderollo_saldo + $metros);

				break;

				case 'S':
					// Validar disponibles
                    if($metros > $prodboderollo->prodboderollo_saldo){
                        return "No existen suficientes unidades para salida item rollo producto {$producto->producto_codigo}, item {$item}, por favor verifique la información o consulte al administrador.";
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
