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
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-plus"></i>
                                    <h3 class="box-title">Agregar Usuario</h3>
                                    <div class="box-tools">
                                        <a href="usuario.index.php" class="btn btn-primary btn-sm" data-title="Volver" rel="tooltip">
                                            <i class="fa fa-arrow-left"></i></a>
                                    </div>
                                </div>
                                <form action="usuario_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                    <input type="hidden" name="accion" value="1"/>
                                    <input type="hidden" name="vusu_cod" value="0"/>                                    
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Nom. Usuario:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <input type="text" class="form-control" name="vusu_nick" autofocus="" required=""/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Clave:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <input type="text" class="form-control" name="vusu_clave" required=""/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php $empleados = consultas::get_datos("select * from v_empleado order by emp_cod");?>
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Empleado:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <div class="input-group">
                                                    <select class="form-control select2" name="vemp_cod" required="">
                                                       <option value="">Seleccione un Empleado</option> 
                                                        <?php foreach ($empleados as $emp) { ?>
                                                        <option value="<?php echo $emp['emp_cod'];?>"><?php echo $emp['emp_nombre']." ".$emp['emp_apellido'];?></option>
                                                        <?php } ?>
                                                        
                                                    </select>
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-primary btn-flat" 
                                                                data-toggle="modal" data-target="#registrar">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div> 
                                      
                                        <div class="form-group">
                                            <?php $grupos = consultas::get_datos("select * from grupos order by gru_cod desc");?>
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Grupo:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <div class="input-group">
                                                    <select class="form-control select2" name="vgru_cod" required="">
                                                         <option value="">Seleccione un Nombre</option>
                                                        <?php foreach ($grupos as $gru) { ?>
                                                        <option value="<?php echo $gru['gru_cod'];?>"><?php echo $gru['gru_nombre'];?></option>
                                                        <?php } ?>
                                                       
                                                    </select>
                                                   <span class="input-group-btn">
                                                        <button type="button" class="btn btn-primary btn-flat" 
                                                                data-toggle="modal" data-target="#registrar2">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php $sucursales = consultas::get_datos("select * from sucursal order by id_sucursal desc");?>
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Sucursal:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <div class="input-group">
                                                    <select class="form-control select2" name="vid_sucursal" required="">
                                                        <option value="">Seleccione el Sucursal</option>
                                                        <?php foreach ($sucursales as $suc) { ?>
                                                        <option value="<?php echo $suc['id_sucursal'];?>"><?php echo $suc['suc_descri'];?></option>
                                                        <?php } ?>
                                                        
                                                    </select>
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-primary btn-flat" 
                                                                data-toggle="modal" data-target="#registrar3">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>      
                                    </div>  
                                    <div class="box-footer">
                                        <a href="usuario.index.php" class="btn btn-default">
                                            <i class="fa fa-remove"></i> Cancelar
                                        </a>                                        
                                        <button type="submit" class="btn btn-primary pull-right" data-title="Guardar datos" rel="tooltip">
                                            <i class="fa fa-floppy-o"></i> Registrar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
                  <?php require 'menu/footer_lte.ctp'; ?><!--ARCHIVOS JS--> 
                  <!--INICIA MODAL REGISTRAR EMPLEADO-->
                  <div class="modal" id="registrar" role="dialog">
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                  <h4 class="modal-title"><i class="fa fa-plus"></i> <strong>Registrar Empleado</strong></h4>
                              </div>
                              <form action="usuario_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                  <input type="hidden" name="accion" value="4"/>
                                  <input type="hidden" name="vemp_cod" value="0"/>
                                  <div class="modal-body">
                                      <div class="form-group">
                                            <?php $cargos = consultas::get_datos("select * from cargo order by car_descri");?>
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Cargo:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                <div class="input-group">
                                                    <select class="form-control select2" name="vcar_cod" required="">
                                                        <option value="">Seleccione un cargo</option>
                                                        <?php foreach ($cargos as $car) { ?>
                                                        <option value="<?php echo $car['car_cod'];?>"><?php echo $car['car_descri'];?></option>
                                                        <?php } ?>
                                                    </select>
                                                  <!--  <span class="input-group-btn">
                                                        <button type="button" class="btn btn-primary btn-flat" 
                                                                data-toggle="modal" data-target="#registrar">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </span>-->
                                                </div>
                                            </div>
                                        </div> 
                                      <div class="form-group">
                                          <label class="control-label col-lg-2 col-sm-2 col-md-2">Nombre:</label>
                                          <div class="col-lg-10 col-sm-10 col-md-10">
                                              <input type="text" name="vusu_nick" class="form-control" required=""/>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="control-label col-lg-2 col-sm-2 col-md-2">Apellido:</label>
                                          <div class="col-lg-10 col-sm-10 col-md-10">
                                              <input type="text" name="vusu_nick" class="form-control" required=""/>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="control-label col-lg-2 col-sm-2 col-md-2">Direccion:</label>
                                          <div class="col-lg-10 col-sm-10 col-md-10">
                                              <input type="text" name="vusu_nick" class="form-control" required=""/>
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <label class="control-label col-lg-2 col-sm-2 col-md-2">Telefono:</label>
                                          <div class="col-lg-10 col-sm-10 col-md-10">
                                              <input type="text" name="vusu_nick" class="form-control" required=""/>
                                          </div>
                                      </div>
                                      
                                  </div>
                                  <div class="modal-footer">
                                      <button type="reset" data-dismiss="modal" class="btn btn-default">
                                          <i class="fa fa-remove"></i> Cerrar
                                      </button>
                                      <button type="submit" class="btn btn-primary">
                                          <i class="fa fa-floppy-o"></i> Guardar
                                      </button>                                      
                                  </div>
                              </form>
                          </div>
                      </div>
                  </div>
                 <!--FIN MODAL REGISTRAR EMPLEADO-->
                 <!--INICIA MODAL REGISTRAR grupO-->
                  <div class="modal" id="registrar2" role="dialog">
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                  <h4 class="modal-title"><i class="fa fa-plus"></i> <strong>Registrar Grupo</strong></h4>
                              </div>
                              <form action="usuario_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                  <input type="hidden" name="accion" value="5"/>
                                  <input type="hidden" name="vgru_cod" value="0"/>
                                  <div class="modal-body">
                                      <div class="form-group">
                                          <label class="control-label col-lg-2 col-sm-2 col-md-2">Grupo:</label>
                                          <div class="col-lg-10 col-sm-10 col-md-10">
                                              <input type="text" name="vemp_nick" class="form-control" required=""/>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="modal-footer">
                                      <button type="reset" data-dismiss="modal" class="btn btn-default">
                                          <i class="fa fa-remove"></i> Cerrar
                                      </button>
                                      <button type="submit" class="btn btn-primary">
                                          <i class="fa fa-floppy-o"></i> Guardar
                                      </button>                                      
                                  </div>
                              </form>
                          </div>
                      </div>
                  </div>
                 <!--FIN MODAL REGISTRAR GRUPO-->
                 <!--INICIA MODAL REGISTRAR SUCURSALES-->
                 <div class="modal fade" id="registrar3" role="dialog">
                     <div class="modal-dialog">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                 <h4 class="modal-title">Registrar Sucursal</h4>
                             </div>
                             <form action="usuario_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                 <input name="accion" value="6" type="hidden"/>
                                 <input name="vid_sucursal" value="0" type="hidden"/>
                                 <div class="box-body">
                                     <div class="form-group">
                                         <label class="col-sm-2 control-label">Sucursal:</label>
                                         <div class="col-sm-6 col-lg-6 col-xs-6 col-md-6">
                                             <input type="text" class="form-control" name="vusu_nick" required=""/>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="modal-footer">
                                     <button type="reset" data-dismiss="modal" class="btn btn-default">
                                         <a class="fa fa-remove"></a> Cerrar</button>
                                     <button type="submit" class="btn btn-primary pull-right">
                                         <a class="fa fa-floppy-o"></a> Registrar</button>
                                 </div>
                             </form>
                         </div>
                     </div>
                 </div>
                 <!--FIN MODAL REGISTRAR SUCURSAL-->
            </div>                  
        <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
    </body>
</html>


