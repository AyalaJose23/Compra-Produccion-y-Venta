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
                        <div class="col-lg-12 col-xs-12 col-md-12">
                            <?php if (!empty($_SESSION['mensaje'])) { ?>
                            <div class="alert alert-danger" role="alert" id="mensaje">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                <?php echo $_SESSION['mensaje'];
                                $_SESSION['mensaje']='';?>
                            </div>
                             <?php } ?>
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="fa fa-list"></i>
                                    <h3 class="box-title">Agregar Detalle Control Porduccion</h3>
                                    <div class="box-tools">
                                        <a href="control.produ.index.php" class="btn btn-primary btn-sm" data-title="Volver" rel="tooltip" data-placement="left">
                                            <i class="fa fa-arrow-left"></i> VOLVER</a>                                            
                                    </div>
                                </div>
                                
                                <div class="box-body no-padding">
                                    <!--INICIO CABECERA-->
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                            <?php
                                             $controles = consultas::get_datos("select * from v_control_produ where cod_control =".$_REQUEST['vcod_control']); 
                                            if (!empty($controles)) { ?>
                                            <div class="table-responsive">
                                                <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                <thead>
                                                        <th>#</th>
                                                        <th>Nro Orden</th>
                                                        <th>Fecha</th>
                                                        <th>Estado</th>
                                                        <th class="text-center">Visualizar Productos</th>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($controles as $control) { ?>
                                                        <tr>
                                                        <td data-title="#"><?php echo $control['cod_control'];?></td>
                                                        <td data-title="Nro Presupuesto"><?php echo $control['cod_orden'];?></td>
                                                        <td data-title="Fecha"><?php echo $control['control_fecha'];?></td>
                                                        <td data-title="Estado"><?php echo $control['control_estado'];?></td>
                                                        <td class="text-center">
                                                            <a onclick="visp(<?php echo $control['cod_control']; ?>, <?php echo $control['cod_orden']; ?>)" class="btn btn-info btn-sm" data-title="Editar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#visp">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                        </tr>
                                                        
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                          <?php  }else{ ?>
                                            <div class="alert alert-info flat">
                                                <span class="glyphicon glyphicon-info-sign"></span>
                                                No se han registrado ordenes de produccion..
                                            </div>
                                         <?php   } ?>
                                        </div>
                                    </div>
                                    <!--FIN CABECERA-->
                                   
                                    
                            <div class="box box-primary">
                                
                            <div class="box-header">
                                    <!--INICIO DETALLE-->
                                    <div class="box-header">
                                        <i class="fa fa-list"></i>
                                        <h3 class="box-title">Detalle Control Produccion</h3>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                            <?php
                                             $detalles = consultas::get_datos("select * from v_detalle_control where cod_control =".$controles[0]['cod_control']); 
                                            if (!empty($detalles)) { ?>
                                            <div class="table-responsive">
                                                <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                    <th>#</th>
                                                    <th>Descripcion</th>
                                                    <?php if ($control['control_estado'] == 'REGISTRADO') { ?>
                                                            <th class="text-center">Acciones</th>
                                                            <?php } else { ?>
                                                                <?php }?>
                                                    
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($detalles as $det) { ?>
                                                        <tr>
                                                            <td data-title="#"><?php echo $det['cod_produ'];?></td>
                                                            <td data-title="Descripcion"><?php echo $det['produ_descri'];?></td>
                                                            <td class="text-center">
                                                            <a onclick="vis(<?php echo $det['cod_control']; ?>, <?php echo $det['cod_produ']; ?>)" class="btn btn-primary btn-sm" data-title="Editar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#editar">
                                                                        <i class="fa fa-list"></i>
                                                                    </a>
                                                                    <?php if ($control['control_estado'] == 'REGISTRADO') { ?>
                                                                <a onclick="borrar(<?php echo "'".$det['cod_produ']."'";?>)" class="btn btn-danger btn-sm" role="button" data-title="Borrar" rel="tooltip"
                                                                   data-placement="top" data-toggle="modal" data-target="#borrar"><i class="fa fa-trash"></i>  
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                        <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                          <?php  }else{ ?>
                                            <div class="alert alert-info flat">
                                                <span class="glyphicon glyphicon-info-sign"></span>
                                                La orden aun no tiene detalles cargados...
                                            </div>
                                         <?php   } ?>
                                        </div>
                                    </div>
                                    <!--FIN DETALLE-->
                                    
                                    <!--INICIO AGREGAR DETALLE-->
                                    <?php if ($control['control_estado'] == 'REGISTRADO') { ?>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                            <form action="control_produ_dcontrol.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                                <div class="box-body">
                                                    <input type="hidden" name="accion" value="1"/>
                                                    <input type="hidden" name="vcod_control" value="<?php echo $controles[0]['cod_control']?>"/>
                                                    
                                                    <div class="form-group">
                                                        <label class="control-label col-lg-2 col-sm-3 col-md-2 col-xs-2">Producto:</label>
                                                        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-6">
                                                            <?php
                                                            $articulos = consultas::get_datos("SELECT * FROM v_producto WHERE produ_estado = 'ACTIVO'");
                                                            ?>
                                                            <select class="form-control select2" name="vcod_produ">
                                                                <?php if (!empty($articulos)) { ?>            
                                                                    <option value="">Seleccione un Producto</option>        
                                                                    <?php foreach ($articulos as $art) { ?>
                                                                        <option value="<?php echo $art['cod_produ']?>"><?php echo "Producto:" . $art['produ_descri'] ?></option>            
                                                                    <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <option value="">El proveedor no tiene articulos</option> 
                                                                <?php } ?>        
                                                            </select>
                                                        </div>
                                                        </div>
                                                    
                                                </div>
                                                <?php } else { ?>
                                                                <?php }?>
                                                <?php if ($control['control_estado'] == 'REGISTRADO') { ?>
                                                <div class="box-footer">
                                                    <button type="submit" class="btn btn-primary pull-right">
                                                        
                                                        
                                                            <span class="fa fa-plus"> Agregar</span>
                                                            <?php } else { ?>
                                                                <?php }?>
                                                    </button>
                                                </div>
                                            </form> 
                                        </div>
                                    </div>
                                    <!--FIN AGREGAR-->
                                    <div class="box box-primary">
                                
                            <div class="box-header">
                                    <!--INICIO DETALLE-->
                                    <div class="box-header">
                                        <i class="fa fa-list"></i>
                                        <h3 class="box-title">Detalle Control Produccion</h3>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                            <?php
                                             $detalles = consultas::get_datos("select * from v_detalle_control_et where cod_control =".$controles[0]['cod_control']); 
                                            if (!empty($detalles)) { ?>
                                            <div class="table-responsive">
                                                <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                    <th>#</th>
                                                    <th>Descripcion</th>
                                                    <th>Observacion</th>
                                                    <th>Estado</th>
                                                    
                                                    
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($detalles as $det) { ?>
                                                        <tr>
                                                            <td data-title="#"><?php echo $det['cod_produ'];?></td>
                                                            <td data-title="Descripcion"><?php echo $det['produ_descri'];?></td>
                                                            <td data-title="Observacion"><?php echo $det['observacion'];?></td>
                                                            <td data-title="Estado"><?php echo $det['estado'];?></td>
                                                            
                                                        </tr>
                                                        
                                                        <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                          <?php  }else{ ?>
                                            <div class="alert alert-info flat">
                                                <span class="glyphicon glyphicon-info-sign"></span>
                                                La orden aun no tiene detalles cargados...
                                            </div>
                                         <?php   } ?>
                                        </div>
                                    </div>
                                    <!--FIN DETALLE-->
                                    
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
                 <!-- MODAL VISTA PRODUCTO-->
                 <div class="modal" id="visp" role="dialog">
                      <div class="modal-dialog">
                          <div class="modal-content" id="detalles">
                          </div>
                      </div>
                  </div>
                  <!-- FIN MODAL VISTA PRODUCTO-->
                 <!-- MODAL EDITAR-->
                  <div class="modal" id="editar" role="dialog">
                      <div class="modal-dialog">
                          <div class="modal-content" id="detalle">
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
            function vis(con, pro) {//, et) {
                    $.ajax({
                        type: "GET",
                        url: "/tdp/control.produ_detvi.php?vcod_control=" + con + "&vcod_produ=" + pro,  //+ "&vcod_etapa_p=" + et,
                        cache: false,
                        beforeSend: function () {
                            $('#detalle').html('<img src="img/loader.gif" /><strong>Cargando...</strong>');
                        },
                        success: function (data) {
                            $('#detalle').html(data);
                        }
                    });
                }
                function visp(com, art) {
                    $.ajax({
                        type: "GET",
                        url: "/tdp/control.orden.produ_detvi.php?vcod_control=" + com + "&vcod_orden=" + art,
                        cache: false,
                        beforeSend: function () {
                            $('#detalles').html('<img src="img/loader.gif" /><strong>Cargando...</strong>');
                        },
                        success: function (data) {
                            $('#detalles').html(data);
                        }
                    });
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


