<?php

require './clases/conexion.php';

session_start();

$sql = "SELECT sp_ctas_pagar(".$_REQUEST['accion'].","
        .$_REQUEST['vcodctapag'].",".$_REQUEST['vcomcod'].",'".
        $_REQUEST['vvto']."',".$_REQUEST['vimporte'].",".
        $_REQUEST['vcuo_nro'].",'".$_REQUEST['vestado']."') as ctaspagar;";
$resultado = consultas::get_datos($sql);


if ($resultado[0]['ctaspagar'] == null) {
    $_SESSION['mensaje'] = 'Error de Proceso '+$sql;
    header('location:./'.$_REQUEST['pagina']);
} else {
    $_SESSION['mensaje'] = $resultado[0]['ctaspagar']."_".$_REQUEST['accion'];

    header('location:./'.$_REQUEST['pagina']);
}
?>
