
<?php

require 'clases/conexion.php';
session_start();

$sql = "select sp_detalle_preprod(
    ".$_REQUEST['accion'].",
    ".$_REQUEST['vcod_preprod'].",
    ".(!empty($_REQUEST['vcod_produ']) ? $_REQUEST['vcod_produ'] : "0") . ",
    ".(!empty($_REQUEST['vpreprod_cantidad'])?$_REQUEST['vpreprod_cantidad']:"0").",
    ".(!empty($_REQUEST['vpreprod_precio'])?$_REQUEST['vpreprod_precio']:"0").",
    ".(!empty($_REQUEST['exenta'])?$_REQUEST['exenta']:"0").",
    ".(!empty($_REQUEST['iva_5'])?$_REQUEST['iva_5']:"0").",
    ".(!empty($_REQUEST['iva_10'])?$_REQUEST['iva_10']:"0")."
) as resul";
$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul'] != null) {
    $_SESSION['mensaje'] = $resultado[0]['resul'];
    header("location:presu.prod.det.php?vcod_preprod=".$_REQUEST['vcod_preprod']);
} else {
    $_SESSION['mensaje'] = "Error:".$sql;
    header("location:presu.prod.det.php?vcod_preprod=".$_REQUEST['vcod_preprod']);    
}
