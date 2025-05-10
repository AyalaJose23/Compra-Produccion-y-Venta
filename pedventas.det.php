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
                        <div class="col-lg-12 col-xs-12 col-md-12">
                            <?php if (!empty($_SESSION['mensaje'])) { ?>
                            <div class="alert alert-success" role="alert" id="mensaje">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                <?php echo $_SESSION['mensaje'];
                                $_SESSION['mensaje']='';?>
                            </div>
                             <?php } ?>
                            
                             
                                <div class="content">
                                <div class="row">
                                    <!--impresion del titulo de la pagina-->
                                    <div class="col-lg-12">
                                        <h3 class="page-header text-center alert-success"> <strong>PEDIDO DE VENTA</strong>
                                            <a href="pedventas.index.php" 
                                            class="btn btn-success pull-right" 
                                            rel='tooltip' title="Atras">
                                                <i class="glyphicon glyphicon-arrow-left"></i>
                                            </a> 

                                        </h3>
                                    </div>     
                                    <!--Buscador-->

                                </div>
                                <!-- /.row -->
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <strong>Datos Cabecera de Pedidos</strong>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                            <?php
                                             $pedidos = consultas::get_datos("select * from v_pedido_cabventa where ped_cod =".$_REQUEST['vped_cod']); 
                                            if (!empty($pedidos)) { ?>
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
                                                        <?php foreach ($pedidos as $pedido) { ?>
                                                        <tr>
                                                            <td data-title="#"><?php echo $pedido['ped_cod'];?></td>
                                                            <td data-title="Fecha"><?php echo $pedido['ped_fecha'];?></td>
                                                            <td data-title="Cliente"><?php echo $pedido['cliente'];?></td>
                                                            <td data-title="Cliente"><?php echo number_format($pedido['ped_total'],0,",",".");?></td>
                                                            <td data-title="Cliente"><?php echo $pedido['estado'];?></td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                          <?php  }else{ ?>
                                            <div class="alert alert-danger flat">
                                                <span class="glyphicon glyphicon-info-sign"></span>
                                                No se han registrado pedido de ventas..
                                            </div>
                                         <?php   } ?>
                                        </div>
                                    </div>
                            </div>
                        
                                    <!--FIN CABECERA-->
                                    <!--INICIO DETALLE-->
                                    <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <strong> Detalle de Pedido Venta</strong>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                            <?php
                                             $detalles = consultas::get_datos("select * from v_detalle_pedventa where ped_cod =".$pedidos[0]['ped_cod']); 
                                            if (!empty($detalles)) { ?>
                                            <div class="table-responsive">
                                                <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                    <th>#</th>
                                                    <th>Descripcion</th>
                                                    <th>Color</th>
                                                    <th>Cantidad</th>
                                                    <th>Impuesto</th>
                                                    <th class="text-center">Acciones</th>
                                                    
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($detalles as $det) { ?>
                                                        <tr>
                                                            <td data-title="#"><?php echo $det['cod_produ'];?></td>
                                                            <td data-title="Descripcion"><?php echo $det['produ_descri'];?></td>
                                                            <td data-title="Color"><?php echo $det['color_descrip'];?></td>
                                                            <td data-title="Cant."><?php echo $det['ped_cant'];?></td>
                                                            <td data-title="Impuesto"><?php echo $det['tipo_descri'];?></td>
                                                            <td class="text-center">
                                                                <a onclick="editar(<?php echo $det['ped_cod']?>,<?php echo $det['cod_produ']?>)" class="btn btn-warning btn-sm" 
                                                                   data-title="Editar" rel="tooltip" data-toggle="modal" data-target="#editar">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                                <a onclick="borrar(<?php echo "'".$det['ped_cod']."_".$det['cod_produ']
                                                                        ."_".$det['produ_descri']."'";?>)" class="btn btn-danger btn-sm" role="button" data-title="Borrar" rel="tooltip"
                                                                   data-placement="top" data-toggle="modal" data-target="#borrar"><i class="fa fa-trash"></i>  
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                          <?php  }else{ ?>
                                            <div class="alert alert-danger flat">
                                                <span class="glyphicon glyphicon-info-sign"></span>
                                                El pedido aun no tiene detalles cargados...
                                            </div>
                                         <?php   } ?>
                                        </div>
                                    </div>
                                    </div>
                                    <!--FIN DETALLE-->
                                    <!--INICIO AGREGAR DETALLE-->
                                    <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <strong> Agregar Detalle</strong>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                            <form action="pedventas_dcontrol.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                                <div class="box-body">
                                                    <input type="hidden" name="accion" value="1"/>
                                                    <input type="hidden" name="vped_cod" value="<?php echo $pedidos[0]['ped_cod']?>"/>
                                                    
                                                    <div class="form-group">
                                                        <label class="control-label col-lg-2 col-sm-3 col-md-2 col-xs-3">Producto:</label>
                                                        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-6">
                                                            <?php $productos = consultas::get_datos("select * from v_producto order by cod_produ");?>
                                                            <select class="form-control select2" name="vcod_produ" required="" id="producto" onchange="precio()">
                                                                <option value="">Seleccione un producto</option>
                                                                <?php foreach ($productos as $produ) { ?>
                                                                
                                                                <option value="<?php echo $produ['cod_produ'];?>"><?php echo $produ['produ_descri'];?></option>
                                                               <?php }  ?>                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-lg-2 col-sm-3 col-md-2 col-xs-3">Color:</label>
                                                        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-6">
                                                            <?php $productos = consultas::get_datos("select * from color order by cod_color");?>
                                                            <select class="form-control select2" name="vcod_color">
                                                                <option value="">Seleccione un Color</option>
                                                                <?php foreach ($productos as $produ) { ?>
                                                                <option value="<?php echo $produ['cod_color'];?>"><?php echo $produ['color_descrip'];?></option>
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
                                                <div class="box-footer">
                                                    <button type="submit" class="btn btn-primary pull-right">
                                                        <span class="fa fa-plus"> Agregar</span>
                                                    </button>
                                                </div>
                                            </form> 
                                        </div>
                                    </div>
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
                 
                 <!--INICIA MODAL ELIMINAR-->
                 <div class="modal fade" id="borrar" role="dialog">
                     <div class="modal-dialog">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <button type="button" class="close" data-dismiss="modal">x</button>
                                 <h4 class="data-title custom_align" id="Heading" >Atencion!!!</h4>
                             </div>
                             <div class="modal-body">
                                 <div class="alert alert-warning" id="confirmacion"></div>
                             </div>
                             <div class="modal-footer">
                                 <a id="si" role="button" class="btn btn-primary">
                                     <span class="glyphicon glyphicon-ok-sign"></span> Si</a>
                                     <button type="button" class="btn btn-default" data-dismiss="modal">
                                         <span class="glyphicon glyphicon-remove"></span> No</button>
                             </div>
                         </div>
                     </div>
                 </div>
                 <!--FIN MODAL ELIMINAR-->
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
                $('#si').attr('href','pedventas_dcontrol.php?vped_cod='+dat[0]+'&vcod_produ='+dat[1]+'&accion=3');
                $('#confirmacion').html('<span class="glyphicon glyphicon-warning-sign"></span> \n\
                                Desea quitar el Productyo <i><strong>'+dat[2]+'</strong>');
            };
            function precio() {
                var dat = $('#producto').val().split("_");
                $('#vprecio').val(dat[1]);
               
            }
            function editar(ped,produ){
            $.ajax({
                type    : "GET",
                url     : "/tdp/pedventas_dedit.php?vped_cod="+ped+"&vcod_produ="+produ,
                cache   : false,
                beforeSend:function(){
                    $("#detalles").html('<strong>Cargando...</strong>')
                },
                success:function(data){
                    $("#detalles").html(data)
                }
            })
        };
        </script>
    </body>
</html>


