<?php

require 'clases/conexion.php'; 
session_start(); 

if ($_REQUEST['accion'] == "1") {
    $cod = "select coalesce(max(id_cobros),0)+ 1 as codigo from cobros";
    $res = consultas::get_datos($cod);
    $codche = "select coalesce(max(cod_cheque),0)+ 1 as codigocheque from cobro_cheque";
    $resche = consultas::get_datos($codche);
    $codtarj = "select coalesce(max(cod_tarjeta),0)+ 1 as codigotarjeta from cobro_tarjeta";
    $restarj = consultas::get_datos($codtarj);

    $efectivo = ($_REQUEST['importe']) ? $_REQUEST['importe'] : 0;
    $sql = "insert into cobros values(
            " . $res[0]['codigo'] . ",
            ".$_REQUEST['vape'] . ",
            '" .$_REQUEST['fecha'] . "',
            " .$efectivo . ",
            '" .$_REQUEST['estado'] . "',
            " .$_REQUEST['vemp'] . ",
            " .$_REQUEST['vcli_cod'] . ",
            " .$_REQUEST['vformacobro'] . ",
            " .$_REQUEST['vrecibo'] . ",
            '" .$_REQUEST['vrecinume'] . "'
            )";
    $resultado = consultas::ejecutar_sql($sql);

    foreach ($_REQUEST['detalle'] as $key => $detCob) {
        $punto = $detCob[3][3];
        $det = "insert into detalle_cobros values(" . $res[0]['codigo'] . "," . $detCob[0][0] . "," . (str_replace(".", "", $punto)) . ",'" . $detCob[1][1] . "')";
        $resuldet = consultas::ejecutar_sql($det);
    }

    if ($_REQUEST['importech'] != 0) {
        $sql1 = "insert into cobro_cheque values(
        " . $res[0]['codigo'] . ",
        " .$resche[0]['codigocheque'] . ",
        " .$_REQUEST['vtipo'] . ",
        " .$_REQUEST['banco'] . ",
        " .$_REQUEST['nrocheq'] . ",
        '" .$_REQUEST['vfechacheque'] . "',
        " .$_REQUEST['importech'] . ",
        '" .$_REQUEST['vtitular'] . "'
        )";
        $resultado1 = consultas::ejecutar_sql($sql1);
    }
    
    $codche2 = "select coalesce(max(cod_cheque),0)+ 1 as codigocheque2 from cobro_cheque";
    $resche2 = consultas::get_datos($codche2);
    
    if ($_REQUEST['importech2'] != 0) {
        $sql4 = "insert into cobro_cheque values(
        " . $res[0]['codigo'] . ",
        " .$resche2[0]['codigocheque2'] . ",
        " .$_REQUEST['vtipo2'] . ",
        " .$_REQUEST['banco2'] . ",
        " .$_REQUEST['nrocheq2'] . ",
        '" .$_REQUEST['vfechacheque2'] . "',
        " .$_REQUEST['importech2'] . ",
        '" .$_REQUEST['vtitular2'] . "'
        )";
        $resultado4 = consultas::ejecutar_sql($sql4);
    }
    $codche3 = "select coalesce(max(cod_cheque),0)+ 1 as codigocheque3 from cobro_cheque";
    $resche3 = consultas::get_datos($codche3);
    
    if ($_REQUEST['importech3'] != 0) {
        $sql6 = "insert into cobro_cheque values(
        " . $res[0]['codigo'] . ",
        " .$resche3[0]['codigocheque3'] . ",
        " .$_REQUEST['vtipo3'] . ",
        " .$_REQUEST['banco3'] . ",
        " . $_REQUEST['nrocheq3'] . ",
        '" .$_REQUEST['vfechacheque3'] . "',
        " .$_REQUEST['importech3'] . ",
        '" .$_REQUEST['vtitular3'] . "'
        )";
        $resultado6 = consultas::ejecutar_sql($sql6);
    }
    

    if ($_REQUEST['importarj'] != 0) {
        $sql2 = "insert into cobro_tarjeta values(
        " . $res[0]['codigo'] . ",
        " .$restarj[0]['codigotarjeta'] . ",
        " .$_REQUEST['vtipotarj'] . ",
        " .$_REQUEST['entidad'] . ",
        " .$_REQUEST['nrotarj'] . ",
        " .$_REQUEST['importarj'] . ",
        " .$_REQUEST['voucher'] . ",
        " .$_REQUEST['vpost'] . ")";
        $resultado2 = consultas::ejecutar_sql($sql2);
    }
    
    $codtarj2 = "select coalesce(max(cod_tarjeta),0)+ 1 as codigotarjeta2 from cobro_tarjeta";
    $restarj2 = consultas::get_datos($codtarj2);
    
    if ($_REQUEST['importarj2'] != 0) {
        $sql5 = "insert into cobro_tarjeta values(
        " . $res[0]['codigo'] . ",
        " .$restarj2[0]['codigotarjeta2'] . ",
        " .$_REQUEST['vtipotarj2'] . ",
        " .$_REQUEST['entidad2'] . ",
        " .$_REQUEST['nrotarj2'] . ",
        " .$_REQUEST['importarj2'] . ",
        " .$_REQUEST['voucher2'] . ",
        " .$_REQUEST['vpost2'] . "
        )";
        $resultado5 = consultas::ejecutar_sql($sql5);
    }
    
    $codtarj3 = "select coalesce(max(cod_tarjeta),0)+ 1 as codigotarjeta3 from cobro_tarjeta";
    $restarj3 = consultas::get_datos($codtarj3);
    
    if ($_REQUEST['importarj3'] != 0) {
        $sql7 = "insert into cobro_tarjeta values(
        " . $res[0]['codigo'] . ",
        " .$restarj3[0]['codigotarjeta3'] . ",
        " .$_REQUEST['vtipotarj3'] . ",
        " .$_REQUEST['entidad3'] . ",
        " .$_REQUEST['nrotarj3'] . ",
        " .$_REQUEST['importarj3'] . ",
        " .$_REQUEST['voucher3'] . ",
        " .$_REQUEST['vpost3'] . "
        )";
        $resultado7 = consultas::ejecutar_sql($sql7);
    }
}



if ($resultado == FALSE) {
    $json['mensaje'] = "Ocurrio un error";
    $json['success'] = FALSE;
    $_SESSION['mensaje'] = 'Error de Proceso ' + $sql;
    header("location:cobros.php"); 
} else {
    $json['mensaje'] = "Grabado con exito";
    $json['success'] = TRUE;
}
echo json_encode($json);

if($_REQUEST['accion'] == "3"){
 
    $sql_anular = " update cobros set cob_estado= '" .$_REQUEST['estado']."' where id_cobros=" . $_REQUEST['codigo'];
    $resul_anular = consultas::ejecutar_sql($sql_anular);
   
    
    if ($resul_anular == FALSE) {
        $_SESSION['mensaje'] = 'Error de Proceso '+$sql;
        header ('location:./'.$_REQUEST['pagina']);
    } else {
        $_SESSION['mensaje'] = "COBRO ANULADO CON EXITO_".$_REQUEST['accion'];
        header('location:./'.$_REQUEST['pagina']);
    }
    echo json_encode($json);
}
?>


