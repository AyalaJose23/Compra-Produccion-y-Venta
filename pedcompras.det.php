<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" href="img/mueble.png"/>
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
                        <div class="col-lg-12 col-xs-12 col-md-12">
                            <?php if (!empty($_SESSION['mensaje'])) { ?>
                            <div class="alert alert-danger" role="alert" id="mensaje">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                <?php echo $_SESSION['mensaje'];
                                $_SESSION['mensaje']='';?>
                            </div>
                             <?php } ?>
                             <div class="content">
                                <div class="row">
                                    <!--impresion del titulo de la pagina-->
                                    <div class="col-lg-12">
                                        <h3 class="page-header text-center alert-info"> <strong>DETALLE PEDIDO DE COMPRA</strong>
                                            <a href="pedcompras.index.php" 
                                            class="btn btn-primary pull-right" 
                                            rel='tooltip' title="Atras">
                                                <i class="glyphicon glyphicon-arrow-left"></i>
                                            </a> 

                                        </h3>
                                    </div>     
                                    <!--Buscador-->

                                </div>
                                <!-- /.row -->
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <strong>Datos Cabecera de Pedidos</strong>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                    
                                            <?php
                                             $pedidos = consultas::get_datos("select * from v_pedido_cabcompra where ped_com =(select max(ped_com) from v_pedido_cabcompra)"); 
                                            if (!empty($pedidos)) { ?>
                                            <div class="table-responsive">
                                                <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                    <th>#</th>
                                                    <th>Fecha</th>
                                                    <th>Total</th>
                                                    <th>Observacion</th>
                                                    <th>Estado</th>
                                                    
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($pedidos as $pedido) { ?>
                                                        <tr>
                                                            <td data-title="#"><?php echo $pedido['ped_com'];?></td>
                                                            <td data-title="Fecha"><?php echo $pedido['ped_fecha'];?></td>
                                                            <td data-title="Cliente"><?php echo number_format($pedido['ped_total'],0,",",".");?></td>
                                                            <td data-title="Observacion"><?php echo $pedido['obs_pedido'];?></td>
                                                            <td data-title="Estado"><?php echo $pedido['ped_estado'];?></td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                          <?php  }else{ ?>
                                            <div class="alert alert-info flat">
                                                <span class="glyphicon glyphicon-info-sign"></span>
                                                No se han registrado pedido de compras..
                                            </div>
                                         <?php   } ?>
                                        </div>
                                    </div>
                                    </div>
                                    <!-- DETALLE MATERIA PRIMA -->
                                        <?php 
                                        $ped_mp = $pedidos[0]['ped_mp'] !== null ? $pedidos[0]['ped_mp'] : '';
                                        ?>

                                        <?php if ($ped_mp !== '') { ?>
                                            <div class="panel panel-info">
                                                <div class="panel-heading">
                                                    <strong>Detalle del Pedido de Materia Prima N° <?php echo $ped_mp; ?></strong>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                                        <?php
                                                        // Ejecutar la consulta solo si ped_mp no es null
                                                        $detalle_mp = consultas::get_datos("select * from v_detalle_pedmp where ped_mp = '$ped_mp'");
                                                        
                                                        if (!empty($detalle_mp)) { ?>
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered table-striped table-hover">
                                                                    <thead>
                                                                        <tr class="info">
                                                                            <th>MATERIA PRIMA</th>
                                                                            <th>CANTIDAD</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php foreach ($detalle_mp as $d) { ?>
                                                                            <tr>
                                                                                <td data-title="Materia Prima"><?php echo $d['art_descri']; ?></td>
                                                                                <td data-title="Cantidad"><?php echo $d['ped_cant']; ?></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="alert alert-info flat">
                                                                <span class="glyphicon glyphicon-info-sign"></span>
                                                                No se han cargado detalles de materia prima.
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="alert alert-warning flat">
                                                <span class="glyphicon glyphicon-warning-sign"></span>
                                                Sin pedido de materia prima.
                                            </div>
                                        <?php } ?>
                                        <!-- FIN DETALLE MATERIA PRIMA -->

                                    <!--INICIO CABECERA-->
                                    <!--INICIO DETALLE-->
                                    <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <strong> Detalle de Pedido Compras</strong>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                            <?php
                                             $detalles = consultas::get_datos("select * from v_detalle_pedcompra where ped_com =".$pedidos[0]['ped_com']); 
                                            if (!empty($detalles)) { ?>
                                            <div class="table-responsive">
                                                <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                    <th>#</th>
                                                    <th>Descripcion</th>
                                                    <th>Cant.</th>
                                                    <th>Precio</th>
                                                    <th>Impuesto</th>
                                                    <th>Subtotal</th>
                                                    <th class="text-center">Acciones</th>
                                                    
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($detalles as $det) { ?>
                                                        <tr>
                                                            <td data-title="#"><?php echo $det['art_cod'];?></td>
                                                            <td data-title="Descripcion"><?php echo $det['art_descri']." ".$det['mar_descri'];?></td>
                                                            <td data-title="Cant."><?php echo $det['ped_cant'];?></td>
                                                            <td data-title="Precio"><?php echo number_format($det['ped_precio'],0,",",".");?></td>
                                                            <td data-title="Impuesto"><?php echo $det['tipo_descri'];?></td>
                                                            <td data-title="Subtotal"><?php echo number_format($det['subtotal'],0,",",".");?></td>
                                                            <td class="text-center">
                                                                <a onclick="editar(<?php echo $det['ped_com']?>,<?php echo $det['art_cod']?>)" class="btn btn-warning btn-sm" 
                                                                   data-title="Editar" rel="tooltip" data-toggle="modal" data-target="#editar">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                               
                                                                <a onclick="borrar(<?php echo "'".$det['ped_com']."_".$det['art_cod']."_".$det['art_descri']."'";?>)" class="btn btn-danger btn-sm" role="button" data-title="Borrar" rel="tooltip"
                                                                   data-placement="top" data-toggle="modal" data-target="#borrar"><i class="fa fa-trash"></i>  
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                          <?php  }else{ ?>
                                            <div class="alert alert-info flat">
                                                <span class="glyphicon glyphicon-info-sign"></span>
                                                El pedido aun no tiene detalles cargados...
                                            </div>
                                         <?php   } ?>
                                        </div>
                                    </div>
                                    </div>

                                    

                                    <!--INICIO AGREGAR DETALLE-->
                                    <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <strong> Agregar Detalle</strong>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                            <form action="pedcompras_dcontrol.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                                <div class="box-body">
                                                    <input type="hidden" name="accion" value="1"/>
                                                    <input type="hidden" name="vped_com" value="<?php echo $pedidos[0]['ped_com']?>"/>
                                                    
                                                    <div class="form-group">
                                                        <label class="control-label col-lg-2 col-sm-3 col-md-2 col-xs-3">Articulo:</label>
                                                        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-6">
                                                            <?php $articulos = consultas::get_datos("select * from v_articulo where art_estado = 'ACTIVO' order by art_cod");?>
                                                            <select class="form-control select2" name="vart_cod" required="" id="articulo" onchange="precio()">
                                                                <option value="">Seleccione un articulo</option>
                                                                <?php foreach ($articulos as $articulo) { ?>
                                                                <option value="<?php echo $articulo['art_cod']."_".$articulo['art_preciov'];?>"><?php echo $articulo['art_descri']." ".$articulo['mar_descri'];?></option>
                                                               <?php }  ?>                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-lg-2 col-sm-3 col-md-2 col-xs-2">Cantidad:</label>
                                                        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-6">
                                                            <input type="number" name="vped_cant" class="form-control" min="1" value="1" required=""/> 
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-lg-2 col-sm-3 col-md-2 col-xs-2">Precio:</label>
                                                        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-6">
                                                            <input type="number" name="vped_precio" class="form-control" min="1" value="1" required="" id="vprecio"/> 
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="box-footer">
                                                    <button type="submit" class="btn btn-primary pull-right">
                                                        <span class="fa fa-plus"> Agregar</span>
                                                    </button>
                                                </div>
                                            </form> 
                                        </div>
                                    </div>
                                    <!--FIN AGREGAR-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                  <!-- MODAL BORRAR MATERIA PRIMA-->
                  <div class="modal" id="borrar_mp" role="dialog">
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                  <h4 class="modal-title custom_align">Atención!!!</h4>
                              </div>
                              <div class="modal-body">
                                  <div class="alert alert-danger" id="confirmacion_mp"></div>
                              </div>
                              <div class="modal-footer">
                                  <a id="si_mp" role="buttom" class="btn btn-primary">
                                      <span class="glyphicon glyphicon-ok-sign"></span> SI
                                  </a>
                                  <button type="button" class="btn btn-default" data-dismiss="modal">
                                      <span class="glyphicon glyphicon-remove"></span> NO
                                  </button>
                              </div>
                          </div>
                      </div>
                  </div>
                  <!-- FIN MODAL BORRAR MATERIA PRIMA-->
                  <!-- MODAL EDITAR MATERIA PRIMA-->
                  <div class="modal" id="editar_mp" role="dialog">
                      <div class="modal-dialog">
                          <div class="modal-content" id="detalles_mp">
                          </div>
                      </div>
                  </div>
                  <!-- FIN MODAL EDITAR MATERIA PRIMA-->
            </div>                  
        <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
        <script>
            $("#mensaje").delay(4000).slideUp(200, function() {
               $(this).alert('close'); 
            });
            $('.modal').on('shown.bs.modal', function() {
                $(this).find('input:text:visible:first').focus();
            });
        </script>
        <script>
            function borrar(datos) {
                    var dat = datos.split('_');
                    $('#si').attr('href', 'pedcompras_dcontrol.php?vped_com=' + dat[0] + '&vart_cod=' + dat[1] + '&accion=3');
                    $("#confirmacion").html('<span class="glyphicon glyphicon-warning-sign"></span> \\n\\ Desea quitar el articulo <strong>' + dat[2] + '</strong> ?');
                }
            
            function borrar_mp(datos) {
                    var dat = datos.split('_');
                    $('#si_mp').attr('href', 'pedcompras_dcontrol.php?vped_com=' + dat[0] + '&vmat_cod=' + dat[1] + '&accion=3');
                    $("#confirmacion_mp").html('<span class="glyphicon glyphicon-warning-sign"></span> \\n\\ Desea quitar la materia prima <strong>' + dat[2] + '</strong> ?');
                }

            function precio() {
                var dat = $('#articulo').val().split("_");
                $('#vprecio').val(dat[1]);
            }

            function editar(ped, art) {
                $.ajax({
                    type: "GET",
                    url: "/tdp/pedcompras_dedit.php?vped_com=" + ped + "&vart_cod=" + art,
                    cache: false,
                    beforeSend: function() {
                        $("#detalles").html('<strong>Cargando...</strong>')
                    },
                    success: function(data) {
                        $("#detalles").html(data)
                    }
                })
            };

            function editar_mp(ped, mat) {
                $.ajax({
                    type: "GET",
                    url: "/tdp/pedcompras_dedit_mp.php?vped_com=" + ped + "&vmat_cod=" + mat,
                    cache: false,
                    beforeSend: function() {
                        $("#detalles_mp").html('<strong>Cargando...</strong>')
                    },
                    success: function(data) {
                        $("#detalles_mp").html(data)
                    }
                })
            };

            /* function getProductData($con)
{
    $sqlProducts = ("
        SELECT 
            p.id AS prodId,
            p.nameProd,
            p.precio,
            f.foto1
        FROM 
            products AS p
        INNER JOIN
            fotoproducts AS f
        ON 
            p.id = f.products_id;
    ");
    $queryProducts = mysqli_query($con, $sqlProducts);

    if (!$queryProducts) {
        return false;
    }
    // Si todo está bien, devuelves el resultado del query
    return $queryProducts;
} */
        </script>
    </body>
</html>
