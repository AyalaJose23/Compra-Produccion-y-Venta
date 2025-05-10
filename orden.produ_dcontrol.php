<?php

require 'clases/conexion.php';

session_start();
$sql = "select sp_detalle_orden_produ(
    ".$_REQUEST['accion'].",
    ".$_REQUEST['vcod_orden'].", 
    split_part('".$_REQUEST['vcod_produ']."','_',1)::integer, 
    ".(!empty($_REQUEST['vorden_cant'])?$_REQUEST['vorden_cant']:"0").",
    ".(!empty($_REQUEST['vorden_precio'])?$_REQUEST['vorden_precio']:"0").",
    ".(!empty($_REQUEST['exenta'])?$_REQUEST['exenta']:"0").",
    ".(!empty($_REQUEST['iva_5'])?$_REQUEST['iva_5']:"0").",
    ".(!empty($_REQUEST['iva_10'])?$_REQUEST['iva_10']:"0").",
    
    ".(!empty($_REQUEST['vid_equipo'])?$_REQUEST['vid_equipo']:"0")."


    ) as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul'] != null) {
    $_SESSION['mensaje'] = $resultado[0]['resul'];
    header("location:orden.produ.det.php?vcod_orden=" . $_REQUEST['vcod_orden']);
} else {
    $_SESSION['mensaje'] = "Error:" . $sql;
    header("location:orden.produ.det.php?vcod_orden=" . $_REQUEST['vcod_orden']);
}
?>
