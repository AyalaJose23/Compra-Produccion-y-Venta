<?php 
require 'clases/conexion.php'; 
session_start(); 

// Obtener id_apercierre actual de la apertura
$consulta_apertura = "SELECT id_apercierre FROM apertura_cierres WHERE estado_aper = 'ABIERTA' ORDER BY id_apercierre DESC LIMIT 1";
$resultado_apertura = consultas::get_datos($consulta_apertura);

// Validar si existe una apertura activa
$id_apercierre = !empty($resultado_apertura) ? $resultado_apertura[0]['id_apercierre'] : 0;

$sql = "select sp_ventas(".$_REQUEST['accion'].", 
        ". (!empty($_REQUEST['vid_venta']) ? $_REQUEST['vid_venta'] : "0") . ",
        '". (!empty($_REQUEST['vven_tipo']) ? $_REQUEST['vven_tipo'] : "") . "',
        ". (!empty($_REQUEST['vven_intervalo']) ? $_REQUEST['vven_intervalo'] : "0") . ", 
        ". (!empty($_REQUEST['vven_cantcuotas']) ? $_REQUEST['vven_cantcuotas'] : "0") . ", 
        ". (!empty($_REQUEST['vcli_cod']) ? $_REQUEST['vcli_cod'] : "0") . ", 
        ".$_SESSION['emp_cod'].", 
        ".(!empty($_REQUEST['vtimb_cod']) ? $_REQUEST['vtimb_cod'] : "1").",   
        ". $id_apercierre . ",
        " . (!empty($_REQUEST['vven_nrofactura']) ? $_REQUEST['vven_nrofactura'] : "0") . ",
        " . (!empty($_REQUEST['vcod_preprod']) ? $_REQUEST['vcod_preprod'] : "0") . ",
        " . (!empty($_REQUEST['vped_cod']) ? $_REQUEST['vped_cod'] : "0") . "
        ) as resul";


//var_dump($_REQUEST);
$resultado = consultas::get_datos($sql); 

if ($resultado[0]['resul'] != null) { 
    $valor = explode("*", $resultado[0]['resul']); 
    $_SESSION['mensaje'] = $valor[0]; 
    header("location:".$valor[1]); 
} else { 
    $_SESSION['mensaje'] = "Error:".$sql; 
    header("location:ventas_index.php"); 
}
