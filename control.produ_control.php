<?php
require './clases/conexion.php';
session_start();
$sql = "SELECT sp_control_produ (".$_REQUEST['accion'].",
        " . $_REQUEST['vcod_control'] . ", 
        " . (!empty($_REQUEST['vcod_orden']) ? $_REQUEST['vcod_orden'] : "0") . ",
        " . $_SESSION['emp_cod'] . ",
        " . (isset($_REQUEST['fecha']) ? "'" . date('Y-m-d', strtotime($_REQUEST['fecha'])) . "'" : 'NULL') . ") as resul";

// Ejecutar la consulta
$resultado = consultas::get_datos($sql);

// Verificar el resultado y redirigir

if ($resultado[0]['resul']!=null) {
   $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje']=$valor[0];
    header("location:".$valor[1]);
}else{
    $_SESSION['mensaje']="Error:".$sql;
    header("location:controlproduccion_index.php");    
}
