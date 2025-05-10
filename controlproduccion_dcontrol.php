<?php

require 'clases/conexion.php';

session_start();

$sql = "SELECT sp_detalle_controlproduccion(".$_REQUEST['accion'].",
".$_REQUEST['vcod_control'].",  
".$_REQUEST['vcod_etapa_p'].", 
" . (isset($_REQUEST['vfecha_fin']) ? "'" . date('Y-m-d', strtotime($_REQUEST['vfecha_fin'])) . "'" : 'NULL') . ",
".$_REQUEST['vcod_orden']."
) as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul']!=null) {
    $_SESSION['mensaje'] = $resultado[0]['resul'];
    //header("location:controlproduccion_det.php"); //original
    header("location:controlproduccion_det.php? vcod_control=".$_REQUEST['vcod_control']);
    //header("location:" . $valor[1]);
}else{
    $_SESSION['mensaje'] = "Error:".$sql;
   // header("location:controlproduccion_det.php");  //original
    header("location:controlproduccion_det.php? vcod_control=".$_REQUEST['vcod_control']);
}

