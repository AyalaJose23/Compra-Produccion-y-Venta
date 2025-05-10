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
                                    <h3 class="box-title">Editar Pedido de Materia Prima</h3>
                                    <div class="box-tools">
                                        <a href="pedmp.index.php" class="btn btn-primary btn-sm" data-title="Volver" rel="tooltip">
                                            <i class="fa fa-arrow-left"></i> VOLVER</a>
                                    </div>
                                </div>
                                <form action="pedmp_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                    <?php $pedidos = consultas::get_datos("select * FROM v_pedido_mp WHERE ped_mp = ( select max(ped_mp) from v_pedido_mp)");?>
                                    <input type="hidden" name="accion" value="2"/>
                                    <input type="hidden" name="vped_mp" value="<?php echo $pedidos[0]['ped_mp']?>"/>                                    
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-6 col-sm-6">
                                                
                                                <label>Fecha:</label>
                                                <input type="text" name="vped_fecha" class="form-control" value="<?php echo $pedidos[0]['ped_fecha'];?>" readonly="">
                                            </div>
                                                                                    
                                        </div>
                                          
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <label>Empleado:</label>
                                                <input type="text" class="form-control" value="<?php echo $pedidos[0]['empleado'];?>" readonly="">
                                            </div>                                              
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


