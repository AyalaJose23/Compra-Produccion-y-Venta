<?php

require 'clases/conexion.php';


$sql ="select sp_pagina(".$_REQUEST['accion'].",
".(!empty($_REQUEST['vpag_cod'])?$_REQUEST['vpag_cod']:"0").", 
'".(!empty($_REQUEST['vpag_direc'])?$_REQUEST['vpag_direc']:"")."', 
'".(!empty($_REQUEST['vpag_nombre'])?$_REQUEST['vpag_nombre']:"")."', 
".(!empty($_REQUEST['vmod_cod'])?$_REQUEST['vmod_cod']:"0").") as resul";

session_start();
$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul']!=null) {
    $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje'] = $valor[0];
    header("location:".$valor[1]);
}else{
    $_SESSION['mensaje'] = "Error:".$sql;
    header("location:pagina.index.php");    
}

// Error:select sp_articulo(2, 2, '', 0, 'MEDIAS', 50000, 70000, 3) as resul
