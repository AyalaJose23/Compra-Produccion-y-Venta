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
    <body class="hold-transition skin-green sidebar-mini">
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
                        <h3 class="page-header text-center alert-success"> <strong>AÑADIR PEDIDO</strong>
                            <a href="pedventas.index.php" 
                               class="btn btn-success  pull-right" 
                               rel='tooltip' title="Atras">
                                <i class="glyphicon glyphicon-arrow-left"></i>
                            </a> 

                        </h3>
                    </div>     
                    <!--Buscador-->

                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <strong>Agregar Pedido de Venta</strong>
                            </div>
                                <form action="pedventas_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                    <input type="hidden" name="accion" value="1"/>
                                    <input type="hidden" name="vped_cod" value="0"/>                                    
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-6 col-sm-6">
                                                <?php $fecha = consultas::get_datos("select current_date as fecha");?>
                                                <label>Fecha:</label>
                                                <input type="date" name="vped_fecha" class="form-control" value="<?php echo $fecha[0]['fecha'];?>" readonly="">
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <label>Clientes:</label>
                                                <?php $clientes = consultas::get_datos("select cli_cod,cli_ci,(cli_nombre||' '||cli_apellido) as nombres from clientes order by (cli_nombre||' '||cli_apellido) asc");?>                                            
                                                <div class="input-group">
                                                    <select class="form-control select2" name="vcli_cod" required="">
                                                        <option value="">Seleccione un cliente</option>
                                                        <?php foreach ($clientes as $cliente) { ?>
                                                        <option value="<?php echo $cliente['cli_cod'];?>"><?php echo $cliente['nombres'];?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <span class="input-group-btn">
                                                        
                                                    </span>
                                                </div>                                            
                                            </div>                                            
                                        </div>
                                        <div class="row">
                                            
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <label>Empleado:</label>
                                                <input type="text" class="form-control" value="<?php echo $_SESSION['nombres'];?>" readonly="">
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


