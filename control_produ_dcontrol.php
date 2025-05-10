

<?php

require 'clases/conexion.php';

session_start();
$sql = "select sp_detalle_control(
    ".$_REQUEST['accion'].",
    ".$_REQUEST['vcod_control'].", 
    
    ".(!empty($_REQUEST['vcod_produ'])?$_REQUEST['vcod_produ']:"0")."


    ) as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul'] != null) {
    $_SESSION['mensaje'] = $resultado[0]['resul'];
    header("location:control.produ.det.php?vcod_control=" . $_REQUEST['vcod_control']);
} else {
    $_SESSION['mensaje'] = "Error:" . $sql;
    header("location:control.produ.det.php?vcod_control=" . $_REQUEST['vcod_control']);
}
?>
