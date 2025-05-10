<?php

require 'clases/conexion.php';

$sql = "select sp_tipoimpuesto(".$_REQUEST['accion'].",".$_REQUEST['vtipo_cod'].",'".$_REQUEST['vtipo_descri']."',
        ".$_REQUEST['vtipo_porcen'].") as resul;";

session_start();
$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul']!=null) {
    $_SESSION['mensaje'] = $resultado[0]['resul'];
    header("location:tipoimpuesto.index.php");
}else{
     $_SESSION['mensaje'] = 'Error al insertar '.$sql;
    header("location:tipoimpuesto.index.php");
}
?>

