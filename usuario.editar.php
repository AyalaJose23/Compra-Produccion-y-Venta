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
                        <div class="col-lg-12 col-md-12 col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-plus"></i>
                                    <h3 class="box-title">Modificar Usuario</h3>
                                    <div class="box-tools">
                                        <a href="usuario.index.php" class="btn btn-primary pull-right">
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    </div>
                                </div>
                                <form action="usuario_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                     <input type="hidden" name="accion" value="2"/>
                                    <div class="box-body">
                                        <?php $usuarios = consultas::get_datos("select * from v_usuarios where usu_cod =".$_REQUEST['vusu_cod'])?>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">USUARIO:</label>
                                            <div class="col-lg-3 col-md-3 col-sm-4">
                                                <input type="hidden" name="vusu_cod" value="<?php echo $usuarios[0]['usu_cod']?>"/>
                                                <input type="text" name="vusu_nick" value="<?php echo $usuarios[0]['usu_nick']?>"
                                                       class="form-control" autofocus=""/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">CLAVE:</label>
                                            <div class="col-lg-6 col-md-6 col-sm-7">
                                                <input type="text" name="vusu_clave" value="<?php echo $usuarios[0]['usu_clave'];?>"
                                                       class="form-control" required="" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php $empleados = consultas::get_datos("select * from empleado order by emp_cod =".$usuarios[0]['emp_cod']."desc");?>
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Empleado:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <div class="input-group">
                                                    <select class="form-control select2" name="vmar_cod" required="">
                                                        <?php foreach ($empleados as $empleado) { ?>
                                                        <option value="<?php echo $empleado['emp_cod'];?>"><?php echo $empleado['emp_nombre']." ".$empleado['emp_apellido'];?></option>
                                                        <?php } ?>
                                                         <option value="">Seleccione un empleado</option>
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
                                            <?php $grupos = consultas::get_datos("select * from grupos order by gru_cod =".$usuarios[0]['gru_cod']."desc");?>
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Grupo:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <div class="input-group">
                                                    <select class="form-control select2" name="vgru_cod" required="">
                                                        <?php foreach ($grupos as $grupo) { ?>
                                                        <option value="<?php echo $grupo['gru_cod'];?>"><?php echo $grupo['gru_nombre'];?></option>
                                                        <?php } ?>
                                                        <option value="">Seleccione un grupo</option>
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
                                            <?php $sucursales = consultas::get_datos("select * from sucursal order by id_sucursal =".$usuarios[0]['id_sucursal']."desc");?>
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Grupo:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <div class="input-group">
                                                    <select class="form-control select2" name="vid_sucursal" required="">
                                                        <?php foreach ($sucursales as $suc) { ?>
                                                        <option value="<?php echo $suc['id_sucursal'];?>"><?php echo $suc['suc_descri'];?></option>
                                                        <?php } ?>
                                                        <option value="">Seleccione una sucursal</option>
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
                                        <button type="submit" class="btn btn-warning pull-right" data-title="Actualizar datos" rel="tooltip">
                                            <i class="fa fa-pencil"> Actualizar</i></button>
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
                              <form action="empleado_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                  <input type="hidden" name="accion" value="4"/>
                                  <input type="hidden" name="vemp_cod" value="0"/>
                                  <div class="modal-body">
                                      <div class="form-group">
                                          <label class="control-label col-lg-2 col-sm-2 col-md-2">Nombre:</label>
                                          <div class="col-lg-10 col-sm-10 col-md-10">
                                              <input type="text" name="vemp_nombre" class="form-control" required=""/>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="modal-body">
                                      <div class="form-group">
                                          <label class="control-label col-lg-2 col-sm-2 col-md-2">Apellido:</label>
                                          <div class="col-lg-10 col-sm-10 col-md-10">
                                              <input type="text" name="vemp_apellido" class="form-control" required=""/>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="modal-body">
                                      <div class="form-group">
                                          <label class="control-label col-lg-2 col-sm-2 col-md-2">Direccion:</label>
                                          <div class="col-lg-10 col-sm-10 col-md-10">
                                              <input type="text" name="vemp_direcc" class="form-control" required=""/>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="modal-body">
                                      <div class="form-group">
                                          <label class="control-label col-lg-2 col-sm-2 col-md-2">Telefono:</label>
                                          <div class="col-lg-10 col-sm-10 col-md-10">
                                              <input type="text" name="vemp_tel" class="form-control" required=""/>
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
                 <!--INICIA MODAL REGISTRAR GRUPO-->
                 <div class="modal fade" id="registrar2" role="dialog">
                     <div class="modal-dialog">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                 <h4 class="modal-title">Registrar Grupo</h4>
                             </div>
                             <form action="grupo_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                 <input name="accion" value="5" type="hidden"/>
                                 <input name="vgru_cod" value="0" type="hidden"/>
                                 <div class="box-body">
                                     <div class="form-group">
                                         <label class="col-sm-2 control-label">Grupo</label>
                                         <div class="col-sm-6 col-lg-6 col-xs-6 col-md-6">
                                             <input type="text" class="form-control" name="vgru_nombre" required=""/>
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
                 <!--FIN MODAL REGISTRAR GRUPO-->
                 <!--INICIA MODAL REGISTRAR SUCURSAL-->
                 <div class="modal fade" id="registrar3" role="dialog">
                     <div class="modal-dialog">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                 <h4 class="modal-title">Registrar Suscursal</h4>
                             </div>
                             <form action="sucursal_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                 <input name="accion" value="5" type="hidden"/>
                                 <input name="vid_sucursal" value="0" type="hidden"/>
                                 <div class="box-body">
                                     <div class="form-group">
                                         <label class="col-sm-2 control-label">Sucursal</label>
                                         <div class="col-sm-6 col-lg-6 col-xs-6 col-md-6">
                                             <input type="text" class="form-control" name="vsuc_descri" required=""/>
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
        <script type="text/javascript"> 
            $("input[type=text]").focus(function(){	   
             this.select();
            });
       </script>
    </body>
</html>


