<?php
/**
* Class Exṕort factura
* Clase realizada para un formato determinado
* se realizo en base a las coordenadas que
* existen en un papel tamaño carta estas estan dadas en mm
**/
namespace App\Classes\Exports\Factura;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\Base\Empresa;
use App\Models\Cartera\Factura4;
use Auth;

class FacturaExport extends FPDF
{
    /* Attributes */
    private $empresa;
    private $title;
    private $factura;
    private $detalle;

    /* Constructor Report */
    function buldReport($factura, $detalle, $title)
    {
        $this->empresa = Empresa::getEmpresa();
        $this->title = $title;
        $this->factura = $factura;
        $this->detalle = $detalle;

        $this->SetMargins(10,10,10);
        $this->SetTitle($this->title, true);
        $this->AliasNbPages();
        $this->AddPage();
        $this->bodyTable();
    }

    /* Header Paper*/
    function Header()
    {
        $this->Image(asset(env('APP_IMAGE')), 20, 15, -150 );

        $this->SetFont('Arial','B',11);
        $this->SetX(60);
        $this->Cell(140,5,utf8_decode($this->empresa->tercero_razonsocial), 0, 2,'C');
        $this->Cell(140,5,sprintf('NIT: %s - %s',$this->empresa->tercero_nit, $this->empresa->tercero_digito),0,2,'C');

        $this->SetFont('Arial','',7);
        $this->SetX(90);
        $this->MultiCell(80,3,utf8_decode($this->factura->puntoventa_encabezado), 0, 'C', false);
        $this->Ln(2);

        $this->SetFont('Arial','B',11);
        $this->SetX(60);
        $this->Cell(140,5,$this->factura->puntoventa_frase,0, 0, 'C');
        $this->Ln(10);

        $this->SetFont('Arial','B',8);
        $this->Cell(35, 6, utf8_decode('Fecha de facturación'), 'LTB' );
        $this->SetFont('Arial','',8);
        $this->Cell(25, 6, $this->factura->factura1_fecha, 'TB');
        $this->SetFont('Arial','B',8);
        $this->Cell(35, 6, utf8_decode('Fecha de vencimiento'), 'TB');
        $this->SetFont('Arial','',8);
        $this->Cell(25, 6, $this->factura->factura1_fecha, 'TB');
        $this->SetFont('Arial','B', 9);
        $this->Cell(45, 6, utf8_decode('FACTURA DE VENTA N°'), 'TB');
        $this->SetFont('Arial','',8);
        $this->Cell(25, 6, $this->factura->factura1_numero, 'TBR', 1);

        $this->SetFont('Arial','B',8);
        $this->Cell(35, 6, utf8_decode('Señor(es)'), 'LB' );
        $this->SetFont('Arial','',8);
        $this->Cell(85, 6, $this->factura->tercero_nombre, 'B');
        $this->SetFont('Arial','B',8);
        $this->Cell(15, 6, 'Nit', 'B');
        $this->SetFont('Arial','',8);
        $this->Cell(55, 6, sprintf('%s - %s',$this->factura->tercero_nit, $this->factura->tercero_digito), 'BR', 1 , 'L');

        $this->SetFont('Arial','B',8);
        $this->Cell(35, 6, utf8_decode('Dirección'), 'LB' );
        $this->SetFont('Arial','',8);
        $this->Cell(85, 6, $this->factura->tercero_direccion, 'B');
        $this->SetFont('Arial','B',8);
        $this->Cell(15, 6, 'Tel', 'B');
        $this->SetFont('Arial','',8);

        $tel = '';
        if( !empty($this->factura->tercero_telefono1) ){
            $tel = $this->factura->tercero_telefono1;
        }elseif ( !empty($this->factura->tercero_telefono2) ){
            $tel = $this->factura->tercero_telefono2;
        }elseif ( !empty($this->factura->tercero_celular) ){
            $tel = $this->factura->tercero_celular;
        }
        $this->Cell(55, 6, $tel, 'BR', 1 , 'L');

        $this->SetFont('Arial','',8);
        $this->Cell(190, 6, utf8_decode($this->factura->puntoventa_resolucion_dian), 'LBR' );
        $this->Ln(8);
    }

    /* Header Table */
    function headerTable()
    {
        $this->SetFont('Arial','B',8);
        $this->Cell(20, 6, 'CANT', 1 ,0, 'C' );
        $this->Cell(100, 6, utf8_decode('DESCRIPCIÓN'), 1, 0, 'C' );
        $this->Cell(35, 6, 'VR. UNITARIO', 1, 0, 'C' );
        $this->Cell(35, 6, 'TOTAL', 1, 1, 'C');
    }

