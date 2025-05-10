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
    <body class="hold-transition skin-green sidebar-mini">
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
                                        <h3 class="page-header text-center alert-success"> <strong>PRESUPUESTO DE VENTA</strong>
                                            <a href="presu.prod.index.php" 
                                            class="btn btn-success pull-right" 
                                            rel='tooltip' title="Atras">
                                                <i class="glyphicon glyphicon-arrow-left"></i>
                                            </a> 

                                        </h3>
                                    </div>     
                                    <!--Buscador-->

                                </div>
                                <!-- /.row -->

                                
                                
                                <!--INICIO cabecera-->
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <strong>Datos Cabecera de Presupuestos</strong>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                            <?php
                                             $presupuestos = consultas::get_datos("select * from v_presu_prod where cod_preprod= ".$_REQUEST['vcod_preprod'].""); 
                                            if (!empty($presupuestos)) { ?>
                                            <div class="table-responsive">
                                                <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                        <th>#</th>
                                                        <th>Fecha</th>
                                                        <th>Cliente</th>
                                                        <th>Total</th>
                                                        <th>Estado</th>
                                                     
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($presupuestos as $presu) { ?>
                                                        <tr>
                                                        <td data-title="#"><?php echo $presu['cod_preprod'];?></td>
                                                        <td data-title="Fecha"><?php echo $presu['preprod_fecha'];?></td>
                                                        <td data-title="cliente"><?php echo $presu['clientes'];?></td>
                                                        <td data-title="Total"><?php echo number_format($presu['preprod_monto'],0,",",".");?></td>
                                                        <td data-title="Estado"><?php echo $presu['preprod_estado'];?></td>
                                                            
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                          <?php  }else{ ?>
                                            <div class="alert alert-info flat">
                                                <span class="glyphicon glyphicon-info-sign"></span>
                                                No se encontraron registros..
                                            </div>
                                            
                                         <?php   } ?>
                                        </div>
                                    </div>
                                    </div>
                                    
                                   
                                <!-- FIN CABECERA--> 
                                
                                    <!-- INICIO DETALLE PEDIDO-->
                                    <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <strong>Detalle Producto del Pedido N°<?php echo $presupuestos[0]['cod_preprod'];?></strong>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                     
                                       <?php  $pedidodet = consultas::get_datos("select * from v_detalle_pedventa where cod_produ not in(select cod_produ from v_detalle_preprod where cod_preprod = ".$presupuestos[0]['cod_preprod'].")  and ped_cod= ".$presupuestos[0]['ped_cod']."");
                                    if (!empty($pedidodet)) { ?>                                    
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">                                                
                                            
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-condensed table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Descripción</th>
                                                            <th>Cant.</th>
                                                            <?php if ($presu['preprod_estado'] == 'REGISTRADO') { ?>
                                                            <th class="text-center">Acciones</th>
                                                            <?php } else { ?>
                                                                <?php }?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($pedidodet as $pdet) { ?>
                                                        <tr>
                                                            <td data-title="#"><?php echo $pdet['cod_produ'];?></td>
                                                            <td data-title="Descripción"><?php echo $pdet['produ_descri'];?></td>
                                                            <td data-title="Cant."><?php echo $pdet['ped_cant'];?></td>
                                                            <td class="text-center"> 
                                                            <?php if ($presu['preprod_estado'] == 'REGISTRADO') { ?>   
                                                                <a onclick="agregar(<?php echo $presupuestos[0]['cod_preprod'];?>,
                                                                <?php echo $pdet['ped_cod'];?>,
                                                                <?php echo $pdet['cod_produ'];?>)" 
                                                                class="btn btn-success btn-sm" data-title="Agregar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#editar"> 
                                                                <i class="fa fa-plus"></i></a> </td>
                                                        </tr>  
                                                        <?php }?>
                                                        <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                     <?php } ?>                           
                                    <!-- FIN DETALLE PEDIDO VENTA-->   
                                    </div>
                                    </div>
                                    </div>
                                    <!-- INICIO DETALLE PRESUPUESTO PRODUCCION-->
                                    <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <strong>Detalle de Presupuestos</strong>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12">                                          
                                          
                                            <?php $detalles = consultas::get_datos("select * from v_detalle_preprod where cod_preprod =".$presupuestos[0]['cod_preprod']);  
                                                if (!empty($detalles)) { ?>
                                            
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-condensed table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Descripción</th>
                                                            <th>Cant.</th>
                                                            <th>Precio/u</th>
                                                            <th>Impuesto</th>
                                                            <th>Subtotal</th>
                                                            <?php if ($presu['preprod_estado'] == 'REGISTRADO') { ?>
                                                            <th class="text-center">Acciones</th>
                                                            <?php } else { ?>
                                                                <?php }?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($detalles as $det) { ?>
                                                            <tr>
                                                                <td data-title="#"> <?php echo $det['cod_produ']; ?> </td>
                                                                <td data-title="Descripción"> <?php echo $det['produ_descri']; ?> </td>
                                                                <td data-title="Cant."> <?php echo $det['preprod_cantidad']; ?> </td>
                                                                <td data-title="Precio"> <?php echo number_format($det['preprod_precio'], 0, ",", "."); ?> </td>
                                                                <td data-title="Impuesto"> <?php echo $det['tipo_descri']; ?> </td>
                                                                <td data-title="Subtotal"> <?php echo number_format($det['subtotal'], 0, ",", "."); ?> </td>
                                                                <td class="text-center">

                                                                <?php if ($presu['preprod_estado'] == 'REGISTRADO') { ?>   
                                                                    
                                                                    <a onclick="borrar(<?php echo "'".$det['cod_preprod']."_".$det['cod_produ']."_".$det['produ_descri']."'"; ?>)" class="btn btn-danger btn-sm" data-title="Quitar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#borrar">
                                                                        <i class="fa fa-trash-o"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <?php }?>
                                                        <?php } ?>
                                                    </tbody>

                                                </table>
                                            </div>
                                            <?php }else{ ?>
                                            <div class="alert alert-info">
                                                <span class="glyphicon glyphicon-info-sign"></span> 
                                                El aún no tiene detalles cargados...
                                            </div>      
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <!-- FIN DETALLE PRESUPUESTO PRODUCCION-->  
                                                                                                          
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                  <?php require 'menu/footer_lte.ctp'; ?><!--ARCHIVOS JS-->
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
                  <!-- MODAL BORRAR-->
                  <div class="modal" id="borrar" role="dialog">
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
                  <!-- FIN MODAL BORRAR-->  
                  <!-- MODAL EDITAR-->
                  <div class="modal" id="editar" role="dialog">
                      <div class="modal-dialog">
                          <div class="modal-content" id="detalles">
                          </div>
                      </div>
                  </div>
                  <!-- FIN MODAL EDITAR-->                   
            </div>                  
        <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
        <!-- ARCHIVOS JS -->
            <script>
                $("#mensaje").delay(4000).slideUp(200, function () {
                    $(this).alert('close');
                });
            </script>

            <script>
                function borrar(datos) {
                    var dat = datos.split('_');
                    $('#si').attr('href', 'presu_prod_dcontrol.php?vcod_preprod=' + dat[0] + '&vcod_produ=' + dat[1] + '&accion=3');
                    $("#confirmacion").html('<span class="glyphicon glyphicon-warning-sign"></span> \\n\\ Desea quitar el producto <strong>' + dat[2] + '</strong> ?');
                }

                function precio() {
                    var dat = $('#articulo').val().split('_');
                    $('#vprecio').val(dat[1]);
                }  
                


                function editar(com, art) {
                    $.ajax({
                        type: "GET",
                        url: "/tdp/presu_dedit.php?vcod_preprod=" + com + "&vart_cod=" + art,
                        cache: false,
                        beforeSend: function () {
                            $('#detalles').html('<img src="img/loader.gif" /><strong>Cargando...</strong>');
                        },
                        success: function (data) {
                            $('#detalles').html(data);
                        }
                    });
                }
                
                function agregar(com, pr, art) {
                    $.ajax({
                        type: "GET",
                        url: "/tdp/presu.prod_dadd.php?vcod_preprod=" + com + "&vped_cod=" + pr + "&vcod_produ=" + art,
                        cache: false,
                        
                        beforeSend: function () {
                                $('#detalles').html(`
                                    <div style="display: flex; justify-content: center; align-items: center; height: 50vh;">
                                        <img src="img/loader.gif" width="50" height="50" />
                                        <strong style="margin-left: 10px;">Cargando...</strong>
                                    </div>
                                `);
                            },

                            success: function (data) {
                            setTimeout(function() {
                                $('#detalles').html(data);
                            }, 300); // Retraso de segundos
                        }
                    });
                }

                

                function confirmar(datos) {
                    var dat = datos.split('_');
                    $('#sic').attr('href', 'presu.prod_control.php?vcod_preprod=' + dat[0] + '&accion=2');
                    $("#confirmacionc").html('<span class="glyphicon glyphicon-info-sign"></span> \\n\\ Desea confirmar la Compra N° <strong>' + dat[0] + '</strong> del cliente <strong>' + dat[1] + '</strong> de fecha <strong>' + dat[2] + '</strong>')
                }
            </script>
                    
    </body>
</html>


