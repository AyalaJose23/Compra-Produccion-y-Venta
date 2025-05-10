<?php

require 'clases/conexion.php';
session_start();


//$vpcom_fechavence = !empty($_REQUEST['vpcom_fechavence']) ? date('Y-m-d', strtotime($_REQUEST['vpcom_fechavence'])) : '';

$sql = "SELECT sp_costo_produccion(
    " . $_REQUEST['accion'] . ",
    " . $_REQUEST['vcospro_cod'] . ", 
    " . (!empty($_REQUEST['vpedins_cod']) ? $_REQUEST['vpedins_cod'] : "0") . ",
    " . $_SESSION['emp_cod'] . ", 
    " . (!empty($_REQUEST['vequi_cod']) ? $_REQUEST['vequi_cod'] : "0") . ") as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul'] != null) {
    $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje'] = $valor[0];
    header("location:" . $valor[1]);
} else {
    $_SESSION['mensaje'] = "Error:".$sql;
    header("location:costoproduccion_index.php");
}
?>