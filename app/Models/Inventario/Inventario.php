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

    public static function movimiento(Producto $producto, $sucursal, $documento, $documentoNumero,$uentrada = 0, $usalida = 0, $costo = 0, $costopromedio = 0)
    {
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
        $inventario->inventario_producto = $producto->id;
        $inventario->inventario_sucursal = $sucursal->id;

        $inventario->inventario_documentos = $documento->id;
        $inventario->inventario_numero = $documentoNumero;
        $inventario->inventario_entrada = $uentrada;
        $inventario->inventario_salida = $usalida;
        // saldos sucursales ?
        $inventario->inventario_costo = $costo;
        $inventario->inventario_costo_promedio = $costopromedio;
        $inventario->inventario_usuario_elaboro = Auth::user()->id;
        $inventario->inventario_fecha_elaboro = date('Y-m-d H:m:s');
        $inventario->save();

        return $inventario;
    }
}
