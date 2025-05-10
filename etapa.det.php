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
    <body class="hold-transition skin-black sidebar-mini">
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
                                    <i class="fa fa-plus"></i><i class="fa fa-list"></i>
                                    <h3 class="box-title">Agregar Detalle Etapas</h3>
                                    <div class="box-tools">
                                        <a href="etapa.index.php" class="btn btn-primary btn-sm" data-title="Volver" rel="tooltip" data-placement="left">
                                            <i class="fa fa-arrow-left"></i> VOLVER</a>                                            
                                    </div>
                                </div>
                                
                                <div class="box-body no-padding">
                                    <!--INICIO CABECERA-->
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                            <?php
                                             $etapas = consultas::get_datos
                                             ("select * from v_etapas where cod_etapa=".$_REQUEST['vcod_etapa']) ;
                                            if (!empty($etapas)) { ?>
                                            <div class="table-responsive">
                                                <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                    <th>#</th>
                                                    <th>Fecha</th>
                                                    <th>Descripción</th>
                                                    <th>Producto</th>
                                                    <th>Estado</th>
                                                    
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($etapas as $etapa) { ?>
                                                        <tr>
                                                            <td data-title="#"><?php echo $etapa['cod_etapa'];?></td>
                                                            <td data-title="Fecha"><?php echo $etapa['etapa_fecha'];?></td>
                                                            <td data-title="Descripcion"><?php echo $etapa['etapa_descrip'];?></td>
                                                            <td data-title="Producto"><?php echo $etapa['producto'];?></td>
                                                            <td data-title="Estado"><?php echo $etapa['etapa_estado'];?></td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                          <?php  }else{ ?>
                                            <div class="alert alert-info flat">
                                                <span class="glyphicon glyphicon-info-sign"></span>
                                                No se han registrado etapas..
                                            </div>
                                         <?php   } ?>
                                        </div>
                                    </div>
                                    <!--INICIO CABECERA-->
                                    <!--INICIO DETALLE-->
                                    <div class="box-header">
                                        <i class="fa fa-plus"></i><i class="fa fa-list"></i>
                                        <h3 class="box-title">Detalle Procesos</h3>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                            <?php
                                             $detalles = consultas::get_datos("select * from v_detalle_etapa where cod_etapa =".$etapas[0]['cod_etapa']); 
                                            if (!empty($detalles)) { ?>
                                            <div class="table-responsive">
                                                <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                    <th>#</th>
                                                    <th>Descripcion</th>
                                                    <th class="text-center">Acciones</th>
                                                    
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($detalles as $det) { ?>
                                                        <tr>
                                                            <td data-title="#"><?php echo $det['cod_etapa_p'];?></td>
                                                            <td data-title="Descripcion"><?php echo $det['etapa_descrip_p'];?></td>
                                                            <td class="text-center">
                                                            <a onclick="borrar(<?php echo "'".$det['cod_etapa']."_".$det['cod_etapa_p']."_".$det['etapa_descrip_p']."'";?>)" class="btn btn-danger btn-sm" role="button" data-title="Borrar" rel="tooltip"
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
                                                El etapa aun no tiene detalles cargados...
                                            </div>
                                         <?php   } ?>
                                        </div>
                                    </div>
                                    <!--FIN DETALLE-->

                                    <!--INICIO AGREGAR DETALLE-->
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                            <form action="etapa_dcontrol.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                                <div class="box-body">
                                                    <input type="hidden" name="accion" value="1"/>
                                                    <input type="hidden" name="vcod_etapa" value="<?php echo $etapas[0]['cod_etapa']?>"/>
                                                        
                                                <div class="form-group">
                                                        <label class="control-label col-lg-2 col-sm-3 col-md-2 col-xs-2">Etapas:</label>
                                                        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-6">
                                                            <?php
                                                            $etapas_p = consultas::get_datos("SELECT * FROM etapa WHERE etapa_estado_p = 'ACTIVO' ORDER BY etapa_descrip_p");;
                                                            ?>
                                                            <select class="form-control select2" name="vcod_etapa_p">
                                                                <?php if (!empty($etapas_p)) { ?>            
                                                                    <option value="">Seleccione una Etapa </option>        
                                                                    <?php foreach ($etapas_p as $eta) { ?>
                                                                        <option value="<?php echo $eta['cod_etapa_p']?>"><?php echo " Descripcion: " . $eta['etapa_descrip_p'] ?></option>            
                                                                    <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <option value="">El articulo no tiene etapas</option> 
                                                                <?php } ?>        
                                                            </select>
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
                    $('#si').attr('href', 'etapa_dcontrol.php?vcod_etapa=' + dat[0] + '&vcod_etapa_p=' + dat[1] + '&accion=3');
                    $("#confirmacion").html('<span class="glyphicon glyphicon-warning-sign"></span> \\n\\ Desea quitar el insumo <strong>' + dat[2] + '</strong> ?');
                }
            
            function precio() {
                var dat = $('#produ').val().split("_");
                $('#vprecio').val(dat[1]);
               
            }
            
        function tipo_insumo(){
            console.log($('#tmp').val()),
        $.ajax({
            type    : "GET",
            url     : "etapa.tmp.php?vtmp_cod="+$('#tmp').val(),
            cache   : false,
            beforeSend:function(){
                $('#vart_cod').html('<img src="img/loader.gif" /><strong>Cargando...</strong>')
            },
            success:function(data){
                $('#vart_cod').html(data);
            }
        });
    }
    
        </script>
    </body>
</html>


