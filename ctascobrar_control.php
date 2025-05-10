<?php

require './clases/conexion.php';

session_start();

$sql = "SELECT sp_ctas_cobrar(".$_REQUEST['accion'].","
        .$_REQUEST['vcodcta'].",".$_REQUEST['vvencod'].",'".
        $_REQUEST['vvto']."',".$_REQUEST['vimporte'].",".
        $_REQUEST['vcuo_nro'].",'".$_REQUEST['vestado']."') as ctascobrar;";
$resultado = consultas::get_datos($sql);


if ($resultado[0]['ctascobrar'] == null) {
    $_SESSION['mensaje'] = 'Error de Proceso '+$sql;
    header('location:./'.$_REQUEST['pagina']);
} else {
    $_SESSION['mensaje'] = $resultado[0]['ctascobrar']."_".$_REQUEST['accion'];

    header('location:./'.$_REQUEST['pagina']);
}
?>

