<?php
require 'clases/conexion.php';

$tipo = $_GET['tipo'] ?? '';

switch ($tipo) {
    case 'articulo':
        $datos = consultas::get_datos("SELECT art_cod AS value, art_descri AS text FROM v_articulo ORDER BY art_descri");
        break;

    case 'empleado':
        $datos = consultas::get_datos("SELECT emp_cod AS value, emp_nombre AS text FROM v_empleado ORDER BY emp_nombre");
        break;

    case 'proveedor':
        $datos = consultas::get_datos("SELECT prv_cod AS value, prv_razonsocial AS text FROM proveedor ORDER BY prv_razonsocial");
        break;    

    // Puedes añadir más casos aquí si necesitas otros tipos de datos
    default:
        $datos = [];
        break;
}

header('Content-Type: application/json');
echo json_encode($datos);
?>
