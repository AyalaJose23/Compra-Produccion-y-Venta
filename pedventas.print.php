<?php

include_once './tcpdf/tcpdf.php';
include_once 'clases/conexion.php';

class MYPDF extends TCPDF {
    public function Header() {
        $this->SetFont('helvetica', 'B', 16);
        $this->SetTextColor(50, 50, 50);
        $this->Cell(0, 10, '', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln(5);
    }

    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->SetTextColor(128, 128, 128);
        $this->Cell(0, 10, 'Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'R');
    }
}

// Crear documento PDF
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Antonio Portillo');
$pdf->SetTitle('REPORTE DE PEDIDO DE VENTA');
$pdf->setPrintHeader(true);
$pdf->SetMargins(15, 20, 15);
$pdf->SetAutoPageBreak(TRUE, 20);
$pdf->SetFont('helvetica', '', 12);
$pdf->AddPage('P', 'A4');

// Encabezado de la empresa
$pdf->Image('img/muble.jpg', 15, 10, 30); // Cambia 'path_to_logo' al directorio del logo
$pdf->Cell(0, 10, "Todo Muebles", 0, 1, 'R');
$pdf->SetFont('helvetica', '', 10);

$pdf->Ln(10);

// Consultas de datos según la opción seleccionada
$opcion = $_REQUEST['opcion'] ?? null;
$cabeceras = [];

if ($opcion) {
    switch ($opcion) {
        case 1:
            $cabeceras = consultas::get_datos("SELECT * FROM v_pedido_cabventa WHERE ped_fecha::date BETWEEN '{$_REQUEST['vdesde']}' AND '{$_REQUEST['vhasta']}'");
            break;
        case 2:
            $cabeceras = consultas::get_datos("SELECT * FROM v_pedido_cabventa WHERE cli_cod = {$_REQUEST['vcliente']}");
            break;
        case 3:
            $cabeceras = consultas::get_datos("SELECT * FROM v_pedido_cabventa WHERE ped_cod IN (SELECT ped_cod FROM detalle_pedventa WHERE cod_produ = {$_REQUEST['varticulo']})");
            break;
        case 4:
            $cabeceras = consultas::get_datos("SELECT * FROM v_pedido_cabventa WHERE emp_cod = {$_REQUEST['vempleado']}");
            break;
    }
} else {
    $cabeceras = consultas::get_datos("SELECT * FROM v_pedido_cabventa WHERE ped_cod = {$_REQUEST['vped_cod']}");
}

// Generación de contenido del PDF
if ($cabeceras) {
    foreach ($cabeceras as $index => $cabecera) {
        // Agregar espacio y línea de separación entre facturas, excepto la primera
        if ($index > 0) {
            $pdf->Ln(35); // Espacio entre facturas
            $pdf->SetDrawColor(128, 128, 128); // Color de la línea
            $pdf->SetLineWidth(0.5); // Ancho de la línea
            $pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY()); // Línea horizontal de separación
            $pdf->Ln(5); // Espacio después de la línea
        }

        // Información del cliente
        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetTextColor(0, 0, 0);

        $pdf->Cell(130, 8, "Cliente: ({$cabecera['cli_ci']}) " . strtoupper($cabecera['cliente']), 0, 0, 'L');
        $pdf->Cell(80, 8, "Fecha: {$cabecera['ped_fecha']}", 0, 1);
        $pdf->Cell(130, 8, "Empleado: " . strtoupper($cabecera['empleado']), 0, 0, 'L');
        $pdf->Cell(80, 8, "Estado: {$cabecera['estado']}", 0, 1);
        $pdf->Cell(130, 8, "N° Pedido: {$cabecera['ped_cod']}", 0, 1, 'L');
        $pdf->Ln();

        // Detalles del pedido
$pdf->SetFillColor(230, 230, 230);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(15, 8, "Cod.", 1, 0, 'C', 1);
$pdf->Cell(60, 8, "Descripción", 1, 0, 'L', 1); // Reduje este ancho
$pdf->Cell(20, 8, "Cant.", 1, 0, 'C', 1);
$pdf->Cell(35, 8, "IVA", 1, 0, 'C', 1); // Amplié el ancho de la columna de IVA
$pdf->Ln();

$detalles = consultas::get_datos("SELECT * FROM v_detalle_pedventa WHERE ped_cod = {$cabecera['ped_cod']}");

if ($detalles) {
    $pdf->SetFont('helvetica', '', 10);
    $pdf->SetFillColor(255, 255, 255);

    foreach ($detalles as $det) {
        $pdf->Cell(15, 8, $det['cod_produ'], 1, 0, 'C');
        $pdf->Cell(60, 8, $det['produ_descri'], 1, 0, 'L'); // Reduje este ancho
        $pdf->Cell(20, 8, $det['ped_cant'], 1, 0, 'C');
        $pdf->Cell(35, 8, $det['tipo_descri'], 1, 0, 'C'); // Amplié el ancho de la columna de IVA
        $pdf->Ln();
    


            }

            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->SetFillColor(230, 230, 230);
            $pdf->Cell(85, 8, "Total: {$cabecera['totalletra']}", 1, 0, 'L', 1);
            $pdf->Cell(45, 8, number_format($cabecera['ped_total'], 0, ".", "."), 1, 0, 'C', 1);
        } else {
            $pdf->Cell(135, 8, 'El pedido no tiene detalles cargados', 0, 1, 'L');
        }
        $pdf->Ln(10);
    }
} else {
    $pdf->Cell(135, 8, 'No se encontraron datos del pedido', 0, 1, 'L');
}

// Salida al navegador
$pdf->Output('reporte.pedventa.pdf', 'I');

?>
