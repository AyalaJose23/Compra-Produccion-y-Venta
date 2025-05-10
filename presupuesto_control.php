<?php
require './clases/conexion.php';
session_start();
$sql = "SELECT sp_pp (".$_REQUEST['accion'].",
        " . (!empty($_REQUEST['vcod_pp']) ? $_REQUEST['vcod_pp'] : "0") . ",
        " . $_SESSION['emp_cod'] . ",
        " . (!empty($_REQUEST['vped_com']) ? $_REQUEST['vped_com'] : "0") . ",
        ".(!empty($_REQUEST['vprv_cod']) ? $_REQUEST['vprv_cod'] : "0"). ",
        " . (!empty($_REQUEST['vnro_pp']) ? $_REQUEST['vnro_pp'] : "0") . ",
        " . (isset($_REQUEST['fecha']) ? "'" . date('Y-m-d', strtotime($_REQUEST['fecha'])) . "'" : 'NULL') . ", 
        " . (isset($_REQUEST['vpp_validez']) ? "'" . date('Y-m-d', strtotime($_REQUEST['vpp_validez'])) . "'" : 'NULL') . ",
        '" . (!empty($_REQUEST['vpp_obs']) ? $_REQUEST['vpp_obs'] :  "") . "') as resul";

// Ejecutar la consulta
$resultado = consultas::get_datos($sql);

// Verificar el resultado y redirigir
if ($resultado[0]['resul']!=null) {
    $valor = explode("*", $resultado[0]['resul']);
     $_SESSION['mensaje']=$valor[0];
     header("location:".$valor[1]);
} else {
    $_SESSION['mensaje'] = "ERROR: $sql";
    header("location:presupuesto.index.php?vcod_pp=".$_REQUEST['vcod_pp']);
}
?>