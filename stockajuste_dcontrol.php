<?php

require 'clases/conexion.php';
session_start();

$sql = "select sp_detalle_ajuste(
".$_REQUEST['accion'].",
".$_REQUEST['vajuste_cod'].", 
split_part('".$_REQUEST['vart_cod']."','_',1)::integer, 
".(!empty($_REQUEST['vcantidad'])?$_REQUEST['vcantidad']:"0")."
) as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul']!=null) {
    $_SESSION['mensaje']=$resultado[0]['resul'];
    header("location:stockajuste.det.php?vajuste_cod=".$_REQUEST['vajuste_cod']);
}else{
    $_SESSION['mensaje']="Error:".$sql;
    header("location:stockajuste.det.php?vajuste_cod=".$_REQUEST['vajuste_cod']);    
}

