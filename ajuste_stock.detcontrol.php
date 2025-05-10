<?php
require './clases/conexion.php';
session_start();
//$articulo = explode("_", $_REQUEST['varti']);

$sql = "SELECT sp_detalle_ajuste(".$_REQUEST['accion'].","
        .$_REQUEST['vajuste'].","
        .$_REQUEST['varti'].","
        .$_REQUEST['vdep'].",'"
        .$_REQUEST['vmotivo']."',"
        .$_REQUEST['vcant'].",'"
        .$_REQUEST['vdescri']."','"
        .$_REQUEST['vestado']."',"
        .$_REQUEST['vcant_logica'].") as detalle_ajustes;";
        
        

$resultado = consultas::get_datos($sql);

if ($resultado[0]['detalle_ajustes']== null) {
    $_SESSION['mensaje'] = 'Error de Proceso '+$sql;
    header ('location:./'.$_REQUEST['pagina']);
}else {
    $_SESSION['mensaje'] = $resultado[0]['detalle_ajustes']."_".
            $_REQUEST['accion'];
    
    header('location:./'.$_REQUEST['pagina']."?vajuste=".
            $_REQUEST['vajuste']);
}
?>

