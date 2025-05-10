<?php

require 'clases/conexion.php';


$sql = "select sp_clientes(".$_REQUEST['accion'].",
        ".$_REQUEST['vcli_cod'].",
        ".(!empty($_REQUEST['vcli_ci'])?$_REQUEST['vcli_ci']:"0").",
        '".(!empty($_REQUEST['vcli_nombre'])?$_REQUEST['vcli_nombre']:"")."',
        '".(!empty($_REQUEST['vcli_apellido'])?$_REQUEST['vcli_apellido']:"")."',
        '".(!empty($_REQUEST['vcli_telefono'])?$_REQUEST['vcli_telefono']:"")."',
        '".(!empty($_REQUEST['vcli_direcc'])?$_REQUEST['vcli_direcc']:"")."'
        ) as resul;";

session_start();
$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul']!=null) {
    $_SESSION['mensaje'] = $resultado[0]['resul'];
    header("location:cliente.index.php");
}else{
     $_SESSION['mensaje'] = 'Error al insertar '.$sql;
    header("location:cliente.anadir.php");
}
?>

