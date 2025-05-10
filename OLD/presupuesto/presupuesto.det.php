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
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="fa fa-money"></i><i class="fa fa-list"></i> 
                                    <h3 class="box-title">Agregar Detalle Presupuesto de Compras</h3>
                                    <div class="box-tools">
                                   
                                        <?php  $presupuestos = consultas::get_datos("select * FROM v_pp WHERE cod_pp = ( select max(cod_pp) from v_pp)");
                                        
                                        ?>
                                        <!--<a onclick="confirmar(</?php echo "'".$presupuestos[0]['cod_pp']."_".$presupuestos[0]['proveedor']."_".$presupuestos[0]['pp_fecha']."'";?>)" 
                                         class="btn btn-success btn-sm" data-title="Confirmar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#confirmar">
                                         <i class="fa fa-check"></i></a>-->
                                         
                                        <a href="presupuesto.index.php" class="btn btn-primary btn-sm" data-title="Volver" rel="tooltip" data-placement="left">
                                            <i class="fa fa-arrow-left"></i> VOLVER</a>                                            
                                    </div>
                                </div>
                                <div class="box-body">
                                    
                                <!-- INICIO CABECERA-->
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                         <?php
                                             
                                            if (!empty($presupuestos)) { ?>
                                            <div class="table-responsive">
                                                <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                        <th>#</th>
                                                        <th>Fecha</th>
                                                        <th>Validez</th>
                                                        <th>Proveedor</th>
                                                        <th>Total</th>
                                                        <th>Observaciones</th>
                                                        <th>Estado</th>
                                                     
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($presupuestos as $presu) { ?>
                                                        <tr>
                                                        <td data-title="#"><?php echo $presu['cod_pp'];?></td>
                                                        <td data-title="Fecha"><?php echo $presu['pp_fecha'];?></td>
                                                        <td data-title="Vlidez"><?php echo $presu['pp_validez'];?></td>
                                                        <td data-title="Proveedor"><?php echo $presu['proveedor'];?></td>
                                                        <td data-title="Total"><?php echo number_format($presu['monto'],0,",",".");?></td>
                                                        <td data-title="Observaciones"><?php echo $presu['pp_obs'];?></td>
                                                        <td data-title="Estado"><?php echo $presu['estado'];?></td>
                                                            
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
                           <!-- INICIO FORM AGREGAR PEDIDO--> 
                           <?php
                               $pedidosdetas = consultas::get_datos("select * from v_detalle_pedcompra where art_cod not in(select art_cod from v_detalle_pp where cod_pp = ".$presupuestos[0]['cod_pp'].")  and ped_com= ".$presupuestos[0]['ped_com']."");
                                   
                                if (!empty($pedidosdetas)) {
                            ?>
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="fa fa-money"></i><i class="fa fa-list"></i> 
                                    <h3 class="box-title">Detalle Pedido de Compra</h3>
                                    <div class="box-tools">
                                <!-- /.panel-heading -->
                                </div>
                                </div>
                                <div class="box-body">
                                <!--                                    <div>-->
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center"> Articulo</th>
                                            <th class="text-center"> Cantidad</th>
                                            <th class="text-center"> Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody class="buscar">
                                        <?php foreach ($pedidosdetas as $pedidosdeta) { ?> 
                                            <tr>
                                                <td class="text-center"><?php echo $pedidosdeta['ped_com']; ?></td>
                                                <td class="text-center"><?php echo $pedidosdeta['art_descri']." ".$pedidosdeta['mar_descri'];?></td>
                                                <td class="text-center"><?php echo $pedidosdeta['ped_cant']; ?></td>
                                                <td class="text-center">
                                                    <a onclick="confirm(<?php
                                                        echo "'" . $pedidosdeta['ped_com'] . "_" .
                                                        $pedidosdeta['art_cod'] . "_" . $pedidosdeta['art_descri'] . "_" . $pedidosdeta['ped_cant'] . "'";
                                                        ?>)" 


                                                        class="btn btn-success btn-sm" 
                                                                data-title="Agregar" rel="tooltip" 
                                                                data-placement="left" data-toggle="modal" data-target="#confirm">
                                                                <i class="fa fa-plus"></i>


                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>  
                            <?php } ?>
                        </div>
                    </div>
                                            <!--FIN DETALLE PEDIDO-->
                                    
                                    <!-- INICIO DETALLE-->
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">   
                                        <?php $detalles = consultas::get_datos("select * from v_detalle_pp where cod_pp =".$presupuestos[0]['cod_pp']);  
                                                                                          
                                                if (!empty($detalles)) { ?>
                                            <div class="box-header">
                                                <i class="fa fa-list"></i>
                                                <h3 class="box-title">Detalle Items</h3>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-condensed table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Descripción</th>
                                                            <th>Cant.</th>
                                                            <th>Precio/u</th>
                                                            <th>Sub Total</th>
                                                            <th>Estado</th>
                                                            <th class="text-center">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($detalles as $det) { ?>
                                                            <tr>
                                                                <td data-title="#"> <?php echo $det['art_cod']; ?> </td>
                                                                <td data-title="Descripción"> <?php echo $det['articulo']; ?> </td>
                                                                <td data-title="Cant."> <?php echo $det['cantidad']; ?> </td>
                                                                <td data-title="Precio"> <?php echo number_format($det['precio'], 0, ",", "."); ?> </td>
                                                                <td data-title="Subtotal"> <?php echo number_format($det['det_presu_subtotal'], 0, ",", "."); ?> </td>
                                                                <td data-title="Estado"> <?php echo $det['presu_estado']; ?> </td>
                                                                <td class="text-center">
                                                                    <a onclick="editar(<?php echo $det['cod_pp']; ?>, <?php echo $det['art_cod']; ?>)" class="btn btn-warning btn-sm" data-title="Editar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#editar">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                                    <a onclick="borrar(<?php echo "'".$det['cod_pp']."_".$det['art_cod']."_".$det['articulo']."'"; ?>)" class="btn btn-danger btn-sm" data-title="Quitar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#borrar">
                                                                        <i class="fa fa-trash-o"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>

                                                </table>
                                            </div>
                                            <?php }else{ ?>
                                            <div class="alert alert-info">
                                                <span class="glyphicon glyphicon-info-sign"></span> 
                                                El presupuesto aún no tiene detalles cargados...
                                            </div>      
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <!-- FIN DETALLE-->  
                                    
                </div>
            </div>
                 
                  <!--confirmar-->

                  <div class="modal" id="confirm" role="dialog">
                      <div class="modal-dialog">
                          <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" 
                                    data-dismiss="modal" arial-label="Close">x</button>
                            <h4 class="modal-title"><strong>Registrar el precio del Presupuesto</strong></h4>
                        </div>
                        <form action="presupuesto_dcontrol.php" method="post" accept-charset="utf-8" class="form-horizontal">
                            <div class="panel-body">
                            <input name="accion" value="1" type="hidden"/>
                            <input type="hidden" name="vcod_pp" value="<?php echo $_REQUEST['vcod_pp'] ?>">
                                <input type="hidden" name="vestado" value="PENDIENTE">
                                <input type="hidden"  id="art" name="varti" value="0">
                                <input type="hidden"  id="subtotal" name="vsubt" value="0">

                                <span class="col-md-1"></span>
                                <div class="form-group">
                                    <div class="col-md-5">
                                        <label class="col-md-2 control-label"><h3>Articulo</h3></label>
                                        <input  type="text" required="" readonly=""
                                                placeholder="Especifique articulo"
                                                class="form-control" id="artic">

                                    </div>

                                   
                                    <div class="col-md-3">
                                        <label class="col-md-2 control-label"><h3>Cantidad</h3></label>
                                        <input  id="canti" type="number" required="" readonly=""
                                                placeholder="Especifique Cantidad"
                                                class="form-control" min="1" 
                                                required  name="vcant"
                                                value="0" >

                                    </div>
                                    <br>


                                </div>
                                <BR>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">Precio:</label>
                                    <div class="col-md-6"> 

                                        <input   type="number" required=""
                                                 placeholder="Especifique precio"
                                                 class="form-control"
                                                 required min="100"  name="vprecio" id="prec"
                                                 value="0">
                                    </div>
                                </div>



                                <div class="modal-footer">
                                    <button type="reset" data-dismiss="modal" class="btn btn-default pull-left">
                                        <i class="fa fa-close"></i> Cerrar</button>
                                    <button type="submit" class="btn btn-primary pull-right">
                                        <i class="fa fa-refresh"></i> Registrar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <!--fin de confirmar--> 
            <?php require 'menu/footer_lte.ctp'; ?><!--ARCHIVOS JS-->                 
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
                function confirm(datos) {
                    var dat = datos.split("_");
                    $('#cod').val(dat[0]);
                    $('#art').val(dat[1]);
                    $('#artic').val(dat[2]);
                    $('#canti').val(dat[3]);
                    console.log(dat[2]);
                }
                function borrar(datos) {
                    var dat = datos.split('_');
                    $('#si').attr('href', 'presupuesto_dcontrol.php?vcod_pp=' + dat[0] + '&vart_cod=' + dat[1] + '&accion=3');
                    $("#confirmacion").html('<span class="glyphicon glyphicon-warning-sign"></span> \\n\\ Desea quitar el articulo <strong>' + dat[2] + '</strong> ?');
                }

                function editar(com, art) {
                    $.ajax({
                        type: "GET",
                        url: "/tdp/presupuesto_dedit.php?vcod_pp=" + com + "&vart_cod=" + art,
                        cache: false,
                        beforeSend: function () {
                            $('#detalles').html('<img src="img/loader.gif" /><strong>Cargando...</strong>');
                        },
                        success: function (data) {
                            $('#detalles').html(data);
                        }
                    });
                }
               

                

              /*  function agregar(com, art) {
                    $.ajax({
                        type: "GET",
                        url: "/tdp/presupuesto_dadd.php?vcod_pp=" + com + "&vart_cod=" + art,
                        cache: false,
                        beforeSend: function () {
                            $('#detalles').html('<img src="img/loader.gif" /><strong>Cargando...</strong>');
                        },
                        success: function (data) {
                            $('#detalles').html(data);
                        }
                    });
                }
                */
                function confirmar(datos) {
                    var dat = datos.split('_');
                    $('#sic').attr('href', 'presupuesto_control.php?vcod_pp=' + dat[0] + '&accion=2');
                    $("#confirmacionc").html('<span class="glyphicon glyphicon-info-sign"></span> \\n\\ Desea confirmar el presupuesto N° <strong>' + dat[0] + '</strong> del proveedor <strong>' + dat[1] + '</strong> de fecha <strong>' + dat[2] + '</strong>')
                }
            </script>
                    
    </body>
</html>


