<?php

include_once './tcpdf/tcpdf.php';
include_once 'clases/conexion.php';

// Clase personalizada para encabezado y pie de página
class MYPDF extends TCPDF {
    // Pie de página
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'C');
    }
}

// Crear el documento PDF
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Jose Ayala');
$pdf->SetTitle('Pedido de Compra');
$pdf->setPrintHeader(false);
$pdf->SetMargins(15, 20, 15);
$pdf->SetFooterMargin(10);
$pdf->SetAutoPageBreak(true, 15);
$pdf->SetFont('helvetica', '', 10);

// Agregar una nueva página
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B', 14);

// Encabezado de la empresa
$pdf->Image('./path_to_logo/logo.png', 15, 10, 30); // Cambia 'path_to_logo' al directorio del logo
$pdf->Cell(0, 10, "Todo Muebles", 0, 1, 'R');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 5, "Teniente Etienne y Pettirossi", 0, 1, 'R');
$pdf->Cell(0, 5, "Teléfono: +595 981 211 393", 0, 1, 'R');
$pdf->Cell(0, 5, "Correo: contacto@empresa.com", 0, 1, 'R');
$pdf->Ln(10);

// Título de la factura
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, "Pedido de Compra", 0, 1, 'C');
$pdf->Ln(5);

// Información del cliente y detalles del pedido
$opcion = $_REQUEST['opcion'] ?? null;
$filterQuery = "WHERE ped_com = " . $_REQUEST['vped_com'];
switch ($opcion) {
    case 1:
        $filterQuery = "WHERE ped_fecha::date BETWEEN '" . $_REQUEST['vdesde'] . "' AND '" . $_REQUEST['vhasta'] . "'";
        break;
    case 2:
        $filterQuery = "WHERE prv_cod = " . $_REQUEST['vproveedor'];
        break;
    case 3:
        $filterQuery = "WHERE ped_com IN (SELECT ped_com FROM detalle_compras WHERE art_cod=" . $_REQUEST['varticulo'] . ")";
        break;
    case 4:
        $filterQuery = "WHERE emp_cod = " . $_REQUEST['vempleado'];
        break;
}

$cabeceras = consultas::get_datos("SELECT * FROM v_pedido_cabcompra $filterQuery");

if (!empty($cabeceras)) {
    foreach ($cabeceras as $cabecera) {
        // Información del cliente
        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetFillColor(240, 240, 240);
        $pdf->Cell(100, 8, "Pedido realizado por: " . strtoupper($cabecera['empleado']), 0, 0, 'L', 1);
        $pdf->Cell(0, 8, "Fecha: " . date('d/m/Y', strtotime($cabecera['ped_fecha'])), 0, 1, 'R', 1);
        $pdf->Cell(100, 8, "Observacion: " . strtoupper($cabecera['obs_pedido']), 0, 0, 'L', 1);
        $pdf->Cell(0, 8, "Estado: " . $cabecera['ped_estado'], 0, 1, 'R', 1);
        $pdf->Cell(100, 8, "N° Pedido: " . $cabecera['ped_com'], 0, 1, 'L', 1);
        $pdf->Ln(10);

        // Encabezado de la tabla de productos
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->SetFillColor(220, 220, 220);
        $pdf->Cell(20, 8, "Código", 1, 0, 'C', 1);
        $pdf->Cell(80, 8, "Descripción", 1, 0, 'L', 1);
        $pdf->Cell(20, 8, "Cantidad", 1, 0, 'C', 1);
        $pdf->Cell(30, 8, "Precio Unit.", 1, 0, 'R', 1);
        $pdf->Cell(30, 8, "Subtotal", 1, 1, 'R', 1);

        // Datos de los productos
        $pdf->SetFont('helvetica', '', 10);
        $detalles = consultas::get_datos("SELECT * FROM v_detalle_pedcompra WHERE ped_com=" . $cabecera['ped_com']);
        if (!empty($detalles)) {
            $pdf->SetFillColor(255, 255, 255);
            foreach ($detalles as $det) {
                $pdf->Cell(20, 8, $det['art_cod'], 1, 0, 'C', 1);
                $pdf->Cell(80, 8, $det['art_descri'], 1, 0, 'L', 1);
                $pdf->Cell(20, 8, $det['ped_cant'], 1, 0, 'C', 1);
                $pdf->Cell(30, 8, number_format($det['ped_precio'], 0, ".", "."), 1, 0, 'R', 1);
                $pdf->Cell(30, 8, number_format($det['subtotal'], 0, ".", "."), 1, 1, 'R', 1);
            }

            
        } else {
            $pdf->Cell(0, 8, 'No se encontraron detalles para esta comta', 1, 1, 'C', 1);
        }
    }
} else {
    $pdf->Cell(0, 8, 'No se encontraron datos de la comta', 1, 1, 'C', 1);
}

// Salida al navegador
$pdf->Output('pedido_de_comta.pdf', 'I');
?>
