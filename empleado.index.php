<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="image/x-icon" href="/lp3/favicon.ico">
        <title>LP3</title>
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
                                    <i class="fa fa-clipboard"></i> 
                                    <h3 class="box-title">Empleados</h3>
                                    <div class="box-tools">
                                        <a href="empleado.anadir.php" class="btn btn-primary btn-sm" data-title="Agregar" rel="tooltip" data-placement="left">
                                            <i class="fa fa-plus"></i></a>
                                            <a href="empleado.print.php" class="btn btn-default btn-sm" data-title="Imprimir" rel="tooltip" data-placement="left" target="print">
                                            <i class="fa fa-print"></i></a>                                            
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <form method="post" accept-charset="utf-8" class="form-horizontal">
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="input-group custom-search-form">                                                                
                                                                <input type="search" name="buscar" class="form-control" placeholder="Ingrese valor a buscar..." autofocus=""/>
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
                                            <?php $empleados = consultas::get_datos("select * from v_empleado where (emp_nombre||emp_apellido) ilike '%".(isset($_REQUEST['buscar'])? $_REQUEST['buscar']:"")."%' order by emp_cod"); 
                                                if (!empty($empleados)) { ?>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-condensed table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Nombre y Apellido</th>
                                                            <th>Cargo</th>
                                                            <th>Direccion</th>
                                                            <th>Telefono</th>
                                                            <th class="text-center">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($empleados as $emp) { ?>
                                                        <tr>
                                                            <td data-title="Nombres y Apellidos"><?php echo $emp['emp_nombre']." ".$emp['emp_apellido'];?></td>
                                                           <td data-title="Cargo"><?php echo $emp['car_descri'];?></td>
                                                           <td data-title="Direccion"><?php echo $emp['emp_direcc'];?></td>
                                                            <td data-title="Telefono"><?php echo $emp['emp_tel'];?></td>
                                                            <!-- <td data-title="Impuesto"></?php echo $depo['tipo_descri'];?></td>-->
                                                            <td data-title="Acciones" class="text-center">

                                                            <?php if($emp['emp_estado']=='ACTIVO'){?>
                                                                    <a onclick="desactivar(<?php echo "'".$emp['emp_cod']."_".$emp['emp_nombre']."_".$emp['emp_apellido']."_".$emp['car_descri']."'";?>)" 
                                                                       class="btn btn-danger btn-sm" data-title="Desactivar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#desactivar">
                                                                    <i class="fa fa-remove"></i></a>
                                                                    <a href="empleado.editar.php?vemp_cod=<?php echo $emp['emp_cod'];?>" class="btn btn-success btn-sm" data-title="Editar" rel="tooltip" data-placement="left">
                                                                    <i class="fa fa-edit"></i></a> 
                                                                    <?php }
                                                                if($emp['emp_estado']=='INACTIVO'){?>
                                                                     <a onclick="activar(<?php echo "'".$emp['emp_cod']."_".$emp['emp_nombre']."_".$emp['emp_apellido']."_".$emp['car_descri']."'";?>)" 
                                                                       class="btn btn-primary btn-sm" data-title="Desactivar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#activar">
                                                                    <i class="fa fa-check"></i></a>                                                                                                                                                                      
                                                                <?php }?>
                                                                </a>
                                                            </td>
                                                        </tr>  
                                                        <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php }else{ ?>
                                            <div class="alert alert-info">
                                                <span class="glyphicon glyphicon-info-sign"></span> 
                                                No se han registrado Empleado...
                                            </div>      
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                  <?php require 'menu/footer_lte.ctp'; ?><!--ARCHIVOS JS--> 
                 <!-- MODAL activar-->
                <div class="modal" id="activar" role="dialog">
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
                  <!-- FIN MODAL activar-->  

                  <!-- MODAL desactivar-->
                  <div class="modal" id="desactivar" role="dialog">
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
                  <!-- FIN MODAL desactivar-->
            </div>                  
        <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
        <script>
            $("#mensaje").delay(4000).slideUp(200, function() {
               $(this).alert('close'); 
            });
           /* $('.modal').on('shown.bs.modal', function() {
                $(this).find('input:text:visible:first').focus();
            });*/
        </script>
       <script>
            function editar(datos) {
                var dat = datos.split("_");
                $('#cod').val(dat[0]);
                $('#descri').val(dat[1]);
            }
            
            function desactivar(datos){
                var dat = datos.split('_');
                $('#si').attr('href','empleado_control.php?vemp_cod='+dat[0]+'&accion=3');
                $("#confirmacion").html('<span class="glyphicon glyphicon-warning-sign"></span> \n\
                Desea Inactivar el Proveedor <strong>'+dat[0]+'</strong> <strong>'+dat[1]+'</strong> <strong>'+dat[2]+'</strong> de cargo: <strong>'+dat[3])
            }
            function activar(datos){
                var dat = datos.split('_');
                $('#sic').attr('href','empleado_control.php?vemp_cod='+dat[0]+'&accion=5');
                $("#confirmacionc").html('<span class="glyphicon glyphicon-info-sign"></span> \n\
                Desea Activar el Proveedor <strong>'+dat[0]+'</strong> <strong>'+dat[1]+'</strong> <strong>'+dat[2]+'</strong> de cargo: <strong>'+dat[3])
            }        
        
       
        
        </script>
    </body>
</html>


