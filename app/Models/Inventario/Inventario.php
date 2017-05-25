<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Models\Base\Sucursal, App\Models\Base\Documentos;

class Inventario extends Model
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
    protected $table = 'inventario';

    public $timestamps = false;

    public static function movimiento(Producto $producto, $sucursal, $documento, $documentoNumero, $uentrada = 0, $usalida = 0, $emetros = 0, $smetros = 0, $costo = 0, $costopromedio = 0,$lote = 0, $rollo = 0){
    	 // Validar producto
        $sucursal = Sucursal::find($sucursal);
        if(!$sucursal instanceof Sucursal) {
            return "No es posible recuperar sucursal movimiento inventario, por favor verifique la información o consulte al administrador.";
        }
        $documento = Documentos::where('documentos_codigo',$documento)->first();
        if (!$documento instanceof Documentos) {
             return "No es posible recuperar documentos de  inventario, por favor verifique la información o consulte al administrador.";
        }
        $inventario = new Inventario;
        $inventario->inventario_serie	 = $producto->id;
        $inventario->inventario_sucursal = $sucursal->id;
        $inventario->inventario_documentos = $documento->id;
        $inventario->inventario_id_documento = $documentoNumero;
		$inventario->inventario_metros_entrada = $emetros;
		$inventario->inventario_metros_salida = $smetros;
		$inventario->inventario_entrada = $uentrada;
		$inventario->inventario_salida = $usalida;	
        $inventario->inventario_costo = $costo;
        $inventario->inventario_rollo = $rollo;
        $inventario->inventario_lote = $lote;
        $inventario->inventario_costo_promedio = $costopromedio;
        $inventario->inventario_usuario_elaboro = Auth::user()->id;
        $inventario->inventario_fh_elaboro = date('Y-m-d H:m:s');

        $inventario->save();

        return $inventario;
    }

    public static function entradaManejaSerie(Producto $referencia, Sucursal $sucursal, $serie, $costo){
    	if ( $costo == 0 ) {
    		return "El costo de la serie debe ser diferente de 0.";
    	}
        // Replica producto
        $serie = $referencia->serie($serie);
        if(!$serie instanceof Producto) {
            return $serie;
        }

        // Actualiza costo
        $serie->producto_costo = $costo;
        $serie->save();

        // ProdBode
        $result = Prodbode::actualizar($serie, $sucursal->id, 'E', 1);
        if($result != 'OK') {
            return $result;
        }

    	return 'OK';
    }
}
