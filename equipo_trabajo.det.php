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
                                    <h3 class="box-title">Agregar Detalle Equipo Trabajo</h3>
                                    <div class="box-tools">
                                        <a href="equipo_trabajo.index.php" class="btn btn-primary btn-sm" data-title="Volver" rel="tooltip" data-placement="left">
                                            <i class="fa fa-arrow-left"></i> VOLVER</a>                                            
                                    </div>
                                </div>
                                
                                <div class="box-body no-padding">
                                    <!--INICIO CABECERA-->
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                            <?php
                                             $equipo_trabajo = consultas::get_datos
                                             ("select * from v_equipo_t where id_equipo=".$_REQUEST['vid_equipo']) ;
                                            if (!empty($equipo_trabajo)) { ?>
                                            <div class="table-responsive">
                                                <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                <thead>
                                                        <tr>
                                                            <th>Descripción</th>
                                                            <th>Fecha de Creación</th>
                                                            <th>Estado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($equipo_trabajo as $equipo) { ?>
                                                        <tr>
                                                            <td data-title="Descripción"><?php echo $equipo['nombre_equipo'];?></td>
                                                            <td data-title="FECHA DE CREACION"><?php echo $equipo['fecha_creacion'];?></td>
                                                            <td data-title="ESTADO"><?php echo $equipo['estado_equipo'];?></td>
                                                            <td data-title="Acciones" class="text-center">
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                          <?php  }else{ ?>
                                            <div class="alert alert-info flat">
                                                <span class="glyphicon glyphicon-info-sign"></span>
                                                No se han registrado equipo_trabajo..
                                            </div>
                                         <?php   } ?>
                                        </div>
                                    </div>
                                    <!--INICIO CABECERA-->
                                    <!--INICIO DETALLE-->
                                    <div class="box-header">
                                        <i class="fa fa-plus"></i><i class="fa fa-list"></i>
                                        <h3 class="box-title">Detalle Empleados Encargados</h3>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                            <?php
                                             $detalles = consultas::get_datos("select * from v_detalle_equipo where id_equipo =".$equipo_trabajo[0]['id_equipo']); 
                                            if (!empty($detalles)) { ?>
                                            <div class="table-responsive">
                                                <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                    <th>#</th>
                                                    <th>Cortador/es Asignado/s</th>
                                                    <th class="text-center">Acciones</th>
                                                    
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($detalles as $det) { ?>
                                                        <tr>
                                                            <td data-title="#"><?php echo $det['emp_cod'];?></td>
                                                            <td data-title="Cortador Asignado/s"><?php echo $det['emp_nombre'];?></td>
                                                            <td class="text-center">
                                                            
                                                               
                                                                <a onclick="borrar(<?php echo "'".$det['id_equipo']."_".$det['emp_cod']."'";?>)" class="btn btn-danger btn-sm" role="button" data-title="Borrar" rel="tooltip"
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
                                                El equipo aun no tiene detalles cargados...
                                            </div>
                                         <?php   } ?>
                                        </div>
                                    </div>
                                    <!--FIN DETALLE-->

                                    <!--INICIO AGREGAR DETALLE-->
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                            <form action="equipo_trabajo.dcontrol.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                                <div class="box-body">
                                                    <input type="hidden" name="accion" value="1"/>
                                                    <input type="hidden" name="vid_equipo" value="<?php echo $equipo_trabajo[0]['id_equipo']?>"/>
                                                    
                
                                                        <div class="form-group">
                                                        <label class="control-label col-lg-2 col-sm-3 col-md-2 col-xs-2">Funcionario:</label>
                                                        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-6">
                                                            <?php
                                                            $articulos = consultas::get_datos("SELECT * FROM v_empleado WHERE emp_estado = 'ACTIVO'");
                                                            ?>
                                                            <select class="form-control select2" name="vemp_cod">
                                                                <?php if (!empty($articulos)) { ?>            
                                                                    <option value="">Seleccione un funcionario</option>        
                                                                    <?php foreach ($articulos as $art) { ?>
                                                                        <option value="<?php echo $art['emp_cod']?>"><?php echo"" . $art['emp_nombre'] . " " .$art['emp_apellido'] ?></option>   
                    
                                                                    <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <option value="">El no hay datos cargados en funcionario</option> 
                                                                <?php } ?>        
                                                            </select>
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
                    $('#si').attr('href', 'equipo_trabajo.dcontrol.php?vid_equipo=' + dat[0] + '&vemp_cod=' + dat[1] + '&accion=3');
                    $("#confirmacion").html('<span class="glyphicon glyphicon-warning-sign"></span> \\n\\ Desea quitar al funcionario del equipo <strong>' + dat[0] + '</strong> ?');
                }
            
        </script>
    </body>
</html>


