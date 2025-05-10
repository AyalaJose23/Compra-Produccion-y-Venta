<?php

require 'clases/conexion.php';
session_start();

$sql = "select sp_detalle_costo(
".$_REQUEST['accion'].",
".$_REQUEST['vcospro_cod'].", 
split_part('".$_REQUEST['vins_cod']."','_',1)::integer,
".(!empty($_REQUEST['vdetcos_preciounitario'])?$_REQUEST['vdetcos_preciounitario']:"0").", 
".(!empty($_REQUEST['vdetcos_cantidad'])?$_REQUEST['vdetcos_cantidad']:"0").") as resul";


$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul']!=null) {
    $_SESSION['mensaje']=$resultado[0]['resul'];
    header("location:costoproduccion_det.php?vcospro_cod=".$_REQUEST['vcospro_cod']);
}else{
    $_SESSION['mensaje']="Error:".$sql;
    header("location:costoproduccion_det.php?vcospro_cod=".$_REQUEST['vcospro_cod']);    
}
?>
