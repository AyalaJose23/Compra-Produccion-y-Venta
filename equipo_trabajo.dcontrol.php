<?php

require 'clases/conexion.php';

session_start();
$sql = "select sp_detalle_equipo(
    ".$_REQUEST['accion'].", ".$_REQUEST['vid_equipo'].", 
    ".(!empty($_REQUEST['vemp_cod'])?$_REQUEST['vemp_cod']:"0")."
    ) as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul'] != null) {
    $_SESSION['mensaje'] = $resultado[0]['resul'];
    header("location:equipo_trabajo.det.php?vid_equipo=" . $_REQUEST['vid_equipo']);
} else {
    $_SESSION['mensaje'] = "Error:" . $sql;
    header("location:equipo_trabajo.det.php?vid_equipo=" . $_REQUEST['vid_equipo']);
}
?>
