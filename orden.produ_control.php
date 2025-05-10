<?php
require './clases/conexion.php';
session_start();
$sql = "SELECT sp_orden_produ (".$_REQUEST['accion'].",
        " . $_REQUEST['vcod_orden'] . ", 
        " . $_SESSION['emp_cod'] . ",
        " . (!empty($_REQUEST['vcod_preprod']) ? $_REQUEST['vcod_preprod'] : "0") . ",
        ".(!empty($_REQUEST['vcli_cod']) ? $_REQUEST['vcli_cod'] : "0"). ",
        " . (isset($_REQUEST['fecha']) ? "'" . date('Y-m-d', strtotime($_REQUEST['fecha'])) . "'" : 'NULL') . ", 
        " . (isset($_REQUEST['vfecha_fin']) ? "'" . date('Y-m-d', strtotime($_REQUEST['vfecha_fin'])) . "'" : 'NULL') . ") as resul";

// Ejecutar la consulta
$resultado = consultas::get_datos($sql);

// Verificar el resultado y redirigir

if ($resultado[0]['resul']!=null) {
   $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje']=$valor[0];
    header("location:".$valor[1]);
}else{
    $_SESSION['mensaje']="Error:".$sql;
    header("location:orden.produ.index.php");    
}
