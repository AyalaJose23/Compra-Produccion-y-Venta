<?php 
require 'clases/conexion.php'; 
session_start(); 

$sql = "select sp_remicom(".$_REQUEST['accion'].", 
".(!empty($_REQUEST['vcod_nota'])?$_REQUEST['vcod_nota'] : "0") . ",
" . (isset($_REQUEST['fecha']) ? "'" . date('Y-m-d', strtotime($_REQUEST['fecha'])) . "'" : 'NULL') . ",
'".(!empty($_REQUEST['vmotivo'])?$_REQUEST['vmotivo']:"")."', 
'".(!empty($_REQUEST['vconductor'])?$_REQUEST['vconductor']:"")."',
".(!empty($_REQUEST['vci'])?$_REQUEST['vci']:"0").", 
".(!empty($_REQUEST['vtelef'])?$_REQUEST['vtelef']:"0").",
".(isset($_REQUEST['vsalida'])?"'" . date('Y-m-d', strtotime($_REQUEST['vsalida'])) . "'" : 'NULL') . ",
".(isset($_REQUEST['vllegada'])?"'" . date('Y-m-d', strtotime($_REQUEST['vllegada'])) . "'" : 'NULL') . ",
".(!empty($_REQUEST['vtimbrado']) ? $_REQUEST['vtimbrado'] : "0") . ",
'".(!empty($_REQUEST['vchapa']) ? $_REQUEST['vchapa'] : "") . "',
".(!empty($_REQUEST['vprv_cod'])?$_REQUEST['vprv_cod']:"0").", 
".(!empty($_REQUEST['vmarca']) ? $_REQUEST['vmarca'] : "0") . ",
".$_SESSION['emp_cod'].", 
".(!empty($_REQUEST['vcom_cod'])?$_REQUEST['vcom_cod']:"0").",
".(isset($_REQUEST['vremi_vigen'])?"'" . date('Y-m-d', strtotime($_REQUEST['vremi_vigen'])) . "'" : 'NULL') . ",
".(!empty($_REQUEST['vnro_remi']) ? $_REQUEST['vnro_remi'] : "0") . "
) as resul"; 

    
$resultado = consultas::get_datos($sql); 

if ($resultado[0]['resul'] != null) { 
    $valor = explode("*", $resultado[0]['resul']); 
    $_SESSION['mensaje'] = $valor[0]; 
    header("location:nota_remision.index.php?vcod_nota=".$_REQUEST['vcod_nota']); 
} else { 
    $_SESSION['mensaje'] = "Error:".pg_last_error();
    header("location:nota_remision.index.php"); 
}
?>
 