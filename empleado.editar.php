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
                                    <h3 class="box-title">Modificar Empleado</h3>
                                    <div class="box-tools">
                                        <a href="empleado.index.php" class="btn btn-primary pull-right">
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    </div>
                                </div>
                                <form action="empleado_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                     <input type="hidden" name="accion" value="2"/>
                                    <div class="box-body">
                                        <?php $empleados = consultas::get_datos("select * from v_empleado where emp_cod =".$_REQUEST['vemp_cod'])?>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Nombre:</label>
                                            <div class="col-lg-3 col-md-3 col-sm-4">
                                                <input type="hidden" name="vemp_cod" value="<?php echo $empleados[0]['emp_cod']?>"/>
                                                <input type="text" name="vemp_nombre" value="<?php echo $empleados[0]['emp_nombre']?>"
                                                       class="form-control" autofocus=""/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Apellido:</label>
                                            <div class="col-lg-6 col-md-6 col-sm-7">
                                                <input type="text" name="vemp_apellido" value="<?php echo $empleados[0]['emp_apellido']?>"
                                                       class="form-control" required="" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php $cargos = consultas::get_datos("select * from cargo order by car_cod =".$empleados[0]['car_cod']."desc");?>
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Sucursal:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <div class="input-group">
                                                    <select class="form-control select2" name="vcar_cod" required="">
                                                        <?php foreach ($cargos as $car) { ?>
                                                        <option value="<?php echo $car['car_cod'];?>"><?php echo $car['car_descri'];?></option>
                                                        <?php } ?>
                                                        <option value="">Seleccione el sucursal</option>
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
                                            <label class="col-lg-2 control-label">Descripcion:</label>
                                            <div class="col-lg-6 col-md-6 col-sm-7">
                                                <input type="text" name="vemp_direcc" value="<?php echo $empleados[0]['emp_direcc']?>"
                                                       class="form-control" required="" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Telefono:</label>
                                            <div class="col-lg-6 col-md-6 col-sm-7">
                                                <input type="tel" name="vemp_tel" value="<?php echo $empleados[0]['emp_tel']?>"
                                                       class="form-control" required="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                       <a href="empleado.index.php" class="btn btn-default">
                                            <i class="fa fa-remove"></i> Cancelar
                                        </a>
                                        <button type="submit" class="btn btn-info pull-right" data-title="Actualizar datos" rel="tooltip">
                                            <i class="fa fa-pencil"> Actualizar</i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                  <?php require 'menu/footer_lte.ctp'; ?><!--ARCHIVOS JS--> 
       
            </div>                  
        <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
        <script type="text/javascript"> 
            $("input[type=text]").focus(function(){	   
             this.select();
            });
       </script>
    </body>
</html>


