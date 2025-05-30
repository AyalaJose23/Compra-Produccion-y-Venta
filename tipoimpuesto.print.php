<?php
include_once './tcpdf/tcpdf.php';
include_once 'clases/conexion.php';
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0,0, 'Pag. '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, 
                false, 'R', 0, '', 0, false, 'T', 'M');
    }
}
// create new PDF document // CODIFICACION POR DEFECTO ES UTF-8
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Antonio Portillo');
$pdf->SetTitle('REPORTE DE MARCA');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
$pdf->setPrintHeader(false);
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins POR DEFECTO
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetMargins(8,10, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks SALTO AUTOMATICO Y MARGEN INFERIOR
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


// ---------------------------------------------------------

// TIPO DE LETRA
$pdf->SetFont('times', 'B', 14);

// AGREGAR PAGINA
$pdf->AddPage('P','LEGAL');
$pdf->Cell(0,0,"REPORTE DE TIPO IMPUESTO",0,1,'C');
//SALTO DE LINEA
$pdf->Ln();
//COLOR DE TABLA
        $pdf->SetFillColor(255, 255, 255); //color de la tabla
        $pdf->SetTextColor(0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetLineWidth(0.2);
        
        $pdf->SetFont('', 'B',12);
        // Header        
        $pdf->SetFillColor(221, 221, 221); //color de fondo
        $pdf->Cell(30,5,'CODIGO', 1, 0, 'C', 1);
        $pdf->Cell(60,5,'DESCRIPCION', 1, 0, 'C', 1);
        $pdf->Cell(0,5,'PORCENTAJE', 1, 0, 'C', 1);
       // $pdf->Cell(40,5,'DIRECCION', 1, 0, 'C', 1);
        //$pdf->Cell(40,5,'TELEFONO', 1, 0, 'C', 1);
       
        $pdf->Ln();
        $pdf->SetFont('', '');
        $pdf->SetFillColor(255, 255, 255);
        if (!empty(isset($_REQUEST['vdesde']))&& !empty(isset($_REQUEST['vhasta']))) {
            if ($_REQUEST['opcion']=='1') {
                $impuestos = consultas::get_datos("select * from tipo_impuesto "
                        . "where tipo_cod between ".$_REQUEST['vdesde']." and "
                        .$_REQUEST['vhasta']." order by tipo_cod");
            } else {
               $impuestos = consultas::get_datos("select * from tipo_impuesto "
                        . "where tipo_descri between '".$_REQUEST['vdesde']."' and '"
                        .$_REQUEST['vhasta']."' order by tipo_descri");
            }
         } else {
            $impuestos = consultas::get_datos("select * from tipo_impuesto order by tipo_cod");              
            }
                 
                
        foreach ($impuestos as $impu) {
            $pdf->Cell(30,5,$impu['tipo_cod'], 1, 0, 'C', 1);
            $pdf->Cell(60,5,$impu['tipo_descri'], 1, 0, 'C', 1);
            $pdf->Cell(0,5,$impu['tipo_porcen'], 1, 0, 'C', 1);
           // $pdf->Cell(40,5,$clien['prv_direccion'], 1, 0, 'C', 1);
            //$pdf->Cell(40,5,$clien['prv_telefono'], 1, 0, 'C', 1);
            $pdf->Ln();
        }
        

//SALIDA AL NAVEGADOR
$pdf->Output('reporte_tipoimpuesto.pdf', 'I');
?>