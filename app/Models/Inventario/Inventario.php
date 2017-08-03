<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base\Sucursal, App\Models\Base\Documentos;
use Auth, DB;

class Inventario extends Model
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
    protected $table = 'inventario';

    public $timestamps = false;

    public static function movimiento(Producto $producto, $sucursal, $ubicacion, $documento, $documentoNumero, $uentrada = 0, $usalida = 0, Array $emetros = [],Array $smetros = [], $costo = 0, $costopromedio = 0, $lote = 0, Array $rollo ){

    	 // Validar producto
        $sucursal = Sucursal::find($sucursal);
        if(!$sucursal instanceof Sucursal) {
            return "No es posible recuperar sucursal movimiento inventario, por favor verifique la información o consulte al administrador.";
        }
        $documento = Documentos::where('documentos_codigo',$documento)->first();
        if (!$documento instanceof Documentos) {
             return "No es posible recuperar documentos de  inventario, por favor verifique la información o consulte al administrador.";
        }
        // Manejo de metros
        if ( !empty($rollo) ) {
            foreach ($rollo as $key => $value) {
                $inventario = new Inventario;
                $inventario->inventario_serie    = $producto->id;
                $inventario->inventario_sucursal = $sucursal->id;
                $inventario->inventario_ubicacion = $ubicacion;
                $inventario->inventario_documentos = $documento->id;
                $inventario->inventario_id_documento = $documentoNumero;
                $inventario->inventario_metros_entrada = (!empty($emetros) ? $emetros[$key] : 0);
                $inventario->inventario_metros_salida = (!empty($smetros) ? $smetros[$key] : 0);
                $inventario->inventario_entrada = $uentrada;
                $inventario->inventario_salida = $usalida;
                $inventario->inventario_costo = $costo;
                $inventario->inventario_rollo = $value;
                $inventario->inventario_lote = $lote;
                $inventario->inventario_costo_promedio = $costopromedio;
                $inventario->inventario_usuario_elaboro = Auth::user()->id;
                $inventario->inventario_fh_elaboro = date('Y-m-d H:m:s');
                $inventario->save();
            }
        }else{
            $inventario = new Inventario;
            $inventario->inventario_serie    = $producto->id;
            $inventario->inventario_sucursal = $sucursal->id;
            $inventario->inventario_ubicacion = $ubicacion;
            $inventario->inventario_documentos = $documento->id;
            $inventario->inventario_id_documento = $documentoNumero;
            $inventario->inventario_entrada = $uentrada;
            $inventario->inventario_salida = $usalida;
            $inventario->inventario_costo = $costo;
            $inventario->inventario_lote = $lote;
            $inventario->inventario_costo_promedio = $costopromedio;
            $inventario->inventario_usuario_elaboro = Auth::user()->id;
            $inventario->inventario_fh_elaboro = date('Y-m-d H:m:s');
            $inventario->save();
        }

        return 'OK';
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
        $result = Prodbode::actualizar($serie, $sucursal->id, 'E', 1, $sucursal->sucursal_defecto);
        if(!$result instanceof Prodbode) {
            return $result;
        }

    	return 'OK';
    }

    public static function getInventory($documento, $id){

        $inventario = Inventario::query();
        $inventario->select('inventario.*', 'tercero_nit',DB::raw("CONCAT(tercero_nombre1, ' ', tercero_nombre2, ' ', tercero_apellido1, ' ', tercero_apellido2) as tercero_nombre"), 'producto_serie','producto_nombre', 'ubicacion_nombre');
        $inventario->where('inventario_documentos', $documento);
        $inventario->where('inventario_id_documento', $id);
        $inventario->join('producto', 'inventario_serie', '=' ,'producto.id');
        $inventario->join('ubicacion', 'inventario_ubicacion', '=' ,'ubicacion.id');
        $inventario->join('tercero','inventario_usuario_elaboro','=', 'tercero.id');
        $inventario->orderBy('id', 'asc');

        return $inventario->get();
    }
}
