<?php
require 'clases/conexion.php';
session_start();

$sql = "select sp_modulo(".$_REQUEST['accion'].",".$_REQUEST['vmod_cod'].",'".$_REQUEST['vmod_nombre']."') as resul;";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul']!=null) {
    $_SESSION['mensaje'] = $resultado[0]['resul'];
    header("location:modulo.index.php");
}else{
    $_SESSION['mensaje'] = "Error:".$sql;
    header("location:modulo.index.php");    
}

