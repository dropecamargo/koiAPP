<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base\Sucursal;
use DB;
class Prodbodelote extends Model
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
    protected $table = 'prodbodelote';

    public $timestamps = false;


    public  static function actualizar(Producto $producto, $sucursal, $tipo, $unidades,$loteSaldo,$loteA)
    {  
        // Validar sucursal
        $sucursal = Sucursal::find($sucursal);
        if(!$sucursal instanceof Sucursal) {
            return "No es posible recuperar sucursal prodbodelote, por favor verifique la información o consulte al administrador.";
        }

        // Validar unidades
        if(!is_numeric($unidades) || $unidades <= 0){

            return "No es posible recuperar unidades prodbodelote, por favor verifique la información o consulte al administrador.";
        }
            
        $prodbodelote = Prodbodelote::where('prodbodelote_serie',$producto->id)->where('prodbodelote_sucursal',$sucursal->id)->where('prodbodelote_lote', $loteA)->first();
        if(!$prodbodelote instanceof Prodbodelote){
        	$prodbodelote = new Prodbodelote;
	        $prodbodelote->prodbodelote_lote = $loteA;
            $prodbodelote->prodbodelote_serie = $producto->id;
            $prodbodelote->prodbodelote_sucursal = $sucursal->id;
            $prodbodelote->prodbodelote_fecha_lote =date('Y-m-d');
    	}

        switch ($tipo) {
            case 'E':
                $prodbodelote->prodbodelote_cantidad = ($prodbodelote->prodbodelote_cantidad + $unidades);
                $prodbodelote->prodbodelote_saldo = ($prodbodelote->prodbodelote_saldo + $loteSaldo);
            break;
            case 'S':
                // Validar disponibles
                if($unidades > $prodbodelote->prodbodelote_cantidad){
                    return "No existen suficientes unidades para salida del producto {$producto->id}, disponibles {$prodbodelote->prodbodelote_cantidad}, salida $unidades, por favor verifique la información o consulte al administrador.";
                }
                $prodbodelote->prodbodelote_cantidad = ($prodbodelote->prodbodelote_cantidad - $unidades);
                $prodbodelote->prodbodelote_saldo = ($prodbodelote->prodbodelote_saldo - $loteSaldo);
            break;

            default:
                return "No es posible recuperar tipo movimiento prodbodelote, por favor verifique la información o consulte al administrador.";
            break;
        }


		$prodbodelote->save();

        return 'OK';
    }

}
