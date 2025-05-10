<?php

require 'clases/conexion.php';


$sql ="select sp_stock(".$_REQUEST['accion'].",
 split_part('".$_REQUEST['vart_cod']."','_',1)::integer,
".(!empty($_REQUEST['vdep_cod'])?$_REQUEST['vdep_cod']:"0").", 
".(!empty($_REQUEST['vcant_minima'])?$_REQUEST['vcant_minima']:"0").", 
".(!empty($_REQUEST['vstoc_cant'])?$_REQUEST['vstoc_cant']:"0").") as resul";

session_start();
$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul']!=null) {
    $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje'] = $valor[0];
    header("location:".$valor[1]);
}else{
    $_SESSION['mensaje'] = "Error:".$sql;
    header("location:stock.index.php");    
}

// ".(!empty($_REQUEST['vart_cod'])?$_REQUEST['vart_cod']:"0").",
//    split_part('".$_REQUEST['vart_cod']."','_',1)::integer,
  //  split_part('".$_REQUEST['vdep_cod']."','_',1)::integer,