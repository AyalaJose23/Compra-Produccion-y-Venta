<?php

require 'clases/conexion.php';


$sql ="select sp_articulo(".$_REQUEST['accion'].",
".$_REQUEST['vart_cod'].",
'".(!empty($_REQUEST['vart_codbarra'])?$_REQUEST['vart_codbarra']:"")."', 
".(!empty($_REQUEST['vmar_cod'])?$_REQUEST['vmar_cod']:"0").",
'".(!empty($_REQUEST['vart_descri'])?$_REQUEST['vart_descri']:"")."',
".(!empty($_REQUEST['vtmp_cod'])?$_REQUEST['vtmp_cod']:"0").",  
".(!empty($_REQUEST['vart_precioc'])?$_REQUEST['vart_precioc']:"0").", 
".(!empty($_REQUEST['vart_preciov'])?$_REQUEST['vart_preciov']:"0").", 
".(!empty($_REQUEST['vtipo_cod'])?$_REQUEST['vtipo_cod']:"0").",
'".(!empty($_REQUEST['vart_estado'])?$_REQUEST['vart_estado']:"")."'
) as resul";

session_start();
$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul']!=null) {
    $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje'] = $valor[0];
    header("location:".$valor[1]);
}else{
    $_SESSION['mensaje'] = "Error:".$sql;
    header("location:articulo.index.php");    
}

// Error:select sp_articulo(2, 2, '', 0, 'MEDIAS', 50000, 70000, 3) as resul
