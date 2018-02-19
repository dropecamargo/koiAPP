<?php

namespace App\Models\Tecnico;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use App\Models\Inventario\Prodbode, App\Models\Inventario\Producto, App\Models\Inventario\Lote, App\Models\Inventario\Inventario, App\Models\Base\Sucursal, App\Models\Base\Documentos;
use Validator, DB;

class Orden extends BaseModel
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
    protected $table = 'orden';

    public $timestamps = false;

	/**
	* The attributes that are mass assignable.
	* @var array
	*/
    protected $fillable =['orden_tipoorden','orden_solicitante','orden_llamo','orden_dano','orden_prioridad','orden_problema'];

    protected $nullable = ['orden_serie'];

    public static $default_document = 'ORD';

    public function isValid($data)
    {
        $rules = [
        	'orden_tipoorden'=>'required',
        	'orden_solicitante'=>'required',
        	'orden_tercero'=>'required',
        	'orden_dano'=>'required',
        	'orden_prioridad'=>'required',
        	'orden_problema'=>'required|max:100',
            'orden_fecha_servicio' => 'required|date_format:Y-m-d',
            'orden_hora_servicio' => 'required|date_format:H:m'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getOrden($id)
    {
        $query = Orden::query();
        $query->select('orden.*',DB::raw("TIME(orden_fh_servicio) as orden_hora_servicio"), DB::raw("DATE(orden_fh_servicio) as orden_fecha_servicio"), 'o.tercero_nit','t.tercero_nit as tecnico_nit','producto.id as id_p','producto_nombre','producto_serie','dano_nombre','tipoorden_nombre','prioridad_nombre','solicitante_nombre', DB::raw("CONCAT(o.tercero_nombre1, ' ', o.tercero_nombre2, ' ', o.tercero_apellido1, ' ', o.tercero_apellido2) as tercero_nombre"),DB::raw("CONCAT(t.tercero_nombre1 , ' ', t.tercero_nombre2, ' ', t.tercero_apellido1, ' ', t.tercero_apellido2) as tecnico_nombre"),'sucursal_nombre', 'tcontacto_telefono', 'tcontacto_email', DB::raw("CONCAT(tcontacto_nombres,' ',tcontacto_apellidos ) as tcontacto_nombre"), 'sitio_nombre');

        $query->join('tercero as o', 'orden_tercero', '=', 'o.id');
        $query->join('tercero as t', 'orden_tecnico', '=', 't.id');
        $query->join('tcontacto', 'orden_contacto', '=', 'tcontacto.id');
        $query->join('sucursal', 'orden_sucursal', '=', 'sucursal.id');
        $query->join('dano', 'orden_dano', '=', 'dano.id');
        $query->join('tipoorden', 'orden_tipoorden', '=', 'tipoorden.id');
        $query->join('solicitante', 'orden_solicitante', '=', 'solicitante.id');
        $query->join('prioridad', 'orden_prioridad', '=', 'prioridad.id');
        $query->join('sitio', 'orden_sitio', '=', 'sitio.id');
        $query->leftJoin('producto', 'orden_serie', '=', 'producto.id');

        $query->where('orden.id', $id);
        return $query->first();
    }

    public static function closeValid ($id)
    {
        // Prepare response
        $response = new \stdClass();
        $response->success = true;
        $response->numFacturado = 0;

        // Validar remrepu
        $remrepu = RemRepu::where('remrepu1_orden', $id)->where('remrepu1_tipo', 'R')->get();
        if( count($remrepu) <= 0){
            $response->success = false;
            $response->errors = 'No existen legalizaciones, por favor verifique la información para poder cerrar la orden.';
            return $response;
        }

        foreach ($remrepu as $father) {
            $remrepu2 = RemRepu2::where('remrepu2_remrepu1', $father->id)->first();
            if($remrepu2->remrepu2_saldo != 0){
                $response->success = false;
                $response->errors = 'La legalizacion no esta completa, por favor verifique la información para poder cerrar la orden.';
                return $response;
            }
            $response->numFacturado +=  $remrepu2->remrepu2_facturado;
        }

        // Validar vistia minima
        $visita = Visita::where('visita_orden', $id)->get();
        if(count($visita) == 0){
            $response->success = false;
            $response->errors = 'Necesita ingresar una visita, por favor verifique la información para poder cerrar la orden.';
            return $response;
        }

        return $response;
    }

    public static function inventarioFactura(Producto $producto, $orden, $factura1, $sucursal, $cantidad) {
        // Recuperar sucursal => origen
        $origen = Sucursal::where('sucursal_nombre', '091 PROVISIONAL')->first();
        if(!$origen instanceof Sucursal) {
            return 'No es posible recuperar la sucursal de origen, por favor verifique la información ó consulte al administrador.';
        }
        // Recuperar Sucursal origen
        $destino  = Sucursal::find($sucursal);
        if (!$destino instanceof Sucursal) {
            return 'No es posible recuperar la sucursal de destino, por favor verifique la información ó consulte al administrador.';
        }


        // Validar Documento
        $documento = Documentos::where('documentos_codigo', Orden::$default_document)->first();
        if(!$documento instanceof Documentos) {
            return 'No es posible recuperar documentos, por favor verifique la información ó por favor consulte al administrador.';
        }
        //Recuperar lote & ubicacion
        $lote = Lote::where('lote_serie', $producto->id)->where('lote_sucursal', $origen->id)->where('lote_saldo', '>' , '0')->first();
        if(!$lote instanceof Lote){
            return 'No es posible recuperar el lote, por favor verifique la información ó por favor consulte al administrador.';
        }

        // Detalle traslado Prodbode origen y destino
        $prodbodeOrigen = Prodbode::actualizar($producto, $origen->id, 'S', $cantidad, $lote->lote_ubicacion);
        if(!$prodbodeOrigen instanceof Prodbode) {
            return $prodbodeOrigen;
        }

        $prodbodeDestino = Prodbode::actualizar($producto, $destino->id, 'E', $cantidad, $destino->sucursal_defecto);
        if(!$prodbodeDestino instanceof Prodbode) {
            return $prodbodeDestino;
        }

        if ( $producto->producto_maneja_serie == false && $producto->producto_vence == false && $producto->producto_metrado == false && $producto->producto_unidad == true ) {
            // Individualiza en lote
            $result = Lote::actualizar($producto, $origen->id, $lote->id, 'S', $cantidad, null, null, null);
            if (!$result instanceof Lote) {
                return $result;
            }

            // Inventario
            $inventario = Inventario::movimiento($producto, $origen->id, $lote->lote_ubicacion, 'ORD', $orden, 0, $cantidad, [], [], 0, 0,$lote->id, []);
            if ($inventario != 'OK') {
                return $inventario;
            }

            /**
            * Entrada sucursal destino
            */
            $result = Lote::actualizar($producto, $destino->id, $lote->lote_numero, 'E', $cantidad, $destino->sucursal_defecto, date('Y-m-d'), $lote->lote_vencimiento);
            if (!$result instanceof Lote) {
                return $result;
            }
            // Inventario
            $inventario = Inventario::movimiento($producto, $destino->id, $destino->sucursal_defecto, 'ORD', $orden, $cantidad, 0, [], [], 0, 0, $lote->id, []);
            if ($inventario != 'OK') {
                return $inventario;
            }

            /**
            * Movimiento
            * Individualiza en lote
            */
            $lote = Lote::actualizar($producto, $destino->id, $result->id, 'S', $cantidad, $destino->sucursal_defecto);
            if (!$lote instanceof Lote) {
                dd($lote);
                return $lote;
            }
            // Prodbode
            $result = Prodbode::actualizar($producto, $destino->id, 'S', $cantidad, $lote->lote_ubicacion);
            if(!$result instanceof Prodbode) {
                return $result;
            }
            // Inventario
            $inventario = Inventario::movimiento($producto, $destino->id, $result->prodbode_ubicacion,'FACT', $factura1, 0, $cantidad, [], [], $producto->producto_precio1, $producto->producto_precio1, $lote->id,[]);
            if ($inventario != 'OK') {
                 return $inventario;
            }
        }

        return 'OK';
    }
}
