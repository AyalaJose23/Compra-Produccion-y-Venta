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
                            <h3 class="page-header text-center alert-info">
                                <strong>DETALLE FACTURA DE COMPRA</strong>
                                <a href="compras.index.php" class="btn btn-primary pull-right" rel="tooltip" title="Atras">
                                    <i class="glyphicon glyphicon-arrow-left"></i>
                                </a>
                            </h3>

                            <!-- Panel Datos Cabecera de la Orden -->
                            <div class="panel panel-info">
                                <div class="panel-heading"> 
                                    <strong>Datos Cabecera de la Compra</strong>
                                    
                                </div>
                                
                                <div class="panel-body">
                                    <?php 
                                    // Obtener los datos de la compra
                                    $compras = consultas::get_datos("SELECT * FROM v_compras WHERE com_cod = " . $_REQUEST['vcom_cod']);
                                    if (!empty($compras)) {
                                        $compra = $compras[0];
                                    ?>
                                    
                                    <!-- Mostrar el botón Confirmar solo si el estado es "PENDIENTE" -->
                                    <?php if ($compra['com_total'] !== '0') { ?>
                                        <a onclick="confirmar('<?php echo $compra['com_cod'] . "_" . $compra['proveedor'] . "_" . $compra['com_fecha']; ?>')" 
                                           class="btn btn-success btn-sm pull-right" data-title="Confirmar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#confirmar">
                                            <i class="fa fa-check"></i> 
                                        </a>
                                    <?php } ?>

                                    <div class="table-responsive">
                                                <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                        <th>#</th>
                                                        <th>Fecha</th>
                                                        <th>Proveedor</th>
                                                        <th>Timbrado</th>
                                                        <th>Validez</th>
                                                        <th>Condición</th>
                                                        <th>Total</th>
                                                        <th>Estado</th>
                                                     
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($compras as $compra) { ?>
                                                        <tr>
                                                        <td data-title="#"><?php echo $compra['com_cod'];?></td>
                                                        <td data-title="Fecha"><?php echo $compra['com_fecha'];?></td>
                                                        <td data-title="Proveedor"><?php echo $compra['proveedor'];?></td>
                                                        <td data-title="Timbrado"><?php echo $compra['com_timbrado'];?></td>
                                                        <td data-title="Validez"><?php echo $compra['tim_vz'];?></td>
                                                        <td data-title="Condicion"><?php echo $compra['tipo_compra'];?></td>
                                                        <td data-title="Total"><?php echo number_format($compra['com_total'],0,",",".");?></td>
                                                        <td data-title="Estado"><?php echo $compra['com_estado'];?></td>
                                                            
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
                                <!-- FIN CABECERA--> 
                                <div class="panel panel-info">
                                <div class="panel-heading">
                                    <strong>Detalle Items de la Orden N°<?php echo $compras[0]['orden_cod'];?></strong>
                                </div>
                                <div class="panel-body">
                                    <!-- INICIO DETALLE ORDEN-->
                                   <?php $ordendet = consultas::get_datos("select * from v_detalle_ordens where art_cod not in(select art_cod from v_detalle_compras where com_cod= ".$compras[0]['com_cod'].")  and orden_cod= ".$compras[0]['orden_cod']."");
                                     if (!empty($ordendet)) { ?>                                    
                                    
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-condensed table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Descripción</th>
                                                            <th>Cant.</th>
                                                            <th>Precio</th>
                                                            <th>Impuesto</th>
                                                            <th>Subtotal</th>
                                                            <th class="text-center">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($ordendet as $odet) { ?>
                                                        <tr>
                                                            <td data-title="#"><?php echo $odet['orden_cod'];?></td>
                                                            <td data-title="Descripción"><?php echo $odet['art_descri']." ".$odet['mar_descri'];?></td>
                                                            <td data-title="Cant."><?php echo $odet['orden_cant'];?></td>
                                                            <td data-title="Precio"><?php echo number_format($odet['orden_precio'],0,",",".");?></td>
                                                            <td data-title="Impuesto"><?php echo $odet['tipo_descri'];?></td>
                                                            <td data-title="Subtotal"><?php echo number_format($odet['subtotal'],0,",",".");?></td>
                                                            <td class="text-center">
                                                            <!-- Línea 125 -->
                                                                <a onclick="agregar(<?php echo $compras[0]['com_cod'];?>, <?php echo $odet['orden_cod'];?>, <?php echo $odet['art_cod'];?>)"
                                                                class="btn btn-success btn-sm" 
                                                                data-title="Agregar" rel="tooltip" 
                                                                data-placement="left" data-toggle="modal" data-target="#editar">
                                                                <i class="fa fa-plus"></i>
                                                                </a>                                                                 
                                                            </td>
                                                        </tr>  
                                                        <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                     <?php } ?>                                   
                                    <!-- FIN DETALLE PEDIDO compra-->   
                                    </div>
                                    </div>
                                    <!-- INICIO DETALLE-->
                                    <div class="panel panel-info">
                                <div class="panel-heading">
                                    <strong>Detalle de Compras</strong>
                                </div>
                                <div class="panel-body">                                              
                                            <?php $detalles = consultas::get_datos("select * from v_detalle_compras where com_cod =".$compras[0]['com_cod']); 
                                                if (!empty($detalles)) { ?>
                                           
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-condensed table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Descripción</th>
                                                            <th>Cant.</th>
                                                            <th>Precio</th>
                                                            <th>Impuesto</th>
                                                            <th>Subtotal</th>
                                                            <?php if ($compra['com_estado'] == 'REGISTRADO') { ?>
                                                            <th class="text-center">Acciones</th>
                                                            <?php } else { ?>
                                                                <?php }?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($detalles as $det) { ?>
                                                            <tr>
                                                                <td data-title="#"><?php echo $det['art_cod']; ?></td>
                                                                <td data-title="Descripción"><?php echo $det['art_descri'] . " " . $det['mar_descri']; ?></td>
                                                                <td data-title="Cant."><?php echo $det['com_cant']; ?></td>
                                                                <td data-title="Precio"><?php echo number_format($det['com_precio'], 0, ",", "."); ?></td>
                                                                <td data-title="Impuesto"><?php echo $det['tipo_descri']; ?></td>
                                                                <td data-title="Subtotal"><?php echo number_format($det['subtotal'], 0, ",", "."); ?></td>
                                                                <td class="text-center">
                                                                <?php if ($compra['com_estado'] == 'REGISTRADO') { ?> 
                                                                    <a onclick="editar(<?php echo $det['com_cod']; ?>, <?php echo $det['art_cod']; ?>)"
                                                                        class="btn btn-warning btn-sm" data-title="Editar" rel="tooltip" data-placement="left"
                                                                        data-toggle="modal" data-target="#editar">
                                                                        <i class="fa fa-edit"></i></a>
                                                                    <a onclick="borrar(<?php echo "'" . $det['com_cod'] . "_" . $det['art_cod'] . "_" . $det['art_descri'] . " " . $det['mar_descri'] . "'"; ?>)"
                                                                        class="btn btn-danger btn-sm" data-title="Quitar" rel="tooltip" data-placement="left"
                                                                        data-toggle="modal" data-target="#borrar">
                                                                        <i class="fa fa-trash-o"></i></a>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                        <?php } ?>
                                                    </tbody>

                                                </table>
                                            </div>
                                            <?php }else{ ?>
                                            <div class="alert alert-info">
                                                <span class="glyphicon glyphicon-info-sign"></span> 
                                                El pedido aún no tiene detalles cargados...
                                            </div>      
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <!-- FIN DETALLE-->  
                                                                                                            
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
        <script>
        $("#mensaje").delay(4000).slideUp(200,function(){
           $(this).alert('close'); 
        });
        </script>
        <script>
        function borrar(datos){
            var dat = datos.split('_');
            $('#si').attr('href', 'compras_dcontrol.php?vcom_cod=' + dat[0] + '&vart_cod=' + dat[1] + '&accion=3');
            $("#confirmacion").html('<span class="glyphicon glyphicon-warning-sign"></span> \n\
            Desea quitar el articulo <strong>' + dat[2] + '</strong> ?');
        };

        function precio(){
            var dat = $('#articulo').val().split('_');
            $('#vprecio').val(dat[1]);
        };
        function editar(com, art) {
            $.ajax({
                type: "GET",
                url: "/tdp/compras_dedit.php?vcom_cod=" + com + "&vart_cod=" + art,
                cache: false,
                beforeSend: function () {
                    $('#detalles').html('<img src="img/loader.gif" /><strong>Cargando...</strong>');
                },
                success: function (data) {
                    $('#detalles').html(data);
                }
            });
        };

        // Función en JS
                    function agregar(com, ord, art) {

                    $.ajax({
                        type: "GET",
                        url: "/tdp/compras_dadd.php?vcom_cod=" + com + "&vorden_cod=" + ord + "&vart_cod=" + art,
                        cache: false,

                    beforeSend: function() {
                        $('#detalles').html('<img src="img/loader.gif" /><strong>Cargando...</strong>');
                    },
                    success: function(data) {
                        $('#detalles').html(data);
                    }
                    })

                    };        
        function confirmar(datos){
            var dat = datos.split('_');
            $('#sic').attr('href','compras_control.php?vcom_cod='+dat[0]+'&accion=2');
            $("#confirmacionc").html('<span class="glyphicon glyphicon-info-sign"></span> \n\
            Desea confirmar la Compra N° <strong>'+dat[0]+'</strong> del proveedor <strong>'+dat[1]+'</strong> de fecha <strong>'+dat[2]+'</strong>')
        }           
        </script>        
    </body>
</html>


