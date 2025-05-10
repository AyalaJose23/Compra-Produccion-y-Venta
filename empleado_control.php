<?php

require 'clases/conexion.php';


$sql = "select sp_empleado(".$_REQUEST['accion'].", 
 ".(!empty($_REQUEST['vemp_cod'])?$_REQUEST['vemp_cod']:"0").",
 ".(!empty($_REQUEST['vcar_cod'])?$_REQUEST['vcar_cod']:"0").", 
  '".(!empty($_REQUEST['vemp_nombre'])?$_REQUEST['vemp_nombre']:"")."', 
  '".(!empty($_REQUEST['vemp_apellido'])?$_REQUEST['vemp_apellido']:"")."', 
  '".(!empty($_REQUEST['vemp_direcc'])?$_REQUEST['vemp_direcc']:"")."', 
  '".(!empty($_REQUEST['vemp_tel'])?$_REQUEST['vemp_tel']:"")."') as resul;";

session_start();
$resultado = consultas::get_datos($sql);


if ($resultado[0]['resul']!=null) {
    $_SESSION['mensaje'] = $resultado[0]['resul'];
    header("location:empleado.index.php");
}else{
     $_SESSION['mensaje'] = 'Error al insertar '.$sql;
    header("location:empleado.index.php");
}
?>