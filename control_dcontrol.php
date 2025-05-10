

<?php

require 'clases/conexion.php';

session_start();
$sql = "select sp_detalle_control_et(
    ".$_REQUEST['accion'].",
    ".$_REQUEST['vcod_control'].", 
    ".$_REQUEST['vcod_produ'].",
    ' ".(!empty($_REQUEST['vobs'])?$_REQUEST['vobs']:"")."'
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
