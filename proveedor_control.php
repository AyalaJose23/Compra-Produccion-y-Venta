<?php

require 'clases/conexion.php';

$sql = "select sp_proveedores(".$_REQUEST['accion'].",".$_REQUEST['vprv_cod'].",'".$_REQUEST['vprv_ruc']."',
        '".$_REQUEST['vprv_razonsocial']."', 
        '".$_REQUEST['vprv_direccion']."','".$_REQUEST['vprv_telefono']."') as resul;";

session_start();
$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul']!=null) {
    $_SESSION['mensaje'] = $resultado[0]['resul'];
    header("location:proveedor.index.php");
}else{
     $_SESSION['mensaje'] = 'Error al insertar '.$sql;
    header("location:proveedor.index.php");
}
?>

