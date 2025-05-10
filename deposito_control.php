<?php

require 'clases/conexion.php';


$sql ="select sp_deposito(".$_REQUEST['accion'].",
".(!empty($_REQUEST['vdep_cod'])?$_REQUEST['vdep_cod']:"0").", 
'".(!empty($_REQUEST['vdep_descri'])?$_REQUEST['vdep_descri']:"")."', 
".(!empty($_REQUEST['vid_sucursal'])?$_REQUEST['vid_sucursal']:"0").") as resul";

session_start();
$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul']!=null) {
    $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje'] = $valor[0];
    header("location:".$valor[1]);
}else{
    $_SESSION['mensaje'] = "Error:".$sql;
    header("location:deposito.index.php");    
}

// Error:select sp_articulo(2, 2, '', 0, 'MEDIAS', 50000, 70000, 3) as resul
