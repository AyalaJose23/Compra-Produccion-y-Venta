<?php

require 'clases/conexion.php';
session_start();

$sql = "select sp_pedventas(
".$_REQUEST['accion'].",
".$_REQUEST['vped_cod'].", 
".$_SESSION['emp_cod'].", 
".(!empty($_REQUEST['vcli_cod'])?$_REQUEST['vcli_cod']:"0").") as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul']!=null) {
   $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje']=$valor[0];
    header("location:".$valor[1]);
}else{
    $_SESSION['mensaje']="Error:".$sql;
    header("location:pedventas.index.php");    
}
