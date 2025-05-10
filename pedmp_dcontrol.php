<?php

require 'clases/conexion.php';

session_start();

$sql = "select sp_detalle_pedmp(
" . $_REQUEST['accion'] . ",
".$_REQUEST['vped_mp'] . ",
". "split_part('" . $_REQUEST['vart_cod'] . "','_',1)::integer,"
. (!empty($_REQUEST['vped_cant']) ? $_REQUEST['vped_cant'] : "0") . ") as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul'] != null) {
    $_SESSION['mensaje'] = $resultado[0]['resul'];
    header("location:pedmp.det.php?vped_mp=" . $_REQUEST['vped_mp']);
} else {
    $_SESSION['mensaje'] = "Error:" . $sql;
    header("location:pedmp.det.php?vped_mp=" . $_REQUEST['vped_mp']);
   
}
?>
