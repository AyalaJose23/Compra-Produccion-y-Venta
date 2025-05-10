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
         $valor = $_GET['vid_equipo'];
        session_start(); /* Reanudar sesion */
        require 'menu/css_lte.ctp';
        ?><!--ARCHIVOS CSS-->

    </head>
    <body class="hold-transition skin-black sidebar-mini">
        <div class="wrapper">
            <?php require 'menu/header_lte.ctp'; ?><!--CABECERA PRINCIPAL-->
            <?php require 'menu/toolbar_lte.ctp'; ?><!--MENU PRINCIPAL-->
            <div class="content-wrapper">
                <div class="content">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-edit"></i>
                                    <h3 class="box-title">Editar Equipo de Trabajo</h3>
                                    <div class="box-tools">
                                        <a href="equipo_trabajo.index.php" class="btn btn-primary btn-sm" data-title="Volver" rel="tooltip">
                                            <i class="fa fa-arrow-left"></i> VOLVER</a>
                                    </div>
                                </div>
                                <form action="equipo_trabajo.control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                    <?php $equipo_trabajo = consultas::get_datos("select * from v_equipo_t where id_equipo = ".$valor.""); ?>
                                    <input type="hidden" name="accion" value="2"/>
                                    <input type="hidden" name="vid_equipo" value="<?php echo $equipo_trabajo[0]['id_equipo']?>"/>                                    
                                    <div class="box-body">
                                        <!--INICIO PRIMERAS COLUMNAS-->
                                        <div class="form-group">
                                            <div class="col-lg-3 col-md-6 col-sm-6">
                                                <label>Fecha:</label>
                                                <input type="text" name="vfecha_creacion" class="form-control" value="<?php echo $equipo_trabajo[0]['fecha_creacion'];?>" readonly="">
                                            </div>
                                            </div>
                                    <!--FIN PRIMERAS COLUMNAS-->

                                    <div class="form-group">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                            <label class="col-lg-3 control-label">Nombre Equipo:</label>
                                                <input type="text" name="vnombre_equipo" value="<?php echo $equipo_trabajo[0]['nombre_equipo']?>"
                                                       class="form-control" required="" />
                                            </div>
                                            </div>
                                            
                                            
                                    <div class="box-footer">
                                        <button type="reset" class="btn btn-default" data-title="Cancelar" rel="tooltip">
                                            <i class="fa fa-remove"></i> Cancelar</button>                                        
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
        </div>                  
<?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
    </body>
</html>


