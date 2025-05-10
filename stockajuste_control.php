<?php

require 'clases/conexion.php';
session_start();

$sql = "select sp_ajustes(
" . $_REQUEST['accion'] . ",
" . $_REQUEST['vajuste_cod'] . ", 
" . $_SESSION['emp_cod'] . ",
'" . $_REQUEST['vajuste_motivo'] . "') as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul'] != null) {
    $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje'] = $valor[0];
    header("location:" . $valor[1]);
} else {
    $_SESSION['mensaje'] = "Error:".$sql;
    header("location:stockajuste.index.php");
}

