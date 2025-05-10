
<?php

require 'clases/conexion.php';
session_start();

$sql = "select sp_detalle_compras(
    ".$_REQUEST['accion'].",
    ".$_REQUEST['vcom_cod'].",
    ".(!empty($_REQUEST['vart_cod']) ? $_REQUEST['vart_cod'] : "0") . ",
    ".(!empty($_REQUEST['vcom_cant'])?$_REQUEST['vcom_cant']:"0").",
    ".(!empty($_REQUEST['vcom_precio'])?$_REQUEST['vcom_precio']:"0").",
    ".(!empty($_REQUEST['exenta'])?$_REQUEST['exenta']:"0").",
    ".(!empty($_REQUEST['iva_5'])?$_REQUEST['iva_5']:"0").",
    ".(!empty($_REQUEST['iva_10'])?$_REQUEST['iva_10']:"0")."
) as resul";
$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul'] != null) {
    $_SESSION['mensaje'] = $resultado[0]['resul'];
    header("location:compras.det.php?vcom_cod=".$_REQUEST['vcom_cod']);
} else {
    $_SESSION['mensaje'] = "Error:".$sql;
    header("location:compras.det.php?vcom_cod=".$_REQUEST['vcom_cod']);    
}
