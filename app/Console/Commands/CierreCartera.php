<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Base\Empresa, App\Models\Cierre\Cartera;
use Log, DB;

class CierreCartera extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cierre:cartera';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para cierre de cartera.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::info('Se esta generando la rutina cierre de cartera.');

        $empresa = Empresa::getEmpresa();
        if( !$empresa instanceof Empresa ){
            $this->error('No es posible recuperar la empresa, por favor verifique la información o consulte al administrador.');
            return;
        }

        // Validacion fecha cierre
        $fechacierre = date("Y-m-d");
        if( $fechacierre > $empresa->empresa_fecha_cierre ){
            $nextfechacierre = date("Y-m-d", strtotime("last day of next month"));

            // Actualizar fecha_cierre
            $empresa->empresa_fecha_cierre = $nextfechacierre;
            $empresa->save();

            Log::info('Se actualizo la fecha de cierre.');
            return;
        }

        DB::beginTransaction();
        try{
            // Fechas inicio y fin filtros 1° parte
            $anocierre = date('Y');
            $mescierre = date('m');

            // Recuperar factura3 para ingresar a CierreCartera
            $union="
                (
                    SELECT factura1_tercero AS tercero, factura3_vencimiento AS vencimiento, factura3_valor AS valor, factura3_saldo AS saldo, factura1_documentos AS documentos, factura3.id AS documentos_id, factura1_fecha AS expedicion
                    FROM factura3
                    INNER JOIN factura1 ON factura3_factura1 = factura1.id
                    WHERE factura3_saldo <> 0
                )UNION(
                    SELECT anticipo1_tercero AS tercero, anticipo1_fecha AS vencimiento, anticipo1_valor AS valor, anticipo1_saldo AS saldo, anticipo1_documentos AS documentos, anticipo1.id AS documentos_id, anticipo1_fecha AS expedicion
                    FROM anticipo1
                    WHERE anticipo1_saldo <> 0
                )UNION(
                    SELECT chdevuelto_tercero AS tercero, chdevuelto_fecha AS vencimiento, chdevuelto_valor AS valor, chdevuelto_saldo AS saldo, chdevuelto_documentos AS documentos, chdevuelto.id AS documentos_id, chdevuelto_fecha AS expedicion
                    FROM chdevuelto
                    WHERE chdevuelto_saldo <> 0
                )";
            $cierrecartera = DB::select($union);

            // Crear cierrecartera
            foreach($cierrecartera as $cartera) {
                $cierrecartera = new Cartera;
                $cierrecartera->cierrecartera_mes = $mescierre;
                $cierrecartera->cierrecartera_ano = $anocierre;
                $cierrecartera->cierrecartera_tercero = $cartera->tercero;
                $cierrecartera->cierrecartera_documentos = $cartera->documentos;
                $cierrecartera->cierrecartera_id = $cartera->documentos_id;
                $cierrecartera->cierrecartera_expedicion = $cartera->expedicion;
                $cierrecartera->cierrecartera_vencimiento = $cartera->vencimiento;
                $cierrecartera->cierrecartera_corte = $fechacierre;
                $cierrecartera->cierrecartera_valor = $cartera->valor;
                $cierrecartera->cierrecartera_saldo = $cartera->saldo;
                $cierrecartera->cierrecartera_fh_elaboro = date('Y-m-d H:m:s');
                $cierrecartera->save();
            }

            DB::commit();
            Log::info('Se completo la rutina cierre de cartera con exito.');
            $this->info('Se completo la rutina cierre de cartera con exito.');
        }catch(\Exception $e){
            DB::rollback();
            Log::error($e->getMessage());
            $this->error('No se pudo ejecutar la rutina con exito.');
        }
    }
}
