<?php

require 'clases/conexion.php';
session_start();

$sql = "select sp_notacredcompra(
" . $_REQUEST['accion'] . ",
" . $_REQUEST['vcodigo'] . ", 
" . $_SESSION['vemp_cod'] . ", 
'".$_REQUEST['vcredmoti']."',
'".$_REQUEST['vcreddescrip']."',
" . (!empty($_REQUEST['vcreddescuento'])?$_REQUEST['vcreddescuento']:"0") . ",
" . $_SESSION['vcreditotal'] . ",
" . $_SESSION['fechanotacred'] . ",
" . $_SESSION['vtimbnro'] . ",
" . $_SESSION['vtimbfechafin'] . ",
" . $_SESSION['vnronotacred'] . ",
" . $_SESSION['vcodtipocomprobante'] . ",
" . (!empty($_REQUEST['vprv_cod'])?$_REQUEST['vprv_cod']:"0") . ",
" . (!empty($_REQUEST['vcodcompra'])?$_REQUEST['vcodcompra'] : "0") . ") as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul'] != null) {
    $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje'] = $valor[0];
    header("location:" . $valor[1]);
} else {
    $_SESSION['mensaje'] = "Error:".$sql;
    header("location:notacredito_c.index.php");
}
