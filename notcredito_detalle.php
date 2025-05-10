<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon"  href=" img/mueble.png"/>
        <title>Todo Muebles</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <?php 
        session_start();/*Reanudar sesion*/
        require 'menu/css_lte.ctp'; ?><!--ARCHIVOS CSS-->

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php require 'menu/header_lte.ctp'; ?><!--CABECERA PRINCIPAL-->
            <?php require 'menu/toolbar_lte.ctp';?><!--MENU PRINCIPAL-->
            <div class="content-wrapper">
                <div class="content">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <?php if(!empty($_SESSION['mensaje'])){ ?>
                            <div class="alert alert-danger" role="alert" id="mensaje">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                <?php echo $_SESSION['mensaje'];
                                $_SESSION['mensaje'] = '' ;?>
                            </div>
                            <?php } ?>
                            <div class="content">
                                <div class="row">
                                    <!--impresion del titulo de la pagina-->
                                    <div class="col-lg-12">
                                        <h3 class="page-header text-center alert-info"> <strong>DETALLE NOTA CREDITO COMPRA</strong>
                                            <a href="notacredito_c.index.php" 
                                            class="btn btn-primary pull-right" 
                                            rel='tooltip' title="Atras">
                                                <i class="glyphicon glyphicon-arrow-left"></i>
                                            </a> 

                                        </h3>
                                    </div>     
                                    <!--Buscador-->
                                </div>
                                <!--INICIO cabecera-->
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <strong>Datos Cabecera de la Factura</strong>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                            <?php
                            $creditos = consultas::get_datos("select * from v_notacreditocompra where cod_nota_comp=" .
                                            $_REQUEST ['vdetcred'] . " order by cod_nota_comp asc ");
                               if (!empty($creditos)) {
                            ?> 
                            
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table width="100%"
                                           class="table table-bordered">
                                        <thead>
                                            <tr class="primary-font">
                                                <th class="text-center">#</th>
                                                <th class="text-center"># COMPRA</th>                                        
                                                <th class="text-center">FECHA</th>                                        
                                                <th class="text-center">MOTIVO</th>                                        
                                                <th class="text-center">DESCUENTO</th>                                        
                                                <th class="text-center">MONTO</th>
                                                <th class="text-center">USUARIO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($creditos as $credito) { ?> 
                                                <tr>
                                                    <td class="text-center">
                                                        <?php echo $credito['cod_nota_comp']; ?></td>
                                                    <td class="text-center"><?php echo $credito['com_cod'] . " - " . $credito['nro_com']; ?></td>
                                                    <td class="text-center"><?php echo $credito['nota_cred_fecha']; ?></td>
                                                    <td class="text-center"><?php echo $credito['cred_moti']; ?></td>
                                                    <td class="text-center"><?php echo $credito['cred_descuento']; ?></td>
                                                    <td class="text-center"><?php echo number_format($credito['credi_total'], 0, ',', '.'); ?></td>
                                                    <td class="text-center"><?php echo $credito['emp_nombre']; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>                         
                                </div>
                            </div>
                            <?php } else { ?>
                                        <div class="col-md-12">
                                        <div class="alert alert-info alert-dismissable">
                                            <button type="button" class="close"
                                                    data-dismiss="alert" aria-hidden="true">&times;
                                            </button>
                                            <strong>Numero de nota de credito repetido, favor verificar....!</strong>
                                        </div>
                                    </div>
                                <?php } ?> 
                        </div>
                        </div>
                        </div>

                         <!-- comienzo para el detalle de COMPRA-->

                         <?php
                        $detanotas = consultas::get_datos
                                        ("select * from  v_notacreditocompradetalle"
                                        . " where cod_nota_comp=" . $_REQUEST['vdetcred'] .
                                        "order by cod_nota_comp asc");
                        ?>


                                    <!-- INICIO DETALLE -->
                                    <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <strong>DETALLE DE LA NOTA DE CREDITO </strong>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                            <?php if (!empty($detanotas)) { ?>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center"> ARTICULO</th>
                                                <th class="text-center"> CANTIDAD</th>
                                                <th class="text-center"> PRECIO</th>
                                                <th class="text-center"> DEVOLUCION</th>
                                                <th class="text-center"> TOTAL DEVO.</th>
                                                <th class="text-center"> SOBRANTE</th>
                                                <th class="text-center"> SUBTOTAL</th>
                                                <th class="text-center"> IVA 5</th>
                                                <th class="text-center"> GRABADA 5</th>
                                                <th class="text-center"> IVA 10</th>
                                                <th class="text-center"> GRABADA 10</th>
                                                <th class="text-center"> ESTADO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($detanotas as $detanota) { ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $detanota['cod_nota_comp']; ?></td>
                                                    <td class="text-center"><?php echo $detanota['art_descri']; ?></td>
                                                    <td class="text-center"><?php echo number_format($detanota['det_nota_cred_cant'], 0, ',', '.'); ?></td>
                                                    <td class="text-center"><?php echo number_format($detanota['det_not_cred_ptecio'], 0, ',', '.'); ?></td>
                                                    <td class="text-center"><?php echo number_format($detanota['det_not_cred_devolucion'], 0, ',', '.'); ?></td>
                                                    <td class="text-center"><?php echo number_format($detanota['det_nota_cred_subt'], 0, ',', '.'); ?></td>
                                                    <td class="text-center"><?php echo number_format($detanota['cant_total_sobrante'], 0, ',', '.'); ?></td>
                                                    <td class="text-center"><?php echo number_format($detanota['sub_cal_sobran'], 0, ',', '.'); ?></td>
                                                    <td class="text-center"><?php echo number_format($detanota['iva_5'], 0, ',', '.'); ?></td>
                                                    <td class="text-center"><?php echo number_format($detanota['gravada_5'], 0, ',', '.'); ?></td>
                                                    <td class="text-center"><?php echo number_format($detanota['iva_10'], 0, ',', '.'); ?></td>
                                                    <td class="text-center"><?php echo number_format($detanota['gravada_10'], 0, ',', '.'); ?></td>
                                                    <td class="text-center"><?php echo $detanota['det_nota_cred_estado']; ?></td>
                                                    <th class="text-center">
<!--                                                        <a onclick="borrar(<?php
                                                        echo "'" . $detanota['cod_nota_comp'] . "_" .
                                                                  $_REQUEST['vdetcred'] . "_" .
                                                                  $_REQUEST['vcompr'] . "_" .
                                                        $detanota['art_cod'] . "_" .
                                                        $detanota['det_not_cred_ptecio'] . "_" .
                                                        $detanota['det_nota_cred_cant'] . "_" .
                                                        $detanota['det_nota_cred_subt'] . "_" .
                                                        $detanota['det_not_cred_devolucion'] . "_" .
                                                        $detanota['det_nota_cred_estado'] . "_" .
                                                        $detanota['cant_total_sobrante'] . "'";
                                                        ?>)"
                                                           class="btn btn-xs btn-danger"
                                                           ret='tooltip' data-title="Borrar"
                                                           data-toggle='modal'
                                                           data-target='#delete'>
                                                            <span class="glyphicon glyphicon-trash">
                                                            </span></a>-->
                                                    </th>

                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                <?php } else { ?>
                                    <div class="col-md-12">
                                        <div class="alert alert-info alert-dismissable">
                                            <button type="button" class="close"
                                                    data-dismiss="alert" aria-hidden="true">&times;
                                            </button>
                                            <strong>No se encontraron detalles de la nota....!</strong>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <?php if (isset($_REQUEST['vcompr'])) { ?>
                        <?php 
                        $detacompras = consultas::get_datos("
                            SELECT v_detalle_compras.* 
                            FROM v_detalle_compras 
                            JOIN compras 
                            ON v_detalle_compras.com_cod = compras.com_cod 
                            WHERE compras.com_estado = 'C' 
                            AND v_detalle_compras.com_cod = " . $_REQUEST['vcompr']
                        ); 
                        ?>
                    <?php } ?>
                    </div>
                </div>

                    

 <?php if (isset($creditos[0]['cod_nota_comp'])) { ?>
                        <?php if ($credito['nota_cred_estado'] == 'ACTIVO') { ?> 
                         <?php } ?> 
                            <?php if (!empty($detacompras)) {
                                ?>   
                                <div class="panel-heading">
                                    <?php if ($credito['cred_moti'] == 'DEVOLUCION') { ?>
                                        
                                    </div>
                                    <!-- /.panel-heading -->
                                     <!-- INICIO DETALLE PRESUPUESTO PRODUCCION-->
                                    <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <strong>Detalle de Compra</strong>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12">         

                                    <div class="table-responsive">
                                        <!--                                    <div>-->
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center"> ARTICULO</th>
                                                    <th class="text-center"> CANTIDAD</th>
                                                    <th class="text-center"> PRECIO</th>
                                                    <th class="text-center"> ACCION</th>


                                                <?php } else { ?>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody class="buscar">
                                            <?php foreach ($detacompras as $detacompra) { ?> 
                                                <tr>
                                                    <?php if ($credito['cred_moti'] == 'DEVOLUCION') { ?>
                                                        <td class="text-center"><?php echo $detacompra['com_cod']; ?></td>
                                                        <td class="text-center"><?php echo $detacompra['art_descri']; ?></td>
                                                        <td class="text-center"><?php echo number_format($detacompra['com_cant'], 0, ',', '.'); ?></td>
                                                        <td class="text-center"><?php echo number_format($detacompra['com_precio'], 0, ',', '.'); ?></td>
                                                        <td class="text-center">
                                                            <?php if ($credito['nota_cred_estado'] == 'ACTIVO') { ?>  
                                                                <a onclick="notacredi(<?php
                                                                echo "'" . $detacompra['com_cod'] . "_" . $detacompra['art_descri'] . "_" . 
                                                                $detacompra['art_cod'] . "_" . $detacompra['com_precio'] . "'";
                                                                ?>);" 
                                                                   class="btn btn-xs btn-primary" rel='tooltip' data-title="Confirmar" 
                                                                   data-toggle="modal" data-target="#editar">
                                                                    <span class="glyphicon glyphicon-ok-sign"></span></a>
                                                                    
                                                                        <a onclick="confirmar(<?php
                                                        echo "'" . $_REQUEST['vdetcred'] . "_" .
                                                        $detacompra['art_cod'] . "_" .
                                                        $detacompra['com_precio'] . "_" .
                                                        $detacompra['com_cant'] . "_" .
                                                        
                                                        $_REQUEST ['vcompr'] . "'"
                                                        ?>)"
                                                           class="btn btn-xs btn-danger" rel='tooltip' data-title="NO DEVOLVER"
                                                           data-toggle="modal"
                                                           data-target="#delete">
                                                            <span class="glyphicon glyphicon-remove-sign"></span></a>
                                                       
                                                                    
                                                            <?php } else { ?>
                                                            <?php } ?>


                                                        <?php } else { ?>
                                                        <?php } ?>

                                                    </td>
                                                </tr>

                                            <?php } ?>
                                        </tbody>
                                    </table>  

                                <?php } else { ?>

                                <?php } ?>

                            </div>
                        <?php } else { ?>
                        <?php } ?>


                        <?php if (isset($_REQUEST['vdetcred'])) { ?>
                            <?php $detanotas = consultas::get_datos("select * from v_nota_cre_compdet_iva where  cod_nota_comp= " . $_REQUEST ['vdetcred']); ?>

                        <?php } ?> 

                        <div class="panel-body">

                            <?php if (!empty($detanotas)) {
                                ?>   
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <strong> DETALLE DEL IVA</strong>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12">

                                <div class="table-responsive">
                                    <!--                                    <div>-->
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center"> TOTAL IVA 5</th>
                                                <th class="text-center">TOTAL  IVA 10</th>
                                                <th class="text-center"> TOTAL EXENTA</th>
                                                <th class="text-center">TOTAL IVA</th>

                                            </tr>
                                        </thead>
                                        <tbody class="buscar">
                                            <?php foreach ($detanotas as $detanota) { ?> 
                                                <tr>
                                                    <td class="text-center"><?php echo number_format($detanota['total_iva5'], 0, ',', '.'); ?></td>
                                                    <td class="text-center"><?php echo number_format($detanota['total_iva10'], 0, ',', '.'); ?></td>
                                                    <td class="text-center"><?php echo number_format($detanota['total_exenta'], 0, ',', '.'); ?></td>
                                                    <td class="text-center"><?php echo number_format($detanota['total_ivas'], 0, ',', '.'); ?></td>


                                                </tr>

                                            <?php } ?>
                                        </tbody>
                                    </table>  

                                <?php } else { ?>

                                <?php } ?>

                            </div>
                        </div>
                        
                        <div id="editar" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-lg ">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" 
                                                data-dismiss="modal" arial-label="Close">x</button>
                                        <h4 class="modal-title"><strong>REGISTRAR NOTA DE CREDITO </strong></h4>
                                    </div>
                                    <form action="notacred_det_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                        <div class="panel-body">
                                            <input name="accion" value="1" type="hidden"/>
                                            <input type="hidden" name="pagina" value="notcredito_detalle.php">
                                            <input type="hidden" name="vdetcred" value="<?php echo $_REQUEST['vdetcred'] ?>">
                                            <input type="hidden" name="vcompr" value="<?php echo $_REQUEST['vcompr'] ?>">
                                            <input type="hidden" name="vestado" value="ACTIVO">
                                            <input type="hidden"  id="subtotal" name="vsubt" value="0">
                                            <input type="hidden"  id="articod" name="varti" value="0">
                                            <input type="hidden"  id="depocod" name="vdepo" value="0">


                                            <span class="col-md-1"></span>
                                            <div class="form-group">

                                                <div class="col-md-5">
                                                    <label class="col-md-2 control-label"><h3>ARTICULO</h3></label>
                                                    <input  type="text" required="" readonly=""
                                                            placeholder="Especifique articulo"
                                                            class="form-control" id="art">

                                                </div>
                                                </div>

                                                <span class="col-md-1"></span>
                                            <div class="form-group">
                                                <div class="col-md-5"> 
                                                    <label class="col-md-2 control-label"><h3>PRECIO:</h3></label>
                                                    <input   type="number" required=""readonly=""
                                                             placeholder="Especifique precio"
                                                             class="form-control" id="prec"
                                                             min="100"  name="vprecio"
                                                             value="0">
                                                </div>

                                                <div class="col-md-3">
                                                    <label class="col-md-2 control-label"><h3>Cantidad</h3></label>
                                                    <input  type="number" required="" readonly=""
                                                            placeholder="Especifique Cantidad"
                                                            class="form-control" id="cant" 
                                                            min="1" name="vcant"
                                                            onchange="calsubtotal(), stock()"
                                                            onkeyup="calsubtotal(), stock()"

                                                            value ="0" >

                                                </div>


                                            </div>

                                            <div class="form-group">
                                                <span class="col-md-1"></span>

                                                <div class="col-md-5">
                                                    <label class="col-md-2 control-label"><h3>DEVOLUCION</h3></label>
                                                    <input   type="number" required=""
                                                             placeholder="Especifique devolucion"
                                                             class="form-control"  
                                                             required  id="devolu"
                                                             onchange="calsubtotal(), stock()"
                                                             onkeyup="calsubtotal(), stock()"
                                                             onmouseup="calsubtotal()"

                                                             name="vdevol"
                                                             value="0" >

                                                </div>

                                                <div class="col-md-5">
                                                    <label class="col-md-2 control-label"><h3>TOTAL</h3></label>
                                                    <input   type="number" required=""
                                                             placeholder="Especifique devolucion"
                                                             class="form-control" min="1" 
                                                             required  name="vsobrante" readonly=""

                                                             value="0"  id="total">

                                                </div>
                                            </div>



                                            <div class="modal-footer">
                                                <button type="reset" data-dismiss="modal" class="btn btn-default pull-left">
                                                    <i class="fa fa-close"></i> CERRAR</button>
                                                <button type="submit" class="btn btn-primary pull-right">
                                                    <i class="fa fa-refresh"></i> REGISTRAR</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>


                <div class="modal fade" id="delete" tabindex="-1" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title custom_align" id="Heading">Atenci&oacute;n!!!</h4>
                            </div>
                            <div class="modal-body">

                                <div class="alert alert-warning" id="confirmacion"></div>

                            </div>
                            <div class="modal-footer">
                                <a id="si" role="button" class="btn btn-primary" ><span class="glyphicon glyphicon-ok-sign"></span> Si</a>
                                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
                            </div>
                        </div>
                    </div>
                </div> 



            </div>



        </div> 

                         
        <!--archivos js-->  
        <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
        <script>
            function notacredi(datos) {
                var dat = datos.split("_");
                $('#cod').val(dat[0]);
                $('#art').val(dat[1]);
                $('#articod').val(dat[2]);
                $('#cant').val(dat[3]);
                $('#prec').val(dat[4]);
                calsubtotal();
            }

            function calsubtotal() {
                $('#total').val(parseInt($('#cant').val()) - parseInt($('#devolu').val()));
            }


            function stock() {
                var cant = parseInt($('#devolu').val());
                var canti = parseInt($('#cant').val());
                if (cant > 0) {
                    if (parseInt($('#devolu').val()) > canti) {
                        notificacion('Atencion','SOLO HAY ' + canti +
                                ' EN ESTA NOTA DE CREDITO','window.alert(message);');
                        $('#devolu').val(canti);
                        calsubtotal();

                    }
                } else {
                    $('#devolu').val('0');
                    {
                        notificacion('Atencion','ESTA VACIO ','window.alert(message);');
                    }
calsubtotal();
                }
            }


            $("document").ready(function () {
                calsubtotal();
            });


            function borrar(datos) {
                var dat = datos.split("_");
                $('#si').attr('href',
                        'notacred_det_control.php?vdetcred=' + dat[1] +
                        '&vcompr=' + dat[2] +
                        '&varti=' + dat[3] +
                        '&vprecio=null' +
                        '&vcant=null'  +
                        '&vdevol=null' +
                        '&vestado=null' +
                        '&vsobrante=null'+
                        '&accion=3' +
                        '&pagina=notcredito_detalle.php');
                $('#confirmacion').html
                        ('<span class="glyphicon glyphicon-warning-sign"></span>\n\
               Desea borrar el detalle?');
            }
                  function confirmar(datos) {
            var dat = datos.split("_");
            $('#si').attr('href',
                    'notacred_det_control.php?vdetcred=' + dat[0] +
                    '&varti=' + dat[1] +
                    '&vprecio=' + dat[2] +
                    '&vcant=' + dat[3] +
                    '&vdevol=0'+ 
                    '&vsobrante=' + dat[4] +
                    '&vestado=ACTIVO'+
                    '&vcompr=' + dat[7] +
                    '&accion=1' +
                    '&pagina=notcredito_detalle.php');
            $('#confirmacion').html
                    ('<span class="glyphicon glyphicon-warning-sign"></span>\n\
                No desea devolver este item del Detalle de Compra?');

        }


        </script>
                   

</body>
</html>