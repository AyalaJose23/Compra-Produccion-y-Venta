
<?php

require 'clases/conexion.php';
session_start();


$sql = "select sp_detalle_ventas(
    ".$_REQUEST['accion'].",
    ".$_REQUEST['vid_venta'].",
    ".(!empty($_REQUEST['vdep_cod']) ? $_REQUEST['vdep_cod'] : "2") . ",
    ".(!empty($_REQUEST['vcod_produ']) ? $_REQUEST['vcod_produ'] : "0") . ",
    ".(!empty($_REQUEST['vdv_cantidad'])?$_REQUEST['vdv_cantidad']:"0").",
    ".(!empty($_REQUEST['vdv_precio'])?$_REQUEST['vdv_precio']:"0").",
    ".(!empty($_REQUEST['exenta'])?$_REQUEST['exenta']:"0").",
    ".(!empty($_REQUEST['iva_5'])?$_REQUEST['iva_5']:"0").",
    ".(!empty($_REQUEST['iva_10'])?$_REQUEST['iva_10']:"0")."
) as resul";
$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul'] != null) {
    $_SESSION['mensaje'] = $resultado[0]['resul'];
    header("location:ventas_det.php?vid_venta=".$_REQUEST['vid_venta']);
} else {
    $_SESSION['mensaje'] = "Error:".$sql;
    header("location:ventas_det.php?vid_venta=".$_REQUEST['vid_venta']);    
}
