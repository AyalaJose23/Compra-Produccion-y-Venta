<?php

require 'clases/conexion.php';
session_start();

$sql = "select sp_pedmp(
".$_REQUEST['accion'].",
".$_REQUEST['vped_mp'].", 
".$_SESSION['emp_cod'].",
'".$_REQUEST['vobs_pedido']."'
) as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul']!=null) {
   $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje']=$valor[0];
    header("location:".$valor[1]);
}else{
    $_SESSION['mensaje']="Error:".$sql;
    header("location:pedmp.index.php");    
}

//,'".$_REQUEST['vpp_validez'] . "'