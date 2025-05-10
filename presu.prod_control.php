<?php
require './clases/conexion.php';
session_start();
$sql = "SELECT sp_preprod (".$_REQUEST['accion'].",
        " . $_REQUEST['vcod_preprod'] . ", 
        " . $_SESSION['emp_cod'] . ",
        " . (!empty($_REQUEST['vped_cod']) ? $_REQUEST['vped_cod'] : "0") . ",
        ".(!empty($_REQUEST['vcli_cod']) ? $_REQUEST['vcli_cod'] : "0"). ",
        " . (!empty($_REQUEST['vpreprod_nro']) ? $_REQUEST['vpreprod_nro'] : "0") . ",
        " . (isset($_REQUEST['fecha']) ? "'" . date('Y-m-d', strtotime($_REQUEST['fecha'])) . "'" : 'NULL') . ", 
        " . (isset($_REQUEST['vpreprod_validez']) ? "'" . date('Y-m-d', strtotime($_REQUEST['vpreprod_validez'])) . "'" : 'NULL') . ",
        '" . (!empty($_REQUEST['vpreprod_obs']) ? $_REQUEST['vpreprod_obs'] :  "") . "') as resul";

// Ejecutar la consulta
$resultado = consultas::get_datos($sql);

// Verificar el resultado y redirigir

if ($resultado[0]['resul']!=null) {
   $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje']=$valor[0];
    header("location:".$valor[1]);
}else{
    $_SESSION['mensaje']="Error:".$sql;
    header("location:presu.prod.index.php");    
}
