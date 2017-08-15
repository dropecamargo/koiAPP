<?php

namespace App\Models\Inventario;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base\Sucursal, App\Models\Base\Documentos;
use Validator, Auth;

class Entrada1 extends Model
{
   /**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'entrada1';

	public $timestamps = false;

	/**
	* The default entrada if documentos.
	*
	* @var static string
	*/

	public static $default_document = 'ENTR';

	 /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
    protected $fillable = ['entrada1_fecha','entrada1_observaciones'];

	public function isValid($data)
	{
		$rules = [
		    'entrada1_fecha' => 'required|date',
		    'entrada1_sucursal' => 'required|numeric',
		    'entrada1_numero' => 'required|numeric',
		    'entrada1_lote' => 'required|max:50'
		];

		$validator = Validator::make($data, $rules);
    	if ($validator->passes()) {
    		$sucursal = Sucursal::find($data['entrada1_sucursal']);
    		if (!$sucursal instanceof Sucursal) {
    			$this->errors = 'No es posible recuperar sucursal, por favor consulte al administrador.';
    		}
            return true;
        }

		$this->errors = $validator->errors();
		return false;
	}

	public static function store ($data,$data2, $tercero) 
	{
        $response = new \stdClass();
        $response->success = true;
        //Validar Documentos
        $documento = Documentos::where('documentos_codigo', Entrada1::$default_document)->first();
        if(!$documento instanceof Documentos) {
        	$response->success = false;
        	$response->errors = 'No es posible recuperar documentos,por favor verifique la información ó por favor consulte al administrador.';
        	return $response;
        }
        $sucursal = Sucursal::find($data['entrada1_sucursal']);
        if(!$sucursal instanceof Sucursal) {
        	$response->success = false;
        	$response->errors = 'No es posible recuperar sucursal,por favor verifique la información ó por favor consulte al administrador.';
        	return $response;
        }

        // Consecutive
        $consecutive = $sucursal->sucursal_entr + 1;

        // Entrada 1
        $entrada1 = new Entrada1;
        $entrada1->fill($data);
        $entrada1->entrada1_documentos = $documento->id;
        $entrada1->entrada1_sucursal = $sucursal->id;
        $entrada1->entrada1_tercero = $tercero;
        $entrada1->entrada1_numero = $consecutive;
        $entrada1->entrada1_usuario_elaboro = Auth::user()->id;
        $entrada1->entrada1_fh_elaboro = date('Y-m-d H:m:s');
        $entrada1->save();

        foreach ($data2 as $item) {
            $producto = Producto::find($item['id_producto']);
            if (!$producto instanceof Producto) {
	        	$response->success = false;
	        	$response->errors = 'No es posible recuperar el producto,por favor verifique la información ó por favor consulte al administrador';
	        	return $response;
            }
            // Detalle entrada != Manejaserie
            if ($producto->producto_maneja_serie != true) {

                // Costo promedio
                $costopromedio = $producto->costopromedio($item['entrada2_costo'], $item['entrada2_cantidad']);

                $entrada2 = new Entrada2;
                $entrada2->fill($item);
                $entrada2->entrada2_costo_promedio = $costopromedio;
                $entrada2->entrada2_entrada1 = $entrada1->id;
                $entrada2->entrada2_producto = $producto->id;
                $entrada2->save();

                // Prodbode
                $result = Prodbode::actualizar($producto, $sucursal->id, 'E', $entrada2->entrada2_cantidad, $sucursal->sucursal_defecto);
                if(!$result instanceof Prodbode) {
		        	$response->success = false;
		        	$response->errors = $result;
		        	return $response;
                }
            }
            // Producto maneja serie
            if ($producto->producto_maneja_serie == true) {

                // Costo
                $costo = $item['entrada2_costo'];

                for ($i=1; $i <= $item['entrada2_cantidad']; $i++) {

                    //Movimiento entrada maneja serie
                    $movimiento = Inventario::entradaManejaSerie($producto, $sucursal, $item["producto_serie_$i"], $costo);
                    if($movimiento != 'OK') {
			        	$response->success = false;
			        	$response->errors = $movimiento;
			        	return $response;
                    }
                    // Valido el replicate
                    $serie = Producto::where('producto_serie', $item["producto_serie_$i"])->first();
                    if(!$serie instanceof Producto) {
			        	$response->success = false;
			        	$response->errors = 'No es posible recuperar serie, por favor verifique la información ó por favor consulte al administrador';
			        	return $response;
                    }

                    // Detalle entrada
                    $entrada2 = new Entrada2;
                    $entrada2->fill($item);
                    $entrada2->entrada2_entrada1 = $entrada1->id;
                    $entrada2->entrada2_cantidad = 1;
                    $entrada2->entrada2_costo_promedio = $costo;
                    $entrada2->entrada2_producto = $serie->id;
                    $entrada2->save();

                    $lote = Lote::actualizar($serie, $sucursal->id, $data['entrada1_lote'], 'E', 1, $sucursal->sucursal_defecto, $entrada1->entrada1_fecha, null);
                    if (!$lote instanceof Lote) {
			        	$response->success = false;
			        	$response->errors = 'No es posible recuperar lote, por favor verifique la información ó por favor consulte al administrador';
			        	return $response;
                    }
                    // Inventario
                    $inventario = Inventario::movimiento($serie, $sucursal->id, $sucursal->sucursal_defecto,'ENTR', $entrada1->id, 1, 0, [], [], $costo, $costo,$lote->id,[]);
                    if ($inventario != 'OK') {
			        	$response->success = false;
			        	$response->errors = $inventario;
			        	return $response;
                    }
                }
            // Producto Metrado
            }else if ($producto->producto_metrado == true) {
                $items = isset($item['items']) ? $item['items'] : null;
                foreach ($items as $value) {
                    for ($i=0; $i < $value['rollo_cantidad']; $i++) {
                        // Individualiza en rollo
                        $rollo = Rollo::actualizar($producto, $sucursal->id, 'E', $value['rollo_lote'], $entrada1->entrada1_fecha, $value['rollo_metros'], $sucursal->sucursal_defecto);
                        if (!$rollo->success) {
							$response->success = false;
							$response->errors = $rollo;
							return $response;
                        }
                        // Inventario
                        $inventario = Inventario::movimiento($producto, $sucursal->id, $sucursal->sucursal_defecto,'ENTR', $entrada1->id, 0, 0, $rollo->cantidad,[],$entrada2->entrada2_costo, $costopromedio,0,$rollo->rollos);
                        if ($inventario != 'OK') {
							$response->success = false;
							$response->errors = $inventario;
							return $response;
                        }
                    }
                }
            }else if ($producto->producto_vence == true) {
                $items = isset($item['items']) ? $item['items'] : null;
                foreach ($items as $value) {
                    // Individualiza en lote
                    $lote = Lote::actualizar($producto, $sucursal->id, $value['lote_numero'], 'E', $value['lote_cantidad'], $sucursal->sucursal_defecto ,$entrada1->entrada1_fecha, $value['lote_fecha']);
                    if (!$lote instanceof Lote) {
						$response->success = false;
						$response->errors = 'No es posible recuperar lote, por favor verifique la información ó por favor consulte al administrador';
						return $response;
                    }
                    // Inventario
                    $inventario = Inventario::movimiento($producto, $sucursal->id, $sucursal->sucursal_defecto,'ENTR', $entrada1->id, $value['lote_cantidad'], 0, [], [], $entrada2->entrada2_costo, $costopromedio,$lote->id,[]);
                    if ($inventario != 'OK') {
						$response->success = false;
						$response->errors =  $inventario;
						return $response;
                    }
                }
            }else{
                // Individualiza en lote
                $lote = Lote::actualizar($producto, $sucursal->id, $data['entrada1_lote'], 'E', $entrada2->entrada2_cantidad, $sucursal->sucursal_defecto, $entrada1->entrada1_fecha);
                if (!$lote instanceof Lote) {
					$response->success = false;
					$response->errors = 'No es posible recuperar lote, por favor verifique la información ó por favor consulte al administrador';
					return $response;
                }
                // Inventario
                $inventario = Inventario::movimiento($producto, $sucursal->id, $sucursal->sucursal_defecto,'ENTR', $entrada1->id, $entrada2->entrada2_cantidad, 0, [], [], $entrada2->entrada2_costo, $costopromedio,$lote->id,[]);
                if ($inventario != 'OK') {
					$response->success = false;
					$response->errors = $inventario;
					return $response;
                }
            }
        }

        // Update consecutive sucursal_ajus in Sucursal
        $sucursal->sucursal_ajus = $consecutive;
        $sucursal->save();
        return $response;
	}
}
