<?php

require 'clases/conexion.php';
session_start();

$sql = "select sp_ordens(
" . $_REQUEST['accion'] . ",
" . $_REQUEST['vorden_cod'] . ", 
" . $_SESSION['emp_cod'] . ", 
" . (!empty($_REQUEST['vprv_cod'])?$_REQUEST['vprv_cod']:"0") . ",
" . (!empty($_REQUEST['vcod_pp'])?$_REQUEST['vcod_pp'] : "0") . ") as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul'] != null) {
    $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje'] = $valor[0];
    header("location:" . $valor[1]);
} else {
    $_SESSION['mensaje'] = "Error:".$sql;
    header("location:orden.index.php");
}

