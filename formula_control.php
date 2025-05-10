<?php

require 'clases/conexion.php';
session_start();

$sql = "select sp_formula(
".$_REQUEST['accion'].",
" . (!empty($_REQUEST['vcod_formula']) ? $_REQUEST['vcod_formula'] : "0") . ",
'".(!empty($_REQUEST['vformula_descrip'])?$_REQUEST['vformula_descrip']:"")."',
".$_SESSION['emp_cod'].",
" . (!empty($_REQUEST['vprodu']) ? $_REQUEST['vprodu'] : "0") . "

) as resul";

$resultado = consultas::get_datos($sql);

if ($resultado[0]['resul']!=null) {
   $valor = explode("*", $resultado[0]['resul']);
    $_SESSION['mensaje']=$valor[0];
    header("location:formula.index.php");
}else{
    $_SESSION['mensaje']="Error:".$sql;
    header("location:formula.index.php");    
}

//,'".$_REQUEST['vpp_validez'] . "'