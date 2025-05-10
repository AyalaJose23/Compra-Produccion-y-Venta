<?php

require 'clases/conexion.php';

$sql = "select sp_sucursal(".$_REQUEST['accion'].",".$_REQUEST['vid_sucursal'].",'".$_REQUEST['vsuc_descri']."') as resul;";

session_start();
$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul']!=null) {
    $_SESSION['mensaje'] = $resultado[0]['resul'];
    header("location:sucursal.index.php");
}else{
     $_SESSION['mensaje'] = 'Error al insertar '.$sql;
    header("location:sucursal.index.php");
}
?>

