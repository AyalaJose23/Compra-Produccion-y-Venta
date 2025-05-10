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
        session_start(); /* Reanudar sesion */
        require 'menu/css_lte.ctp';
        ?><!--ARCHIVOS CSS-->

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php require 'menu/header_lte.ctp'; ?><!--CABECERA PRINCIPAL-->
            <?php require 'menu/toolbar_lte.ctp'; ?><!--MENU PRINCIPAL-->
            <div class="content-wrapper">
                <div class="content">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-plus"></i><i class="fa fa-money"></i>
                                    <h3 class="box-title">Agregar Ajuste Stock</h3>
                                    <div class="box-tools">
                                        <a href="stockajuste.index.php" class="btn btn-primary btn-sm" data-title="Volver" rel="tooltip">
                                            <i class="fa fa-arrow-left"></i> VOLVER</a>
                                    </div>
                                </div>
                                <form action="stockajuste_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                    <input type="hidden" name="accion" value="1"/>
                                    <input type="hidden" name="vajuste_cod" value="0"/>                                    
                                    <div class="box-body">
                                        <div class="form-group has-feedback">
                                            <?php $fecha = consultas::get_datos("select current_date as fecha");?>
                                            <label class="control-label col-lg-2 col-md-2">Fecha:</label>
                                            <div class="col-lg-3 col-md-3">
                                                <input type="date" class="form-control" value="<?php echo $fecha[0]['fecha'];?>" readonly=""/>
                                                <i class="fa fa-calendar form-control-feedback"></i>
                                            </div>
                                            <label class="control-label col-lg-2 col-md-2">Motivo:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-5">
                                                <input type="text" name="vajuste_motivo" class="form-control" required="" autofocus=""/>
                                            </div>                                          
                                        </div>
                                     <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2">Empleado:</label>
                                            <div class="col-lg-3 col-md-3">
                                                <input type="text" class="form-control"  value="<?php echo $_SESSION['nombres'];?>" readonly=""/>
                                            </div>
                                            <label class="control-label col-lg-2 col-md-2">Sucursal:</label>
                                            <div class="col-lg-3 col-md-3">
                                                <input type="text" class="form-control"  value="<?php echo $_SESSION['sucursal'];?>" readonly=""/>
                                            </div>                                            
                                        </div>                                     
                                    </div>  
                                    <div class="box-footer">
                                         <a href="stockajuste.index.php" class="btn btn-default">
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
        </div>                  
<?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
<script>
  
</script>
    </body>
</html>


