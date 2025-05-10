<?php

require 'clases/conexion.php';
session_start();


//$vpresu_fechavence = !empty($_REQUEST['vpresu_fechavence']) ? date('Y-m-d', strtotime($_REQUEST['vpresu_fechavence'])) : '';

$sql = "SELECT sp_controlproduccion(
    " . $_REQUEST['accion'] . ",
    " . $_REQUEST['vconprod_cod'] . ",
    " . (!empty($_REQUEST['vorden_cod']) ? $_REQUEST['vorden_cod'] : "0") . ",
    '" . (!empty($_REQUEST['vconprod_obs'])?$_REQUEST['vconprod_obs']:"") . "',
    " . $_SESSION['emp_cod'] . ") as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul'] != null) {
    list($mensaje, $ubicacion) = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje'] = $mensaje;
    header("Location: $ubicacion");
} else {
    $_SESSION['mensaje'] = "Error: $sql";
    header("Location: controlproduccion_index.php");
}
?>