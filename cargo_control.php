<?php

require 'clases/conexion.php';

$sql = "select sp_cargo(".$_REQUEST['accion'].",".$_REQUEST['vcar_cod'].",'".$_REQUEST['vcar_descri']."') as resul;";

session_start();
$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul']!=null) {
    $_SESSION['mensaje'] = $resultado[0]['resul'];
    header("location:cargo.index.php");
}else{
     $_SESSION['mensaje'] = 'Error al insertar '.$sql;
    header("location:cargo.index.php");
}
?>

