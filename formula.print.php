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
$pdf->SetAuthor('Jose Ayala');
$pdf->SetTitle('REPORTE DE FORMULAS DE PRODUCCION');
$pdf->setPrintHeader(true);
$pdf->SetMargins(15, 20, 15);
$pdf->SetAutoPageBreak(TRUE, 20);
$pdf->SetFont('helvetica', '', 12);
$pdf->AddPage('P', 'A4');

// Encabezado de la empresa
$pdf->Image('img/mueble.jpg', 15, 10, 30); // Cambia 'path_to_logo' al directorio del logo
$pdf->Cell(0, 10, "Todo Muebles", 0, 1, 'R');
$pdf->SetFont('helvetica', '', 10);

$pdf->Ln(10);

// Título de la factura
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, "Formula de Porducción", 0, 1, 'C');
$pdf->Ln(5);

// Consultas de datos según la opción seleccionada
$opcion = $_REQUEST['opcion'] ?? null;
$cabeceras = [];

if ($opcion) {
    switch ($opcion) {
        case 1:
            $cabeceras = consultas::get_datos("SELECT * FROM v_formula WHERE formula_fecha::date BETWEEN '{$_REQUEST['vdesde']}' AND '{$_REQUEST['vhasta']}'");
            break;
        
        case 2:
            $cabeceras = consultas::get_datos("SELECT * FROM v_formula WHERE cod_formula IN (SELECT cod_formula FROM detalle_formula WHERE art_cod = {$_REQUEST['vartiulo']})");
            break;
        case 3:
            $cabeceras = consultas::get_datos("SELECT * FROM v_formula WHERE emp_cod = {$_REQUEST['vempleado']}");
            break;
    }
} else {
    $cabeceras = consultas::get_datos("SELECT * FROM v_formula WHERE cod_formula = {$_REQUEST['vcod_formula']}");
}

// Generación de contenido del PDF
if (!empty($cabeceras)) {
    foreach ($cabeceras as $index => $cabecera) {
        // Agregar espacio y línea de separación entre facturas, excepto la primera
        if ($index > 0) {
            $pdf->Ln(35); // Espacio entre facturas
            $pdf->SetDrawColor(128, 128, 128); // Color de la línea
            $pdf->SetLineWidth(0.5); // Ancho de la línea
            $pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY()); // Línea horizontal de separación
            $pdf->Ln(5); // Espacio después de la línea
        }

        // Información del proveedor
        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetFillColor(240, 240, 240);
        
        $pdf->Cell(0, 8, "Fecha: " . date('d/m/Y', strtotime($cabecera['formula_fecha'])), 0, 1, 'R', 1);
        $pdf->Cell(100, 8, "Funcionario: " . strtoupper($cabecera['empleado']), 0, 0, 'L', 1);
        $pdf->Cell(0, 8, "Estado: " . $cabecera['formula_estado'], 0, 1, 'R', 1);
        $pdf->Cell(100, 8, "N° Formula: " . $cabecera['cod_formula'], 0, 1, 'L', 1);
        $pdf->Ln(10);

        // Encabezado de la tabla de productos
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->SetFillColor(220, 220, 220);
        $pdf->Cell(20, 8, "Código", 1, 0, 'C', 1);
        $pdf->Cell(80, 8, "Descripción", 1, 0, 'L', 1);
        $pdf->Cell(20, 8, "Código", 1, 0, 'C', 1);
        $pdf->Cell(80, 8, "Presentaciín", 1, 0, 'L', 1);
        $pdf->Cell(20, 8, "Cantidad", 1, 0, 'C', 1);

        // Datos de los productos
        $pdf->SetFont('helvetica', '', 10);
        $detalles = consultas::get_datos("SELECT * FROM v_detalle_formula WHERE cod_formula=" . $cabecera['cod_formula']);
        if (!empty($detalles)) {
            $pdf->SetFillColor(255, 255, 255);
            foreach ($detalles as $det) {
                $pdf->Cell(20, 8, $det['art_cod'], 1, 0, 'C', 1);
                $pdf->Cell(80, 8, $det['art_descri'], 1, 0, 'L', 1);
                $pdf->Cell(20, 8, $det['formula_cant'], 1, 0, 'C', 1);
            }

            // Sección de Totales
            
        } else {
            $pdf->Cell(0, 8, 'No se encontraron detalles para esta formula', 1, 1, 'C', 1);
        }
    }
} else {
    $pdf->Cell(0, 8, 'No se encontraron datos de la formula', 1, 1, 'C', 1);
}

// Salida al navegador
$pdf->Output('Factura_de_formula.pdf', 'I');
?>
