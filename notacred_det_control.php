<?php

require 'clases/conexion.php';
session_start();

$sub = $_REQUEST['vdevol'] * $_REQUEST['vprecio'];

$sql = "SELECT  sp_detanotacredcompra(" . $_REQUEST['accion'] . ","
.$_REQUEST['vdetcred'] . "," .
$_REQUEST['varti'] . "," .
$_REQUEST['vprecio'] . "," .
$_REQUEST['vcant'] . "," .
$sub . "," .
"'" . $_REQUEST['vestado'] . "'," .
$_REQUEST['vsobrante'] . "," .
$_REQUEST['vdevol'] . ") as detcred;";



$resultado = consultas::get_datos($sql);

if ($resultado[0]['detcred'] == null) {
    $_SESSION['mensaje'] = 'Error de prceso ' + $sql;
    header('location:./' . $_REQUEST['pagina']);
} else {
    $_SESSION['mensaje'] = $resultado[0]['detcred'] . "_" . $_REQUEST['accion'];

    header('location:./' . $_REQUEST['pagina'] . "?vdetcred=" .
            $_REQUEST['vdetcred'] . "&vcompr=" . $_REQUEST['vcompr']);
}
?>