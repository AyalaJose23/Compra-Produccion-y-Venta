<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" href="img/mueble.png"/>
        <title>Todo Muebles - VENTAS</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <?php 
        session_start(); /* Reanudar sesión */
        require 'menu/css_lte.ctp'; /* Archivos CSS */ 
        ?>
    </head>
    <body class="hold-transition skin-green sidebar-mini">
        <div class="wrapper">
            <?php require 'menu/header_lte.ctp'; /* CABECERA PRINCIPAL */ ?>
            <?php require 'menu/toolbar_lte.ctp'; /* MENU PRINCIPAL */ ?>

            <div class="content-wrapper">
                <div class="content">
                    <div class="row">
                        <div class="col-lg-12 col-xs-12 col-md-12">
                                <?php if (!empty($_SESSION['mensaje'])) { ?>
                                    <div class="alert alert-danger" role="alert" id="mensaje">
                                            <span class="glyphicon glyphicon-exclamation-sign"></span>
                                            <?php echo $_SESSION['mensaje']; $_SESSION['mensaje']=''; ?>
                                    </div>
                                <?php } ?>

                                <div class="col-lg-12">
                                    <h3 class="page-header text-center"><strong>FACTURA DE VENTA</strong>
                                    <a href="/tdp/MANUAL DE USUARIO tdp.pdf" target="print">
                                    <span class="glyphicon glyphicon-question-sign"></span>
                                </a>
                                            <a href="ventas_anadir.php" id="btnAbrir" class="btn btn-success  pull-right" value="Abrir" rel="tooltip" data-placement="left" onclick="ven();">
                                                <i class="fa fa-plus"></i> AÑADIR
                                            </a>
                                        
                                </div>
                        </div>
                    </div>        

                                <div class="box-body no-padding">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                            <form method="post" accept-charset="utf-8" class="form-horizontal">
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="input-group custom-search-form">
                                                                <input type="search" name="buscar" class="form-control" placeholder="Ingrese valor a buscar..." autofocus="" />
                                                                <span class="input-group-btn">
                                                                    <button type="submit" class="btn btn-primary btn-flat" data-title="Buscar" rel="tooltip">
                                                                        <i class="fa fa-search"></i>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                            
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-success">
                                            <div class="panel-heading">
                                                Datos
                                            </div>                     
                                                    <!-- /.panel-heading -->
                                        <div class="panel-body">

                                            <?php
                                            $ventas = consultas::get_datos("SELECT * FROM v_ventas WHERE (id_venta::varchar || ven_fecha::varchar) ILIKE '%" . (isset($_REQUEST['buscar']) ? $_REQUEST['buscar'] : "") . "%' ORDER BY id_venta DESC");
                                            if (!empty($ventas)) {
                                            ?>
                                            <div class="table-responsive">
                                                <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                    <th class="success  text-center">#</th>
                                                    <th class="success">Fecha Venta</th>
                                                    <th class="success">Cliente</th>
                                                    <th class="success">Condicion</th>
                                                    <th class="success">Total</th>
                                                    <th class="success ">Estado </th>
                                                    <th class="success text-right">Acciones</th>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($ventas as $ven) { ?>
                                                        <tr onclick="seleccion($(this));">
                                                            <td class="text-center">
                                                                <a style="color:green;" target="blank" href="arqueo.php?id=<?php echo $ven['id_venta']; ?>">
                                                                    <?php echo $ven['id_venta']; ?>
                                                                </a>
                                                            </td>
                                                            <td><?php echo $ven['ven_fecha']; ?></td>
                                                        <td data-title="Cliente"><?php echo $ven['cliente'];?></td>
                                                            <td><?php echo $ven['ven_tipo']; ?></td>
                                                            <td ><?php echo number_format($ven['ven_total'], 0, ',', '.'); ?></td>
                                                            <td><?php echo $ven['ven_estado']; ?></td>
                                                             <td data-title="Acciones" class="text-right">

                                                                <?php if ($ven['ven_estado'] =='CONFIRMADO') { ?> 
                                                                    <a href="ventas_print.php?vid_venta=<?php echo $ven['id_venta']; ?>"
                                                                        target="_blank" class="btn btn-sm btn-default" rel="tooltip" data-title="imprimir">
                                                                <span class="glyphicon glyphicon-print"></span></a>
                                                            <?php } else { ?>
                                                                     <?php } ?>
                                                                
                                                                   <?php if ($ven['ven_total'] > 0 && $ven['ven_estado'] == 'PENDIENTE') { ?>   
                                                                    <a onclick="confirmar(<?php echo "'".$ven['id_venta']."_".$ven['cod_preprod']."'";?>)" 
                                                                       class="btn btn-primary btn-sm" data-title="Confirmar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#confirmar">
                                                                    <i class="fa fa-check"></i></a>   
                                                                            
                                                                    
                                                                <?php }
                                                                if($ven['ven_estado']=='PENDIENTE' || $ven['ven_estado']=='REGISTRADO' ){?>
                                                                      <a onclick="anular(<?php echo "'".$ven['id_venta']."_".$ven['cod_preprod']."_".$ven['cli_cod']."_".$ven['ven_nrofactura']."_".$ven['ven_fecha']."'";?>)" 
                                                                    class="btn btn-danger btn-sm" data-title="Anular" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#anular">
                                                                    ANULAR
                                                                    </a>
                                                                        
                                                                                                                                                                                                                                           
                                                                <?php }?>

                                                                <a href="ventas_det.php?vid_venta=<?php echo $ven['id_venta'];?>" class="btn btn-success btn-sm" data-title="Detalles" rel="tooltip" data-placement="left">
                                                                      <i class="fa fa-list"></i></a>
                                                                

                                                                    
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php } else { ?>
                                            <div class="alert alert-info flat">
                                                <span class="glyphicon glyphicon-info-sign"></span>
                                                No se han registrado ventas.
                                            </div>
                                            <?php } ?>
                                </div>
                            </div>
                        </div>
                            
                   
                    </div>
                </div>
            </div>
            <?php require 'menu/footer_lte.ctp'; /* ARCHIVOS JS */ ?>

            <!-- MODAL CONFIRMAR-->
            <div class="modal" id="confirmar" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                  <h4 class="modal-title custom_align">Atención!!!</h4>
                        </div>
                        <div class="modal-body">
                                  <div class="alert alert-success" id="confirmacionc"></div>
                        </div>
                        <div class="modal-footer">
                                  <a id="sic" role="buttom" class="btn btn-primary">
                                      <span class="glyphicon glyphicon-ok-sign"></span> SI
                                  </a>
                                  <button type="button" class="btn btn-default" data-dismiss="modal">
                                      <span class="glyphicon glyphicon-remove"></span> NO
                                  </button>
                        </div>
                    </div>
                </div>
            </div>
                  <!-- FIN MODAL CONFIRMAR-->      
                  <!-- MODAL ANULAR-->
                <div class="modal" id="anular" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                  <h4 class="modal-title custom_align">Atención!!!</h4>
                                </div>
                              <div class="modal-body">
                                  <div class="alert alert-danger" id="confirmacion"></div>
                              </div>
                              <div class="modal-footer">
                                  <a id="si" role="buttom" class="btn btn-primary">
                                      <span class="glyphicon glyphicon-ok-sign"></span> SI
                                  </a>
                                  <button type="button" class="btn btn-default" data-dismiss="modal">
                                      <span class="glyphicon glyphicon-remove"></span> NO
                                  </button>
                              </div>
                        </div>
                    </div>
                </div>
                  <!-- FIN MODAL ANULAR-->    
            <!-- MODAL cierre-->
            
                <div class="modal" id="cierreModal" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                <h4 class="modal-title custom_align">Atención!!!</h4>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-danger" id="confirmacion"></div>
                            </div>
                            <div class="modal-footer">
                                <a id="si" role="button" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-ok-sign"></span> SI
                                </a>
                                <button type="button" class="btn btn-default" data-dismiss="modal">
                                    <span class="glyphicon glyphicon-remove"></span> NO
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FIN MODAL cierre-->
                    
                <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->

            <script>
                $("#mensaje").delay(4000).slideUp(200, function() {
                    $(this).alert('close');
                });
            </script>
            <script>
       function anular(datos){
            var dat = datos.split('_');

            $('#si').attr('href', 'ventas_control.php?vid_venta=' + dat[0] + '&accion=2' );
                          
            $("#confirmacion").html('<span class="glyphicon glyphicon-warning-sign mensaje-anulacion">Desea anular el Presupuesto N° <strong>'+dat[0]+'</strong> de fecha <strong>'+dat[4]+'</strong></span>');

            $("#confirmacion").html('<span class="glyphicon glyphicon-warning-sign"></span> \n\
            Desea anular la Venta N° <strong>'+dat[0]+'</strong> de fecha <strong>'+dat[4]+'</strong>')
        }
        function confirmar(datos){
            var dat = datos.split('_');
            $('#sic').attr('href', 'ventas_control.php?vid_venta=' + dat[0] + '&vcod_preprod=' + dat[1] +'&accion=3' );

            $("#confirmacionc").html('<span class="glyphicon glyphicon-info-sign"></span> \n\
            Desea confirmar la Venta N° <strong>'+dat[0]+'</strong> de fecha <strong>'+dat[1]+'</strong>')
        }       
        </script>


            <!--script>
                
                function stockar() {
                var cant = parseInt($('#cantstock').val());
                var canti = parseInt($('#cantiar').val());
                if (canti > 0) {
                    if (parseInt($('#cantiar').val()) > cant) {
                        notificacion('Atencion', 'SOLO HAY ' + cant +
                                ' UNIDADES DE ESTE ARTICULO', 'window.alert(message);');
                        $('#cantiar').val('0');
//                            calsubtotal();
                    }
                } else {
                    $('#cantiar').val('0');
                    {
                        notificacion('Atencion', 'NO PUEDE ESTAR VACIO  ', 'window.alert(message);');
//                                       
                    }
//                        calsubtotal();
                }
            }

            </script-->


        

            </div>
        </div>
    </body>
</html>
