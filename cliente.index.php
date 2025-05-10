<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon"  href=" img/mueble.png"/>
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
                        <div class="col-lg-12 col-md-12 col-xs-12">
                            <?php if (!empty($_SESSION['mensaje'])) { ?>
                            <div class="alert alert-danger" role="alert" id="mensaje">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                <?php echo $_SESSION['mensaje'];
                                $_SESSION['mensaje']='';?>
                            </div>
                             <?php } ?>
                            <div class="box box-primary"> <!--linea azul-->
                                <div class="box-header">  <!--compo blanco-->
                                    <i class="ion ion-person"></i>
                                    <h3 class="box-title">Clientes</h3>
                                    <div class="box-tools">
                                        <a href="cliente.anadir.php" class="btn btn-primary btn-sm" 
                                           data-title="Agregar" rel="tooltip"><i class="fa fa-plus" ></i></a>
                                        <a href="cliente.print.php" class="btn btn-default btn-sm" 
                                           data-title="Imprimir" rel="tooltip" target="print"><i class="fa fa-print" ></i></a>                                           
                                    </div>
                                </div>
                                <!------------------------------------------------------------------------------------------------>
                                <div class="box-body no-padding">
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12 col-lg-12">
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
                                            <?php
                                            $clientes = consultas::get_datos("select * from clientes where (cli_nombre||cli_apellido) ilike '%".(isset($_REQUEST['buscar'])? $_REQUEST['buscar']:"")."%' order by cli_cod"); 
                                            if (!empty($clientes)) { ?>
                                            <div class="table-responsive">
                                                <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                        <tr>
                                                            <th>N° CI</th>
                                                            <th>Nombre y Apellido</th>
                                                            <th>Telefono</th>
                                                            <th>Dirección</th>
                                                            <th class="text-center">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($clientes as $clien) { ?>
                                                        <tr>
                                                            <td data-title="N° Cedula"><?php echo $clien['cli_ci'];?></td>
                                                            <td data-title="Nombres y Apellidos"><?php echo $clien['cli_nombre']." ".$clien['cli_apellido'];?></td>
                                                            <td data-title="Telefono"><?php echo $clien['cli_telefono'];?></td>
                                                            <td data-title="Dirección"><?php echo $clien['cli_direcc'];?></td>
                                                            <td data-title="Acciones" class="text-center">
                                                            <?php if($clien['cli_estado']=='ACTIVO'){?>
                                                                    <a onclick="desactivar(<?php echo "'".$clien['cli_cod']."_".$clien['cli_nombre']."_".$clien['cli_apellido']."'";?>)" 
                                                                       class="btn btn-danger btn-sm" data-title="Desactivar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#desactivar">
                                                                    <i class="fa fa-remove"></i></a>
                                                                <a href="cliente.editar.php?vcli_cod=<?php echo $clien['cli_cod'];?>" class="btn btn-success btn-sm" role="button"
                                                                   data-title="Editar" rel="tooltip">
                                                                    <i class="fa fa-edit"></i></a>
                                                                    <?php }
                                                                if($clien['cli_estado']=='INACTIVO'){?>
                                                                     <a onclick="activar(<?php echo "'".$clien['cli_cod']."_".$clien['cli_nombre']."_".$clien['cli_apellido']."'";?>)" 
                                                                       class="btn btn-primary btn-sm" data-title="Desactivar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#activar">
                                                                    <i class="fa fa-check"></i></a>                                                                                                                                                                      
                                                                <?php }?>
                                                            </td>
                                                        </tr>
                                                         
                                                      <?php   } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                           <?php } else { ?>
                                            <div class="alert alert-info flat">
                                                <span class="glyphicon glyphicon-info-sign"></span>
                                                No se han registrado cliente...
                                            </div>
                                          <?php   } ?>
                                        </div>
                                    </div>
                                </div>
                                <!---------------------------------------------------------------------------------------------->
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
        </script>
        <script>
        function desactivar(datos){
            var dat = datos.split('_');
            $('#si').attr('href','cliente_control.php?vcli_cod='+dat[0]+'&accion=3');
            $("#confirmacion").html('<span class="glyphicon glyphicon-warning-sign"></span> \n\
            Desea Inactivar el Cliente  <strong>'+dat[1]+'</strong> <strong>'+dat[2])
        }
        function activar(datos){
            var dat = datos.split('_');
            $('#sic').attr('href','cliente_control.php?vcli_cod='+dat[0]+'&accion=4');
            $("#confirmacionc").html('<span class="glyphicon glyphicon-info-sign"></span> \n\
            Desea Activar el Cliente  <strong>'+dat[1]+'</strong> <strong>'+dat[2])
        }        
        
        </script>
    </body>
</html>


   
            