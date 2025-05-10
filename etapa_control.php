<?php

require 'clases/conexion.php';
session_start();

$sql = "select sp_etapa(
".$_REQUEST['accion'].",
" . (!empty($_REQUEST['vcod_etapa']) ? $_REQUEST['vcod_etapa'] : "0") . ",
'".(!empty($_REQUEST['vetapa_descrip'])?$_REQUEST['vetapa_descrip']:"")."',
".$_SESSION['emp_cod'].",
" . (!empty($_REQUEST['vprodu']) ? $_REQUEST['vprodu'] : "0") . "

) as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul']!=null) {
   $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje']=$valor[0];
    header("location:".$valor[1]);
}else{
    $_SESSION['mensaje']="Error:".$sql;
    header("location:etapa.index.php");    
}

//,'".$_REQUEST['vpp_validez'] . "'