<?php 
require 'clases/conexion.php'; 
session_start(); 

// Asegúrate de que el parámetro 'id_caja' esté definido antes de usarlo
$id_caja = isset($_REQUEST['id_caja']) ? $_REQUEST['id_caja'] : null;

if (!$id_caja) {
    $_SESSION['mensaje'] = "Error: 'id_caja' no definido.";
    header("location:apertura_cierre.php");
    exit;
}

$sql = "select sp_apercierre(".$_REQUEST['accion'].", 
    ".$_REQUEST['vid_apercierre'].", 
    ".(!empty($_REQUEST['vaper_monto']) ? $_REQUEST['vaper_monto'] : "0").",
    ".(!empty($_REQUEST['vcierre_monto']) ? $_REQUEST['vcierre_monto'] : "0").",
    ".$id_caja.",  
    ".$_SESSION['emp_cod'].") as resul";

$resultado = consultas::get_datos($sql);



if ($resultado[0]['resul'] != null) { 
    $valor = explode("*", $resultado[0]['resul']); 
    $_SESSION['mensaje'] = $valor[0]; 
    header("location:".$valor[1]); 
} else { 
    $_SESSION['mensaje'] = "Error:".$sql; 
    header("location:apertura_cierre.index.php"); 
}
?>
