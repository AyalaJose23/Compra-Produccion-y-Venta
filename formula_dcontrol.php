<?php

require 'clases/conexion.php';

session_start();
$sql = "select sp_detalle_formula(
    ".$_REQUEST['accion'].",
    ".$_REQUEST['vcod_formula'].", 
    ".(!empty($_REQUEST['vart_cod'])?$_REQUEST['vart_cod']:"0").", 
    ".(!empty($_REQUEST['vformula_cant'])?$_REQUEST['vformula_cant']:"0").",
    ".(!empty($_REQUEST['vcod_prece'])?$_REQUEST['vcod_prece']:"0")."


    ) as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul'] != null) {
    $_SESSION['mensaje'] = $resultado[0]['resul'];
    header("location:formula.det.php?vcod_formula=" . $_REQUEST['vcod_formula']);
} else {
    $_SESSION['mensaje'] = "Error:" . $sql;
    header("location:formula.det.php?vcod_formula=" . $_REQUEST['vcod_formula']);
}
?>
