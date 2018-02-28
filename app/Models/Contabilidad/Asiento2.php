<?php

namespace App\Models\Contabilidad;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Base\Tercero, App\Models\Contabilidad\Producto, App\Models\Inventario\Inventario, App\Models\Base\PuntoVenta, App\Models\Cartera\Factura1, App\Models\Cartera\Factura2, App\Models\Tesoreria\Facturap1, App\Models\Tesoreria\Facturap2;
use Validator, Auth, DB;

class Asiento2 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'asiento2';

    public $timestamps = false;

    public function isValid($data)
    {
        $rules = [
            'plancuentas_cuenta' => 'required|integer',
            'asiento2_naturaleza' => 'required'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }
        $this->errors = $validator->errors();
        return false;
    }

    public static function getAsiento2($asiento)
    {
        $query = Asiento2::query();
        $query->select('asiento2.*', 'plancuentas_cuenta', 'plancuentas_naturaleza', 'plancuentas_nombre', DB::raw('centrocosto_codigo as centrocosto_codigo'), 'centrocosto_nombre', 't.tercero_nit',
            DB::raw("(CASE WHEN t.tercero_persona = 'N'
                THEN CONCAT(t.tercero_nombre1,' ',t.tercero_nombre2,' ',t.tercero_apellido1,' ',t.tercero_apellido2,
                        (CASE WHEN (t.tercero_razonsocial IS NOT NULL AND t.tercero_razonsocial != '') THEN CONCAT(' - ', t.tercero_razonsocial) ELSE '' END)
                    )
                ELSE t.tercero_razonsocial END)
                AS tercero_nombre"),
            DB::raw("(CASE WHEN asiento2_credito != 0 THEN 'C' ELSE 'D' END) as asiento2_naturaleza")
        );
        $query->join('tercero as t', 'asiento2_beneficiario', '=', 't.id');
        $query->join('plancuentas', 'asiento2_cuenta', '=', 'plancuentas.id');
        $query->leftJoin('centrocosto', 'asiento2_centro', '=', 'centrocosto.id');
        $query->where('asiento2_asiento', $asiento);
        return $query->get();
    }

    public function store(Asiento $asiento, Array $data)
    {
        $response = new \stdClass();
        $response->success = false;

        // Recuperar cuenta
        $objCuenta = PlanCuenta::where('plancuentas_cuenta', $data['Cuenta'])->first();
        if(!$objCuenta instanceof PlanCuenta) {
            $response->error = "No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador.";
            return $response;
        }

        // Recuperar niveles cuenta
        $niveles = PlanCuenta::getNivelesCuenta($objCuenta->plancuentas_cuenta);
        if(!is_array($niveles)) {
            $response->error = "Error al recuperar niveles para la cuenta {$objCuenta->plancuentas_cuenta}.";
            return $response;
        }

        // Recuperar tercero
        $objTercero = Tercero::where('tercero_nit', $data['Tercero'])->first();
        if(!$objTercero instanceof Tercero) {
            $response->error = "No es posible recuperar beneficiario {$data['Tercero']}, por favor verifique la información del asiento o consulte al administrador.";
            return $response;
        }

        // Recuperar centro costo
        $objCentroCosto = null;
        if(isset($data['CentroCosto']) && !empty($data['CentroCosto'])) {
            $objCentroCosto = CentroCosto::find($data['CentroCosto']);
            if(!$objCentroCosto instanceof CentroCosto) {
                $response->error = "No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador.";
                return $response;
            }
        }

        // Validar valores
        if($data['Naturaleza'] == 'C') {
            if(!is_numeric($data['Credito']) || $data['Credito'] <= 0) {
                $response->error = "Valor no puede ser menor o igual a 0.";
                return $response;
            }
        }

        if($data['Naturaleza'] == 'D') {
            if(!is_numeric($data['Debito']) || $data['Debito'] <= 0) {
                $response->error = "Valor no puede ser menor o igual a 0 ({$data['Debito']}).";
                return $response;
            }
        }

        // Insert si no existe asiento2
        if(!isset($data['Id']) || empty($data['Id']))
        {
            $this->asiento2_asiento = $asiento->id;
            $this->asiento2_cuenta = $objCuenta->id;
            $this->asiento2_beneficiario = $objTercero->id;
            $this->asiento2_nivel1 = $niveles['nivel1'] ?: 0;
            $this->asiento2_nivel2 = $niveles['nivel2'] ?: 0;
            $this->asiento2_nivel3 = $niveles['nivel3'] ?: 0;
            $this->asiento2_nivel4 = $niveles['nivel4'] ?: 0;
            $this->asiento2_nivel5 = $niveles['nivel5'] ?: 0;
            $this->asiento2_nivel6 = $niveles['nivel6'] ?: 0;
            $this->asiento2_nivel7 = $niveles['nivel7'] ?: 0;
            $this->asiento2_nivel8 = $niveles['nivel8'] ?: 0;
            if($objCentroCosto instanceof CentroCosto)
            {
                $this->asiento2_centro = $objCentroCosto->id;
                if($objCentroCosto->centrocosto_codigo == 'OP') {

                    $objOrdenp = Ordenp::find($data['Orden']);
                    if(!$objOrdenp instanceof Ordenp) {
                        $response->error = "No es posible recuperar orden de producción para centro de costo OP, por favor verifique la información del asiento o consulte al administrador.";
                        return $response;
                    }

                    $this->asiento2_ordenp = $objOrdenp->id;
                }
            }
            $this->asiento2_detalle = $data['Detalle'] ?: '';
            $this->asiento2_credito = $data['Credito'] ?: 0;
            $this->asiento2_debito = $data['Debito'] ?: 0;
            $this->asiento2_base = $data['Base'] ?: 0;
            $this->save();
        }

        $response->success = true;
        return $response;
    }

    public static function validarAsiento2(Request $request, PlanCuenta $cuenta)
    {
        // Verifico que no existan subniveles de la cuenta que estoy realizando el asiento
        $result = $cuenta->validarSubnivelesCuenta();
        if($result != 'OK') {
            return $result;
        }

        // Recuperar niveles cuenta
        $niveles = PlanCuenta::getNivelesCuenta($cuenta->plancuentas_cuenta);
        if(!is_array($niveles)) {
            return "Error al recuperar niveles para la cuenta {$cuenta->plancuentas_cuenta}.";
        }

        // Validar base
        if( !empty($cuenta->plancuentas_tasa) && $cuenta->plancuentas_tasa > 0 && (!$request->has('asiento2_base') || $request->asiento2_base == 0) ) {
            return "Para la cuenta {$cuenta->plancuentas_cuenta} debe existir base.";
        }

        // Validar tercero
        $tercero = null;
        if($request->has('tercero_nit')) {
            $tercero = Tercero::where('tercero_nit', $request->tercero_nit)->first();
        }

        if(!$tercero instanceof Tercero) {
            return "No es posible recuperar beneficiario {$request->tercero_nit}, por favor verifique la información del asiento o consulte al administrador.";
        }

        // Validar centro de costo
        $centrocosto = null;
        if($request->has('asiento2_centro')) {
            $centrocosto = CentroCosto::find($request->asiento2_centro);
            if(!$centrocosto instanceof CentroCosto) {
                return "No es posible recuperar centro de costo, por favor verifique la información del asiento o consulte al administrador.";
            }
        }

        // Validar valor
        if(!$request->has('asiento2_valor') || !is_numeric($request->asiento2_valor) || $request->asiento2_valor <= 0) {
            return "Valor no puede ser menor o igual a 0, por favor verifique la información del asiento o consulte al administrador";
        }

        return 'OK';
    }

    public static function validarOrdenp(Request $request)
    {
        // Validate centro costo
        if($request->has('asiento2_centro')) {
            $centrocosto = CentroCosto::find($request->asiento2_centro);
            if(!$centrocosto instanceof CentroCosto || $centrocosto->centrocosto_codigo != 'OP') {
                return 'Para asociar orden de producción a ítem asiento se requiere centro costo OP, por favor verifique la información del asiento o consulte al administrador.';
            }
        }

        // Validate orden
        $ordenp = null;
        if($request->has('asiento2_orden')) {
            $ordenp = Ordenp::whereRaw("CONCAT(orden_numero,'-',SUBSTRING(orden_ano, -2)) = '{$request->asiento2_orden}'")->first();
        }
        if(!$ordenp instanceof Ordenp) {
            return 'No es posible recuperar orden de producción, por favor verifique la información o consulte al administrador.';
        }

        return 'OK';
    }

    public static function validarFacturap(Request $request)
    {
        // Recuperar tercero
        $tercero = null;
        if($request->has('tercero_nit')) {
            // Recuperar tercero
            $tercero = Tercero::where('tercero_nit', $request->tercero_nit)->first();
            if(!$tercero instanceof Tercero) {
                return "No es posible recuperar beneficiario, por favor verifique la información del asiento o consulte al administrador.";
            }
        }

        if(!$tercero instanceof Tercero) {
            return "No es posible recuperar beneficiario, por favor verifique la información del asiento o consulte al administrador.";
        }

        // Recuperar factura
        $facturap = Facturap::where('facturap1_factura', $request->facturap1_factura)->where('facturap1_tercero', $tercero->id)->first();
        // Validar naturaleza
        if($request->asiento2_naturaleza == 'D') {
            if(!$facturap instanceof Facturap) {
                return "Para realizar movimientos de naturaleza débito de ingresar un numero de factura existente.";
            }
        }

        if($facturap instanceof Facturap) {
            // En caso de existir factura se afectan cuotas
            $cuotas = Facturap2::where('facturap2_factura', $facturap->id)->get();
            if($cuotas->count() <= 0) {
                return "No es posible recuperar cuotas para la factura {$facturap->facturap1_factura}, por favor verifique la información del asiento o consulte al administrador.";
            }

            // Validar valor distribucion cuotas
            $suma_valor = 0;
            foreach ($cuotas as $cuota) {
                if($request->has("movimiento_valor_{$cuota->id}")) {
                    $suma_valor += $request->get("movimiento_valor_{$cuota->id}");
                }
            }
            if($suma_valor != $request->asiento2_valor) {
                return "Las suma de los valores debe ser igual al valor del item del asiento: valor {$request->asiento2_valor}, suma $suma_valor, diferencia ".abs($request->asiento2_valor - $suma_valor);
            }
        }else{
            // Validar sucursal
            if(!isset($request->facturap1_sucursal) || !is_numeric($request->facturap1_sucursal) || $request->facturap1_sucursal <= 0) {
                return "No es posible recuperar sucursal, por favor verifique la información del asiento o consulte al administrador.";
            }

            // Validar fecha
            if(!isset($request->facturap1_vencimiento) || trim($request->facturap1_vencimiento) == '') {
                return "Fecha vencimiento es obligatoria.";
            }

            // Validar periodo
            if(!isset($request->facturap1_periodicidad) || !is_numeric($request->facturap1_periodicidad) || $request->facturap1_periodicidad <= 0) {
                return "Periodicidad (días) para cuotas no puede ser menor o igual a 0.";
            }
        }
        return 'OK';
    }

    public static function validarFactura(Request $request)
    {
        // Validate factura
        $factura = null;

        // Recuperar factura1 -> Padre
        $factura = Factura1::find($request->factura1_orden);
        if(!$factura instanceof Factura1){
            return "No es posible recuperar la factura, por favor verifique la información o consulte al administrador.";
        }

        // Variable sumatoria
        $costo = 0;

        // Recuperar Factura4 -> Hijo
        $factura4 = Factura4::where('factura4_factura1', $factura->id)->get();
        foreach ($factura4 as $item) {
            $costo += $request->get("factura4_pagar_{$item->id}");
        }

        // Validar Cantidad
        if ($costo == 0 ) {
            return "El valor a pagar debe ser diferente a 0.";
        }

        return 'OK';
    }

    public static function validarInventario(Request $request)
    {
        // Prepare response
        $response = new \stdClass();
        $response->success = false;

        // Validar producto
        $producto = null;
        if($request->has('producto_codigo')) {
            $producto = Producto::where('producto_codigo', $request->producto_codigo)->first();
        }
        if(!$producto instanceof Producto) {
            $response->errors = "No es posible recuperar producto, por favor verifique la información del asiento o consulte al administrador.";
            return $response;
        }

        // Validar sucursal
        if(!isset($request->movimiento_sucursal) || !is_numeric($request->movimiento_sucursal) || $request->movimiento_sucursal <= 0) {
            $response->errors = "No es posible recuperar sucursal, por favor verifique la información del asiento o consulte al administrador.";
            return $response;
        }

        // Validar unidades
        if(!isset($request->movimiento_cantidad) || !is_numeric($request->movimiento_cantidad) || $request->movimiento_cantidad <= 0) {
            $response->errors = "El numero de unidades debe ser mayor a cero, por favor verifique la información del asiento o consulte al administrador.";
            return $response;
        }

        if($producto->producto_unidades == false) {
            // Producto que no manejan unidades
            $response->errors = "No es posible realizar movimientos para productos que no manejan unidades, por favor verifique la información del asiento o consulte al administrador.";
            return $response;
        }

        if ($producto->producto_metrado == true) {
            // Producto metrado
            if($request->asiento2_naturaleza == 'D') {
                for ($item = 1; $item <= $request->movimiento_cantidad; $item++) {
                    if(!$request->has("itemrollo_metros_$item") || $request->get("itemrollo_metros_$item") <=0) {
                        $response->errors = "Por favor ingrese valor en metros para el item rollo $item, debe ser mayor a 0.";
                        return $response;
                    }
                }
            }else {
                $items = ProdbodeRollo::where('prodboderollo_producto', $producto->id)->where('prodboderollo_sucursal', $request->movimiento_sucursal)->get();

                $chosen = 0;
                $costo = 0;
                foreach ($items as $item) {

                    // Validar items ingresados
                    if($request->has("itemrollo_metros_{$item->id}") && $request->get("itemrollo_metros_{$item->id}") > 0 && $request->get("itemrollo_metros_{$item->id}") != '') {
                        // Validar cantidad
                        if($request->get("itemrollo_metros_{$item->id}") > $item->prodboderollo_saldo) {
                            $response->errors = "Metros debe ser menor o igual a {$item->prodboderollo_saldo}, para el item rollo {$item->prodboderollo_item}.";
                            return $response;
                        }
                        $chosen++;
                    }

                    // Maximo numero items
                    if($chosen > $request->movimiento_cantidad) {
                        $response->errors = "Por favor ingrese metros unicamente para {$request->movimiento_cantidad} items.";
                        return $response;
                    }

                    $costo += $request->get("itemrollo_metros_{$item->id}") * $item->prodboderollo_costo;
                }

                // Minimo numero items
                if($chosen < $request->movimiento_cantidad) {
                    $response->errors = "Por favor ingrese metros para {$request->movimiento_cantidad} items.";
                    return $response;
                }
                // Costo salida
                $response->asiento2_valor = $costo;
            }

        }elseif ($producto->producto_serie == true) {
            // Producto serie
            if($request->asiento2_naturaleza == 'D') {
                $series = [];
                for ($item = 1; $item <= $request->movimiento_cantidad; $item++) {
                    if(!$request->has("producto_serie_$item") || $request->get("producto_serie_$item") == '') {
                        $response->errors = "Por favor ingrese serie para el item $item.";
                        return $response;
                    }

                    // Validar series ingresadas repetidas
                    if(in_array($request->get("producto_serie_$item"), $series)){
                        $response->errors = "No es posible registrar dos números de serie iguales";
                        return $response;
                    }

                    // Validar serie
                    $serie = Producto::where('producto_codigo', $request->get("producto_serie_$item"))->first();
                    if($serie instanceof Producto) {
                        // Si ya existe serie validamos prodbode en cualquier sucursal, serie unica
                        $existencias = DB::table('prodbode')->where('prodbode_producto', $serie->id)->sum('prodbode_cantidad');
                        if($existencias > 0) {
                            $response->errors = "Ya existe un producto con este número de serie {$serie->producto_codigo}.";
                            return $response;
                        }
                    }

                    $series[] = $request->get("producto_serie_$item");
                }
            }else{
                // Recuperar prodbode
                $prodbode = Prodbode::prodbode($producto, $request->movimiento_sucursal);
                if(!$prodbode instanceof Prodbode || $request->movimiento_cantidad > $prodbode->disponibles) {
                    $response->errors = "No existen suficientes unidades para salida, unidades disponibles ".($prodbode instanceof Prodbode ? $prodbode->prodbode_cantidad  : 0).", por favor verifique la información o consulte al administrador.";
                    return $response;
                }

                // Costo salida
                $costo = Inventario::primerasEnSalir($producto, $request->movimiento_sucursal, $request->movimiento_cantidad);
                if(!is_numeric($costo)) {
                    $response->errors = $costo;
                    return $response;
                }
            }
        }elseif($producto->producto_unidades == true) {
            // Producto normal
            if($request->asiento2_naturaleza == 'C') {
                // Recuperar prodbode
                $prodbode = Prodbode::prodbode($producto, $request->movimiento_sucursal);
                if(!$prodbode instanceof Prodbode || $request->movimiento_cantidad > $prodbode->disponibles) {
                    $response->errors = "No existen suficientes unidades para salida, unidades disponibles ".($prodbode instanceof Prodbode ? $prodbode->prodbode_cantidad  : 0).", por favor verifique la información o consulte al administrador.";
                    return $response;
                }

                // Costo salida
                $costo = Inventario::primerasEnSalir($producto, $request->movimiento_sucursal, $request->movimiento_cantidad);
                if(!is_numeric($costo)) {
                    $response->errors = $costo;
                    return $response;
                }
                $response->asiento2_valor = $costo;
            }
        }

        $response->success = true;
        return $response;
    }

    public function movimiento(Request $request)
    {
        $response = new \stdClass();
        $response->success = false;

        // Recuperar cuenta
        $objCuenta = PlanCuenta::where('plancuentas_cuenta', $request->plancuentas_cuenta)->first();
        if(!$objCuenta instanceof PlanCuenta) {
            $response->error = 'No es posible recuperar cuenta, por favor verifique la información del asiento o consulte al administrador.';
            return $response;
        }
        if($objCuenta->plancuentas_tipo == 'P')
        {
            // Preparar movimiento Facturap
            $datamov = [];
            $datamov['Tipo'] = 'FP';
            $datamov['Naturaleza'] = $request->asiento2_naturaleza;
            $datamov['Factura'] = $request->facturap1_factura;

            // Recuperar factura
            $facturap = Facturap1::where('facturap1_factura', $request->facturap1_factura)->where('facturap1_tercero', $this->asiento2_beneficiario)->first();
            if($facturap instanceof Facturap1) {
                // En caso de existir factura se afectan cuotas
                $cuotas = Facturap2::where('facturap2_factura', $facturap->id)->get();
                if($cuotas->count() <= 0) {
                    $response->error = "No es posible recuperar cuotas para la factura {$facturap->facturap1_factura}, por favor verifique la información del asiento o consulte al administrador.";
                    return $response;
                }

                // Validar valor distribucion cuotas
                $suma_valor = 0;
                foreach ($cuotas as $cuota) {
                    if($request->has("movimiento_valor_{$cuota->id}")) {
                        $suma_valor += $request->get("movimiento_valor_{$cuota->id}");
                    }
                }
                if($suma_valor != $request->asiento2_valor) {
                    $response->error = "Las suma de los valores debe ser igual al valor del item del asiento: valor {$request->asiento2_valor}, suma $suma_valor, diferencia ".abs($request->asiento2_valor - $suma_valor);
                    return $response;
                }

                // Insertar movimientos
                foreach ($cuotas as $cuota)
                {
                    if($request->has("movimiento_valor_{$cuota->id}"))
                    {
                        $datamov['Cuotas'] = $cuota->id;
                        $datamov['Valor'] = $request->get("movimiento_valor_{$cuota->id}");
                        $datamov['Nuevo'] = false;

                        $movimiento = new AsientoMovimiento;
                        $result = $movimiento->store($this, $datamov);
                        if(!$result->success) {
                            $response->error = $result->error;
                            return $response;
                        }
                    }
                }

            }else{
                // En caso no existir factura se crea
                $datamov['Nuevo'] = true;
                $datamov['Valor'] = $request->asiento2_valor;
                $datamov['Sucursal'] = $request->facturap1_sucursal;
                $datamov['Fecha'] = $request->facturap1_vencimiento;
                $datamov['Cuotas'] = $request->facturap1_cuotas;
                $datamov['Periodicidad'] = $request->facturap1_periodicidad;
                $datamov['Detalle'] = $request->facturap1_observaciones;

                $movimiento = new AsientoMovimiento;
                $result = $movimiento->store($this, $datamov);
                if(!$result->success) {
                    $response->error = $result->error;
                    return $response;
                }
            }

        }elseif ($objCuenta->plancuentas_tipo == 'I') {

            // Validar producto
            $producto = null;
            if($request->has('producto_codigo')) {
                $producto = Producto::where('producto_codigo', $request->producto_codigo)->first();
            }
            if(!$producto instanceof Producto) {
                $response->error = "No es posible recuperar producto, por favor verifique la información del asiento o consulte al administrador.";
                return $response;
            }

            // Preparar movimiento padre
            $datamov = [];
            $datamov['Tipo'] = 'IP';
            $datamov['Naturaleza'] = $request->asiento2_naturaleza;
            $datamov['Sucursal'] = $request->movimiento_sucursal;
            $datamov['Producto'] = $producto->id;
            $datamov['Valor'] = $request->movimiento_cantidad;

            $movimiento = new AsientoMovimiento;
            $result = $movimiento->store($this, $datamov);
            if(!$result->success) {
                $response->error = $result->error;
                return $response;
            }

            // Preparar movimientos hijos
            $datamov = [];
            $datamov['Tipo'] = 'IH';
            if ($producto->producto_metrado == true) {
                // Producto metrado
                // Debito
                if($request->asiento2_naturaleza == 'D') {
                    for ($item = 1; $item <= $request->movimiento_cantidad; $item++) {
                        if(!$request->has("itemrollo_metros_$item") || $request->get("itemrollo_metros_$item") <=0) {
                            $response->error = "Por favor ingrese valor en metros para el item rollo $item, debe ser mayor a 0.";
                            return $response;
                        }
                        $datamov['Item'] = $item;
                        $datamov['Valor'] = $request->get("itemrollo_metros_$item");

                        $movimiento = new AsientoMovimiento;
                        $result = $movimiento->store($this, $datamov);
                        if(!$result->success) {
                            $response->error = $result->error;
                            return $response;
                        }
                    }
                // Credito
                }else{
                    $items = ProdbodeRollo::where('prodboderollo_producto', $producto->id)->where('prodboderollo_sucursal', $request->movimiento_sucursal)->get();
                    // $chosen = 0;
                    foreach ($items as $item) {

                        // Validar items ingresados
                        if($request->has("itemrollo_metros_{$item->id}") && $request->get("itemrollo_metros_{$item->id}") > 0 && $request->get("itemrollo_metros_{$item->id}") != '') {
                            $datamov['Item'] = $item->prodboderollo_item;
                            $datamov['Valor'] = $request->get("itemrollo_metros_{$item->id}");

                            $movimiento = new AsientoMovimiento;
                            $result = $movimiento->store($this, $datamov);
                            if(!$result->success) {
                                $response->error = $result->error;
                                return $response;
                            }
                        }
                    }
                }

            }elseif ($producto->producto_serie == true) {
                // Producto serie
                // Debito
                if($request->asiento2_naturaleza == 'D') {
                    for ($item = 1; $item <= $request->movimiento_cantidad; $item++) {
                        if(!$request->has("producto_serie_$item") || $request->get("producto_serie_$item") == '') {
                            $response->error = "Por favor ingrese serie para el item $item";
                            return $response;
                        }

                        $datamov['Item'] = $item;
                        $datamov['Serie'] = $request->get("producto_serie_$item");

                        $movimiento = new AsientoMovimiento;
                        $result = $movimiento->store($this, $datamov);
                        if(!$result->success) {
                            $response->error = $result->error;
                            return $response;
                        }
                    }
                }
            }
        }elseif ($objCuenta->plancuentas_tipo == 'C') {
            // Preparar movimiento Factura
            $datamov = [];
            $datamov['Tipo'] = 'F';
            $datamov['Naturaleza'] = $request->asiento2_naturaleza;
            $datamov['Nuevo'] = false;
            $datamov['Factura'] = $request->factura1_orden;
            $datamov['Valor'] = $request->factura1_pagar;

            $movimiento = new AsientoMovimiento;
            $result = $movimiento->store($this, $datamov);
            if(!$result->success) {
                $response->error = $result->error;
                return $response;
            }
        }

        $response->success = true;
        return $response;
    }

    public function movimientos()
    {
        // Actualizar facturap
        if($this->plancuentas_tipo && $this->plancuentas_tipo == 'P')
        {
            $result = $this->storeFacturap();
            if($result != 'OK') {
                return $result;
            }
        }else if($this->plancuentas_tipo && $this->plancuentas_tipo == 'I') {

            $result = $this->storeInventario();
            if($result != 'OK') {
                return $result;
            }
        }else if($this->plancuentas_tipo && $this->plancuentas_tipo == 'C') {

            $result = $this->storeFactura();
            if($result != 'OK') {
                return $result;
            }
        }
        return 'OK';
    }

    public function storeFacturap()
    {
        return 'OK';
    }

    public function storeInventario()
    {


        // Valor
        $costo = 0;
        // Actualizar prodbode producto padre (Maneja unidades o Producto metrado)
        if($producto->producto_unidades == true || ($producto->producto_unidades == true && $producto->producto_metrado == true))
        {
            #Code ...
        }

        // Validar movimientos (Maneja serie o Producto metrado)
        if ($producto->producto_metrado == true || $producto->producto_serie == true) {
            #Cide ..
        }

        if ($producto->producto_metrado == true) {
            // Producto metrado
            // Debito
            if($this->asiento2_naturaleza == 'D') {

            // Credito
            }else{
                #Code ..
            }
        } elseif ($producto->producto_serie == true) {
            #Code ..
        }

        return "OK";
    }

    public function storeFactura(){
        // Recuperar movimientos
        $movements = AsientoMovimiento::where('movimiento_asiento2', $this->id)->whereIn('movimiento_tipo', ['F', 'FH'])->get();
        if ($movements->count() <= 0) {
            return "No es posible recuperar movimientos de factura para la cuenta {$this->plancuentas_cuenta} y tercero {$this->tercero_nit}, id {$this->id}, por favor verifique la información del asiento o consulte al administrador.";
        }

        $movfather = $movements->where('movimiento_tipo', 'F')->first();
        if(!$movfather instanceof AsientoMovimiento) {
            return "No es posible recuperar movimiento padre de factura para la cuenta {$this->plancuentas_cuenta} y tercero {$this->tercero_nit}, id {$this->id}, por favor verifique la información del asiento o consulte al administrador.";
        }
        return 'OK';
    }
}
