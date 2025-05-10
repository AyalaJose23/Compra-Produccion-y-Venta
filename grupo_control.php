<?php

require 'clases/conexion.php';

$sql = "select sp_grupo(".$_REQUEST['accion'].",".$_REQUEST['vgru_cod'].",'".$_REQUEST['vgru_nombre']."') as resul;";

session_start();
$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul']!=null) {
    $_SESSION['mensaje'] = $resultado[0]['resul'];
    header("location:grupo.index.php");
}else{
     $_SESSION['mensaje'] = 'Error al insertar '.$sql;
    header("location:grupo.index.php");
}
?>