    /* Data Body Table */
    function bodyTable()
    {
        $this->headerTable();
        $this->SetFillColor(247,247,247);
        $this->SetFont('Arial','',8);

        foreach ($this->detalle as $item) {
            $this->Cell(20,6,$item->factura2_cantidad,1,0,'C','');
            $this->Cell(100,6,"$item->producto_serie - $item->producto_nombre", 1, 0,'', '');
            $this->Cell(35,6,number_format($item->factura2_costo,2,',','.'), 1, 0, 'C', '');
            $this->Cell(35,6,number_format($item->factura2_costo * $item->factura2_cantidad,2,',','.'), 1, 0,'C','');
            $this->Ln();

            foreach(Factura4::getComments($item->id) as $value) {
                $this->Cell(20,6,'',1,0,'C','');
                $this->Cell(100,6,"     $value->factura4_comment", 1, 0,'', '');
                $this->Cell(35,6,'', 1, 0, 'C', '');
                $this->Cell(35,6,'', 1, 0,'C','');
                $this->Ln();
            }
            // foreach(Factura4::getComments($item->id) as $value) {
            //     $this->Cell(20,6,'',1,0,'C','');
            //     $this->Cell(100,6,"     $value->factura4_comment", 1, 0,'', '');
            //     $this->Cell(35,6,'', 1, 0, 'C', '');
            //     $this->Cell(35,6,'', 1, 0,'C','');
            //     $this->Ln();
            // }
        }
        $this->getRenglon();
        $this->footerTable();
    }
    /* Renglones en blanco */
    function getRenglon(){
        while ($this->GetY() < 183 ) {
            $this->Cell(20,6,'',1,0,'C','');
            $this->Cell(100,6,'', 1, 0,'', '');
            $this->Cell(35,6,'', 1, 0, 'C', '');
            $this->Cell(35,6,'', 1, 0,'C','');
            $this->Ln();
        }
    }
    /* Footer Table */
    function footerTable(){
        $this->SetFont('Arial','B',8);

        $this->Cell(120,24,\NumeroALetras::convertir($this->factura->factura1_total-$this->factura->factura1_retencion, 'pesos', 'centavos'), 1, 0, 'C');
        $this->Cell(35,6,'SUB-TOTAL', 1, 0, 'C');
        $this->Cell(35,6,number_format($this->factura->factura1_bruto,2,',','.'), 1, 1, 'C');

        $this->setX(130);
        $this->Cell(35,6,'IVA', 1, 0, 'C');
        $this->Cell(35,6,number_format($this->factura->factura1_iva,2,',','.'), 1, 1, 'C');

        $this->setX(130);
        $this->Cell(35,6,'RET/FUENTE', 1, 0, 'C');
        $this->Cell(35,6,number_format($this->factura->factura1_retencion,2,',','.'), 1, 1, 'C');

        $this->setX(130);
        $this->Cell(35,6,'TOTAL', 1, 0, 'C');
        $this->Cell(35,6,number_format($this->factura->factura1_total-$this->factura->factura1_retencion,2,',','.'), 1, 0, 'C');

        $this->Ln(8);
        $this->Cell(190,6,utf8_decode($this->factura->puntoventa_observacion), 1, 0, '');
        $this->Ln(8);

        // Permite manejar espacio de los cuadros de firmas
        if (279 - $this->GetY() < 60) {
            $this->AddPage();
        }

        //  Pie de firmas
        $y = $this->GetY();
        $this->Rect(10, $y, 95, 35, 'FD');
        $this->SetXY(10, $y);
        $this->SetFont('Arial','B',6);
        $this->MultiCell(95,3,utf8_decode($this->factura->puntoventa_footer1), 0, 'L', false);
        $this->Ln(20);
        $this->Cell(95,3,'__________________________________________________________', 0, 1, 'C');
        $this->Cell(95,3,utf8_decode('RECIBÓ A SATISFACCIÓN (FIRMA Y SELLO) FECHA'), 0, 0, 'C');

        $this->Rect(105, $y, 95, 35, 'FD');
        $this->SetXY(105, $y);
        $this->SetFont('Arial','B',6);
        $this->MultiCell(95,3,utf8_decode($this->factura->puntoventa_footer2), 0, 'L', false);
        $this->Ln(23);
        $this->Cell(280,3,'__________________________________________________________', 0, 1, 'C');
        $this->Cell(280,3,utf8_decode('FIRMA PROVEEDOR'), 0, 0, 'C');

    }

    /* Footer Paper */
    function Footer()
    {
        // Pie de pagina
        $this->SetFont('Arial','B',7);
        $this->SetY(-20);
        $this->Cell(190,3,utf8_decode($this->empresa->tercero_direccion), 0, 1, 'C');
        $this->Cell(190,3,utf8_decode($this->empresa->tercero_email), 0, 1, 'C');
        $user = utf8_decode(Auth::user()->username);
        $date = date('Y-m-d H:m:s');
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 6);
        $this->Cell(0, 10, utf8_decode('Pág ').$this->PageNo().'/{nb}', 0, 0, 'R');
    }
}
