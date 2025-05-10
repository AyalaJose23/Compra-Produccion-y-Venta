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
        $this->Cell(0, 0, 'Pag. ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }

}

// create new PDF document // CODIFICACION POR DEFECTO ES UTF-8
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Antonio Portillo');
$pdf->SetTitle('REPORTE DE PEDIDO DE VENTA');
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
$pdf->SetFont('times', 'B', 20);

// AGREGAR PAGINA
$pdf->AddPage('P', 'LEGAL');
$pdf->Cell(0, 0, "REPORTE DE VENTA", 0, 1, 'C');
//SALTO DE LINEA
$pdf->Ln();
//COLOR DE TABLA
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(0);
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.2);

$pdf->SetFont('', '');
$pdf->SetFillColor(255, 255, 255);
//CONSULTAS DE LOS REGISTROS
if (!empty(isset($_REQUEST['opcion']))) {
    switch ($_REQUEST['opcion']) {
        case 1:
            $cabeceras = consultas::get_datos("select * from v_ventas "
                            . "where ven_fecha::date between '" . $_REQUEST['vdesde'] . "' and '" . $_REQUEST['vhasta'] . "'");
            break;
        case 2:
            $cabeceras = consultas::get_datos("select * from v_ventas "
                            . "where cli_cod =" . $_REQUEST['vcliente']);            
            break;
        case 3:
            $cabeceras = consultas::get_datos("select * from v_ventas "
                            . "where ven_cod in(select ven_cod from detalle_ventas where art_cod=".$_REQUEST['varticulo'].")");            
            break;
        case 4:
            $cabeceras = consultas::get_datos("select * from v_ventas "
                            . "where emp_cod =" . $_REQUEST['vempleado']);            
            break;        
    }
} else {
    $cabeceras = consultas::get_datos("select * from v_ventas where ven_cod = " . $_REQUEST['vven_cod']);
}
if (!empty($cabeceras)) {
    foreach ($cabeceras as $cabecera) {
        $pdf->SetFont('', '',11);
        $pdf->Cell(130, 2, "CLIENTE: (" . $cabecera['cli_ci'] . ") " . strtoupper($cabecera['cliente']), 0, '', 'L');
        $pdf->Cell(80, 2, "FECHA: " . $cabecera['ven_fecha'], 0, 1);
        $pdf->Cell(130, 2, "EMPLEADO:" . strtoupper($cabecera['empleado']), 0, '', 'L');
        $pdf->Cell(80, 2, "ESTADO: " . $cabecera['ven_estado'], 0, 1);
        $pdf->Cell(130, 2, "N° VENTA:" . $cabecera['ven_cod'], 0, '', 'L');
        $pdf->Cell(80, 2, "SUCURSAL: " . $cabecera['suc_descri'], 0, 1);
        $pdf->Ln();

        $pdf->SetFont('', 'B', 11);
        $pdf->SetFillColor(180, 180, 180);
        $detalles = consultas::get_datos("select * from v_detalle_ventas where ven_cod=" . $cabecera['ven_cod']);
        if (!empty($detalles)) {
            $pdf->Cell(15, 5, "COD.", 1, 0, 'C', 1);
            $pdf->Cell(80, 5, "DESCRIPCION", 1, 0, 'L', 1);
            $pdf->Cell(20, 5, "CANT.", 1, 0, 'C', 1);
            $pdf->Cell(25, 5, "PRECIO", 1, 0, 'C', 1);
            $pdf->Cell(30, 5, "SUBTOTAL", 1, 0, 'C', 1);
            $pdf->Cell(20, 5, "IVA", 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetFont('', '', 11);
            $pdf->SetFillColor(255, 255, 255);
            foreach ($detalles as $det) {
                $pdf->Cell(15, 5, $det['art_cod'], 1, 0, 'C', 1);
                $pdf->Cell(80, 5, $det['art_descri'] . " " . $det['mar_descri'], 1, 0, 'L', 1);
                $pdf->Cell(20, 5, $det['ven_cant'], 1, 0, 'C', 1);
                $pdf->Cell(25, 5, number_format($det['ven_precio'], 0, ".", "."), 1, 0, 'C', 1);
                $pdf->Cell(30, 5, number_format($det['subtotal'], 0, ".", "."), 1, 0, 'C', 1);
                $pdf->Cell(20, 5, $det['tipo_descri'], 1, 0, 'C', 1);
                $pdf->Ln();
            }
            $pdf->SetFont('', 'B', 11);
            $pdf->SetFillColor(180, 180, 180);
            $pdf->Cell(140, 5, "TOTAL: " . $cabeceras[0]['totalletra'], 1, 0, 'L', 1);
            $pdf->Cell(50, 5, number_format($cabeceras[0]['ven_total'], 0, ".", "."), 1, 0, 'C', 1);
        } else {
            $pdf->Cell(135, 5, 'La venta no tiene detalles cargados', 0, '', 'L', 1);
        }
        $pdf->Ln();
        $pdf->Ln();
    }
} else {
    $pdf->Cell(135, 5, 'No se encontraron datos de la venta', 0, '', 'L', 1);
}


//SALIDA AL NAVEGADOR
$pdf->Output('reporte.venta.pdf', 'I');
?>