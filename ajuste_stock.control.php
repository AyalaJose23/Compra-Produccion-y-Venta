<?php

require 'clases/conexion.php';
session_start();

$sql = "select sp_ajustes(
".$_REQUEST['accion'].",
".$_REQUEST['vid_ajuste'].", 
".$_SESSION['emp_cod']."
) as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul']!=null) {
   $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje']=$valor[0];
    header("location:".$valor[1]);
}else{
    $_SESSION['mensaje']="Error:".$sql;
    header("location:ajuste_stock.index.php");    
}

//,'".$_REQUEST['vpp_validez'] . "'