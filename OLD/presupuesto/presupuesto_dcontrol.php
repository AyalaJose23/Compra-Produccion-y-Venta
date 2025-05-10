<?php
require './clases/conexion.php';
session_start();
$sub = $_REQUEST['vprecio']*$_REQUEST['vcant'] ;
$sql = "SELECT sp_detalle_pp (".$_REQUEST['accion'].",
".$_REQUEST['vcod_pp'].",
".$_REQUEST['varti'].","
        .$_REQUEST['vcant'].",".$_REQUEST['vprecio'].",".
        $sub.",'".$_REQUEST['vestado']."') as detalle_pp";

$resultado = consultas::get_datos($sql);



    if ($resultado[0]['resul'] != null) {
    $_SESSION['mensaje'] = $resultado[0]['resul'];
    header("location:presupuesto.det.php?vcod_pp=".$_REQUEST['vcod_pp']);
} else {
    $_SESSION['mensaje'] = "Error:".$sql;
    header("location:presupuesto.det.php?vcod_pp=".$_REQUEST['vcod_pp']);    
}
?>