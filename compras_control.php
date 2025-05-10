<?php 
require 'clases/conexion.php'; 
session_start(); 

$sql = "select sp_compras(".$_REQUEST['accion'].", 
" . (!empty($_REQUEST['vcom_cod']) ? $_REQUEST['vcom_cod'] : "0") . ",
    ".$_SESSION['emp_cod'].", 
    ".(!empty($_REQUEST['vprv_cod'])?$_REQUEST['vprv_cod']:"0").", 
    '".(!empty($_REQUEST['vtipo_compra'])?$_REQUEST['vtipo_compra']:"")."',
    ".(!empty($_REQUEST['vcan_cuota'])?$_REQUEST['vcan_cuota']:"0").", 
    ".(!empty($_REQUEST['vcom_plazo'])?$_REQUEST['vcom_plazo']:"0").", 
    ".(!empty($_REQUEST['vorden_cod'])?$_REQUEST['vorden_cod']:"0").",
    ".(!empty($_REQUEST['vcom_timbrado'])?$_REQUEST['vcom_timbrado']:"0").",
    " . (isset($_REQUEST['vtim_vz']) ? "'" . date('Y-m-d', strtotime($_REQUEST['vtim_vz'])) . "'" : 'NULL') . ",
    " . (!empty($_REQUEST['vnro_com']) ? $_REQUEST['vnro_com'] : "0") . ",
    " . (isset($_REQUEST['vcom_vig']) ? "'" . date('Y-m-d', strtotime($_REQUEST['vcom_vig'])) . "'" : 'NULL') . ",
    " . (isset($_REQUEST['vcom_emi']) ? "'" . date('Y-m-d', strtotime($_REQUEST['vcom_emi'])) . "'" : 'NULL') . "

    ) as resul"; 

$resultado = consultas::get_datos($sql); 

if ($resultado[0]['resul'] != null) { 
    $valor = explode("*", $resultado[0]['resul']); 
    $_SESSION['mensaje'] = $valor[0]; 
    header("location:".$valor[1]); 
} else { 
    $_SESSION['mensaje'] = "Error:".$sql; 
    header("location:compras.index.php"); 
}
?>
