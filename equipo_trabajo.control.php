<?php

require 'clases/conexion.php';
session_start();

$sql = "select sp_equipo(
".$_REQUEST['accion'].",
" . (!empty($_REQUEST['vid_equipo']) ? $_REQUEST['vid_equipo'] : "0") . ",
'".(!empty($_REQUEST['vnombre_equipo'])?$_REQUEST['vnombre_equipo']:"")."'
) as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul']!=null) {
   $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje']=$valor[0];
    header("location:equipo_trabajo.index.php");
}else{
    $_SESSION['mensaje']="Error:".$sql;
    header("location:equipo_trabajo.index.php");    
}

//,'".$_REQUEST['vpp_validez'] . "'