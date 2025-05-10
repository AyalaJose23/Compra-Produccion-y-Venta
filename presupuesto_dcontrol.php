
<?php

require 'clases/conexion.php';
session_start();

$sql = "select sp_detalle_pp(
    ".$_REQUEST['accion'].",
    ".$_REQUEST['vcod_pp'].",
    ".(!empty($_REQUEST['vart_cod']) ? $_REQUEST['vart_cod'] : "0") . ",
    ".(!empty($_REQUEST['vcantidad'])?$_REQUEST['vcantidad']:"0").",
    ".(!empty($_REQUEST['vprecio'])?$_REQUEST['vprecio']:"0").",
    ".(!empty($_REQUEST['exenta'])?$_REQUEST['exenta']:"0").",
    ".(!empty($_REQUEST['iva_5'])?$_REQUEST['iva_5']:"0").",
    ".(!empty($_REQUEST['iva_10'])?$_REQUEST['iva_10']:"0")."
) as resul";
$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul'] != null) {
    $_SESSION['mensaje'] = $resultado[0]['resul'];
    header("location:presupuesto.det.php?vcod_pp=".$_REQUEST['vcod_pp']);
} else {
    $_SESSION['mensaje'] = "Error:".$sql;
    header("location:presupuesto.det.php?vcod_pp=".$_REQUEST['vcod_pp']);    
}
