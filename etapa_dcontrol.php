<?php

require 'clases/conexion.php';

session_start();
$sql = "select sp_detalle_etapa(
    ".$_REQUEST['accion'].",
    ".$_REQUEST['vcod_etapa'].", 
    ".(!empty($_REQUEST['vcod_etapa_p'])?$_REQUEST['vcod_etapa_p']:"0")."


    ) as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul'] != null) {
    $_SESSION['mensaje'] = $resultado[0]['resul'];
    header("location:etapa.det.php?vcod_etapa=" . $_REQUEST['vcod_etapa']);
} else {
    $_SESSION['mensaje'] = "Error:" . $sql;
    header("location:etapa.det.php?vcod_etapa=" . $_REQUEST['vcod_etapa']);
}
?>
