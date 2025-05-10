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
        session_start(); /* Reanudar sesión */
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
                        <!-- Impresión del título de la página -->
                        <div class="col-lg-12">
                            <h3 class="page-header text-center alert-info">
                                <strong>AÑADIR PEDIDO</strong>
                                
                                <a href="pedcompras.index.php" class="btn btn-primary pull-right" rel="tooltip" title="Atrás">
                                    <i class="glyphicon glyphicon-arrow-left"></i>
                                </a> 
                            </h3>
                        </div>
                    </div>

                    <!-- Buscador -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <strong>Agregar Pedido de Compra</strong>
                                </div>
                                <form action="pedcompras_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                    <input type="hidden" name="accion" value="1"/>
                                    <input type="hidden" name="vped_com" value="0"/>
                                    
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-6 col-sm-6">
                                                <?php $fecha = consultas::get_datos("select current_date as fecha");?>
                                                <label>Fecha:</label>
                                                <input type="date" name="vped_fecha" class="form-control" value="<?php echo $fecha[0]['fecha'];?>" readonly="">
                                            </div>
                                            
                                            <div class="col-lg-3 col-md-6 col-sm-6">
                                                <label>N° Pedido MP:</label>
                                                <select class="form-control"  name="vped_mp" id="pedid">
                                                    <option value="">Seleccione un pedido de MP</option>
                                                    <?php
                                                    $pedidos = consultas::get_datos("select * from v_pedido_mp where ped_estado ='PENDIENTE' order by ped_mp");
                                                    ?>
                                                    <?php foreach ($pedidos as $ped) { ?>
                                                        <option value="<?php echo $ped['ped_mp']; ?>">
                                                            <?php echo $ped['ped_mp'] . " - " . $ped['ped_fecha']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div> 
                                                
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <label>Empleado:</label>
                                                <input type="text" class="form-control" value="<?php echo $_SESSION['nombres'];?>" readonly="">
                                            </div>
                                            
                                            <div class="col-lg-3 col-md-6 col-sm-6">
                                                <label>Observación:</label>
                                                <input type="text" class="form-control" name="vobs_pedido" value="SIN OBSERVACION"/>
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
