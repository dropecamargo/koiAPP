<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Base\Empresa, App\Models\Cierre\Cartera, App\Models\Cierre\Inventario, App\Models\Cierre\Activo, App\Models\Cierre\Proveedor;
use Log, DB;

class CierresKoiApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cierres:koiapp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para generar cierres de cartera, inventario, activos y proveedores.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Fechas actual cierre anocierre mescierre
        $this->fechaactual = date("Y-m-d");
        $this->fechacierre = date("Y-m-d", strtotime("last day of this month"));
        $this->anocierre = date('Y');
        $this->mescierre = date('m');

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::info('Se esta generando la rutina de cierres koi.');

        $empresa = Empresa::getEmpresa();
        if( !$empresa instanceof Empresa ){
            Log::error('No es posible recuperar la empresa, por favor verifique la información o consulte al administrador.');
            return;
        }

        // // Validacion fecha cierre
        // if( $fechactual > $empresa->empresa_fecha_cierre ){
        //     $nextfechacierre = date("Y-m-d", strtotime("last day of next month"));
        //
        //     // Actualizar fecha_cierre
        //     $empresa->empresa_fecha_cierre = $nextfechacierre;
        //     $empresa->save();
        //
        //     Log::info('Se actualizo la fecha de cierre.');
        //     return;
        // }

        DB::beginTransaction();
        try {
            $cierrecartera = $this->cierrecartera();
            if( $cierrecartera != 'OK' ){
                throw new \Exception('No es posible generar cierres de cartera.');
            }
            Log::info('Se realizo el cierre de cartera con exito.');

            $cierreinventario = $this->cierreinventario();
            if( $cierreinventario != 'OK' ){
                throw new \Exception('No es posible generar cierres de inventario.');
            }
            Log::info('Se realizo el cierre de inventario con exito.');

            $cierreactivos = $this->cierreactivos();
            if( $cierreactivos != 'OK' ){
                throw new \Exception('No es posible generar cierres de activos.');
            }
            Log::info('Se realizo el cierre de activos con exito.');

            $cierreproveedores = $this->cierreproveedores();
            if( $cierreproveedores != 'OK' ){
                throw new \Exception('No es posible generar cierres de proveedores.');
            }
            Log::info('Se realizo el cierre de proveedores con exito.');

            DB::commit();
            Log::info('Se completo la rutina de cierres con exito.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
        }
    }

    public function cierrecartera()
    {
        Log::info('Cierre de cartera.');

        // Prepara sql para cierrecartera
        $sql="
            (
                SELECT factura1_tercero AS tercero, factura3_vencimiento AS vencimiento, factura3_valor AS valor, factura3_saldo AS saldo, factura1_documentos AS documentos, factura3.id AS documentos_id, factura1_fecha AS expedicion
                FROM factura3
                INNER JOIN factura1 ON factura3_factura1 = factura1.id
                WHERE factura3_saldo <> 0
            )UNION(
                SELECT anticipo1_tercero AS tercero, anticipo1_fecha AS vencimiento, (anticipo1_valor * -1) AS valor, (anticipo1_saldo * -1) AS saldo, anticipo1_documentos AS documentos, anticipo1.id AS documentos_id, anticipo1_fecha AS expedicion
                FROM anticipo1
                WHERE anticipo1_saldo <> 0
            )UNION(
                SELECT chdevuelto_tercero AS tercero, chdevuelto_fecha AS vencimiento, chdevuelto_valor AS valor, chdevuelto_saldo AS saldo, chdevuelto_documentos AS documentos, chdevuelto.id AS documentos_id, chdevuelto_fecha AS expedicion
                FROM chdevuelto
                WHERE chdevuelto_saldo <> 0
            )";
        $cierrecartera = DB::select($sql);

        // Generar cierrecartera
        foreach($cierrecartera as $cartera) {
            $cierrecartera = new Cartera;
            $cierrecartera->cierrecartera_mes = $this->mescierre;
            $cierrecartera->cierrecartera_ano = $this->anocierre;
            $cierrecartera->cierrecartera_tercero = $cartera->tercero;
            $cierrecartera->cierrecartera_documentos = $cartera->documentos;
            $cierrecartera->cierrecartera_id = $cartera->documentos_id;
            $cierrecartera->cierrecartera_expedicion = $cartera->expedicion;
            $cierrecartera->cierrecartera_vencimiento = $cartera->vencimiento;
            $cierrecartera->cierrecartera_corte = $this->fechacierre;
            $cierrecartera->cierrecartera_valor = $cartera->valor;
            $cierrecartera->cierrecartera_saldo = $cartera->saldo;
            $cierrecartera->cierrecartera_fh_elaboro = date('Y-m-d H:m:s');
            $cierrecartera->save();
        }

        return 'OK';
    }

    public function cierreinventario()
    {
        Log::info('Cierre de inventario.');

        // Preparar sql para cierreinventario
        $sql="
            (
                SELECT prodbode_serie AS producto, prodbode_sucursal AS sucursal, prodbode_cantidad AS cantidad, prodbode_metros AS metros, producto_costo AS costo
                FROM prodbode
                INNER JOIN producto ON prodbode_serie = producto.id
                WHERE prodbode_cantidad <> 0
            )";
        $cierreinventario = DB::select($sql);

        // Generar CierreInventario
        foreach($cierreinventario as $inventario) {
            $cierreinventario = new Inventario;
            $cierreinventario->cierreinventario_mes = $this->mescierre;
            $cierreinventario->cierreinventario_ano = $this->anocierre;
            $cierreinventario->cierreinventario_producto = $inventario->producto;
            $cierreinventario->cierreinventario_sucursal = $inventario->sucursal;
            $cierreinventario->cierreinventario_cantidad = $inventario->cantidad;
            $cierreinventario->cierreinventario_metros = $inventario->metros;
            $cierreinventario->cierreinventario_corte = $this->fechacierre;
            $cierreinventario->cierreinventario_costo = $inventario->costo;
            $cierreinventario->cierreinventario_fh_elaboro = date('Y-m-d H:m:s');
            $cierreinventario->save();
        }

        return 'OK';
    }

    public function cierreactivos()
    {
        Log::info('Cierre de activos.');

        // Preparar sql para cierreactivos
        $sql="
            (
                SELECT activofijo.id AS activofijo, activofijo_tipoactivo AS tipoactivo, activofijo_responsable AS responsable, activofijo_costo AS costo, activofijo_depreciacion AS depreciacion
                FROM activofijo
            )";
        $cierreactivo = DB::select($sql);

        // Crear cierrecartera
        foreach($cierreactivo as $activo) {
            $cierreactivo = new Activo;
            $cierreactivo->cierreactivo_mes = $this->mescierre;
            $cierreactivo->cierreactivo_ano = $this->anocierre;
            $cierreactivo->cierreactivo_activofijo = $activo->activofijo;
            $cierreactivo->cierreactivo_tipoactivo = $activo->tipoactivo;
            $cierreactivo->cierreactivo_responsable = $activo->responsable;
            $cierreactivo->cierreactivo_costo = $activo->costo;
            $cierreactivo->cierreactivo_depreciacion = $activo->depreciacion;
            $cierreactivo->cierreactivo_corte = $this->fechacierre;
            $cierreactivo->cierreactivo_fh_elaboro = date('Y-m-d H:m:s');
            $cierreactivo->save();
        }

        return 'OK';
    }

    public function cierreproveedores()
    {
        Log::info('Cierre de proveedores.');

        // Preparar sql para cierreproveedores
        $sql="
            (
                SELECT facturap1_tercero AS tercero, facturap1_documentos AS documento, facturap3.id AS documento_id, facturap1_fecha AS expedicion, facturap3_vencimiento AS vencimiento, facturap3_valor AS valor, facturap3_saldo AS saldo
                FROM facturap3
                INNER JOIN facturap1 ON facturap3_facturap1 = facturap1.id
            )";
        $cierreproveedores = DB::select($sql);

        // Generar cierreproveedor
        foreach($cierreproveedores as $proveedor) {
            $cierreproveedores = new Proveedor;
            $cierreproveedores->cierreproveedor_mes = $this->mescierre;
            $cierreproveedores->cierreproveedor_ano = $this->anocierre;
            $cierreproveedores->cierreproveedor_tercero = $proveedor->tercero;
            $cierreproveedores->cierreproveedor_documentos = $proveedor->documento;
            $cierreproveedores->cierreproveedor_id = $proveedor->documento_id;
            $cierreproveedores->cierreproveedor_expedicion = $proveedor->expedicion;
            $cierreproveedores->cierreproveedor_vencimiento = $proveedor->vencimiento;
            $cierreproveedores->cierreproveedor_corte = $this->fechacierre;
            $cierreproveedores->cierreproveedor_valor = $proveedor->valor;
            $cierreproveedores->cierreproveedor_saldo = $proveedor->saldo;
            $cierreproveedores->cierreproveedor_fh_elaboro = date('Y-m-d H:m:s');
            $cierreproveedores->save();
        }

        return 'OK';
    }
}
