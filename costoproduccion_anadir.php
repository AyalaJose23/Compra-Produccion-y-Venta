<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" href="img/mueble.png"/>
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
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="content-wrapper">
                        <div class="content">
                            <div class="row">
                                <!--impresion del titulo de la pagina-->
                                <div class="col-lg-12">
                                    <h3 class="page-header text-center alert-info"> <strong>AÑADIR COSTO PRODUCCIÓN</strong>
                                        <a href="costoproduccion_index.php" class="btn btn-primary pull-right" rel='tooltip' title="Atras">
                                            <i class="glyphicon glyphicon-arrow-left"></i>
                                        </a> 
                                    </h3>
                                </div>
                            </div>
                            <!-- /.row -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <strong>Agregar Control Producción</strong>
                                        </div>
                                        <form action="costoproduccion_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                            <input type="hidden" name="accion" value="1"/>
                                            <input type="hidden" name="vid_costo" value="0"/>                                    
                                            <div class="box-body">
                                                <div class="form-group has-feedback"> 
                                                    <?php $fecha = consultas::get_datos("select current_date as fecha"); ?>
                                                    <label class="control-label col-lg-2 col-md-2 col-sm-2">Fecha:</label>
                                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                                        <input type="date" class="form-control" value="<?php echo $fecha[0]['fecha']; ?>" id="fechaInspeccion" onblur="fechaac()"/>
                                                        <i class="fa fa-calendar form-control-feedback"></i>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <?php $pedidos = consultas::get_datos("select * from v_orden_produ order by cod_orden"); ?>
                                                    <label class="control-label col-lg-2 col-md-2 col-sm-2">Orden de Trabajo:</label>
                                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                                        <div class="input-group">
                                                            <select class="form-control select2" name="vcod_orden" required="" style="width: 100%;">
                                                                <option value="">Seleccione una orden</option>
                                                                <?php foreach ($pedidos as $pedido) { ?>
                                                                    <?php if ($pedido['orden_prod_estado'] == 'EN PROCESO') { ?>
                                                                        <option value="<?php echo $pedido['cod_orden']; ?>">
                                                                            <?php echo "Orden N°: " . $pedido['cod_orden'] . " Fecha: " . $pedido['ord_prod_fecha']; ?>
                                                                        </option>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-lg-2 col-md-2 col-sm-2">Empleado:</label>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <input type="text" class="form-control" value="<?php echo $_SESSION['nombres']; ?>" readonly=""/>
                                                    </div>                                           
                                                </div>
                                            </div>
                                            <div class="box-footer">
                                                <a href="costoproduccion_index.php" class="btn btn-default">
                                                    <i class="fa fa-remove"></i> Cancelar
                                                </a>                                         
                                                <button type="submit" class="btn btn-primary pull-right" data-title="Guardar datos" rel="tooltip">
                                                    <i class="fa fa-floppy-o"></i> Registrar
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
