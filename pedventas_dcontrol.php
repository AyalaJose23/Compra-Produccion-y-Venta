<?php

require 'clases/conexion.php';

session_start();

// Verificar si los valores vienen completos
$sql = "select sp_detalle_pedventa(" . $_REQUEST['accion'] . ","
        . $_REQUEST['vped_cod'] . ","
        . "split_part('" . $_REQUEST['vcod_produ'] . "','_',1)::integer,"
        . (!empty($_REQUEST['vped_cant']) ? $_REQUEST['vped_cant'] : "0") . ","
        . (!empty($_REQUEST['vcod_color']) ? $_REQUEST['vcod_color'] : "NULL") . ","
        . (!empty($_REQUEST['vped_precio']) ? $_REQUEST['vped_precio'] : "0") . ") as resul";
        
// Ejecutar la consulta
$resultado = consultas::get_datos($sql);

// Verificar el resultado de la consulta
if ($resultado[0]['resul'] != null) {
    // Guardar el mensaje de éxito en la sesión
    $_SESSION['mensaje'] = $resultado[0]['resul'];
    
    // Redirigir a la página de presupuesto o detalles del pedido
    header("location:pedventas.det.php?vped_cod=" . $_REQUEST['vped_cod']);
} else {
    // Guardar el mensaje de error en la sesión
    $_SESSION['mensaje'] = "Error:" . $sql;
    
    // Redirigir de vuelta a la página del pedido
    header("location:pedventas.det.php?vped_cod=" . $_REQUEST['vped_cod']);
}

?>

