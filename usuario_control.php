<?php

require 'clases/conexion.php';


$sql ="select sp_usuario(".$_REQUEST['accion'].",
".(!empty($_REQUEST['vusu_cod'])?$_REQUEST['vusu_cod']:"0").", 
'".(!empty($_REQUEST['vusu_nick'])?$_REQUEST['vusu_nick']:"")."', 
'".(!empty($_REQUEST['vusu_clave'])?$_REQUEST['vusu_clave']:"")."', 
".(!empty($_REQUEST['vemp_cod'])?$_REQUEST['vemp_cod']:"0").", 
".(!empty($_REQUEST['vgru_cod'])?$_REQUEST['vgru_cod']:"0").", 
".(!empty($_REQUEST['vid_sucursal'])?$_REQUEST['vid_sucursal']:"0").") as resul";


session_start();
$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul']!=null) {
    $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje'] = $valor[0];
    header("location:".$valor[1]);
}else{
    $_SESSION['mensaje'] = "Error:".$sql;
    header("location:usuario.index.php");    
}

// Error:select sp_articulo(2, 2, '', 0, 'MEDIAS', 50000, 70000, 3) as resul
