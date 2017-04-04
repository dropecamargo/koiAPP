<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;

class Inventariorollo extends Model
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
    protected $table = 'inventariorollo';

    public $timestamps = false;

    public static function movimiento(Inventario $inventario, Prodboderollo $prodboderollo, $costo = 0, $mentrada = 0, $msalida = 0,$costopromedio)
    {
        // Validar unidades
        if($mentrada <= 0 && $msalida <= 0){
            return "No es posible recuperar metros movimiento rollo, por favor verifique la información o consulte al administrador.";
        }

        $inventariorollo = new InventarioRollo;
        $inventariorollo->inventariorollo_inventario = $inventario->id;
        $inventariorollo->inventariorollo_prodboderollo = $prodboderollo->id;
        $inventariorollo->inventariorollo_metros_entrada = $mentrada;
        $inventariorollo->inventariorollo_metros_salida = $msalida;
        $inventariorollo->inventariorollo_costo = $costo;
        $inventariorollo->inventariorollo_costo_promedio = $costopromedio;
        // $inventariorollo->inventariorollo_costo_metros = $prodboderollo->prodboderollo_costo;
        $inventariorollo->save();
        return $inventariorollo;
    }
}
