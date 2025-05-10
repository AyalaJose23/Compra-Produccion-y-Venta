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
                                    <h3 class="box-title">Agregar Stock</h3>
                                    <div class="box-tools">
                                        <a href="stock.index.php" class="btn btn-primary btn-sm" data-title="Volver" rel="tooltip">
                                            <i class="fa fa-arrow-left"></i></a>
                                    </div>
                                </div>
                                <form action="stock_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                    <input type="hidden" name="accion" value="1"/>
                                    <input type="hidden" name="vart_cod" value="0"/>                                    
                                    <div class="box-body">
                                        <div class="form-group">
                                            <?php $depositos = consultas::get_datos("select * from deposito order by dep_cod desc");?>
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Deposito:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <div class="input-group">
                                                    <select class="form-control select2" name="vdep_cod" required="">
                                                        <option value="">Seleccione el deposito</option>
                                                        <?php foreach ($depositos as $depo) { ?>
                                                        <option value="<?php echo $depo['dep_cod'];?>"><?php echo $depo['dep_descri'];?></option>
                                                        <?php } ?>
                                                    </select>
                                                   <!-- <span class="input-group-btn">
                                                        <button type="button" class="btn btn-primary btn-flat" 
                                                                data-toggle="modal" data-target="#registrar">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </span>-->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php $articulos = consultas::get_datos("select * from articulo order by art_descri");?>
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Articulo:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <div class="input-group">
                                                    <select class="form-control select2" name="vart_cod" required="">
                                                        <option value="">Seleccione un articulo</option>
                                                        <?php foreach ($articulos as $articulo) { ?>
                                                        <option value="<?php echo $articulo['art_cod'];?>"><?php echo $articulo['art_descri'];?></option>
                                                        <?php } ?>
                                                    </select>
                                                   <!-- <span class="input-group-btn">
                                                        <button type="button" class="btn btn-primary btn-flat" 
                                                                data-toggle="modal" data-target="#registrar2">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </span>-->
                                                </div>
                                            </div>
                                        </div> 
                                         <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Cant. Minima:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <input type="number" class="form-control" name="vcant_minima" min="0"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Cant. Real:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <input type="number" class="form-control" name="vstoc_cant" min="0"/>
                                            </div>
                                        </div> 
                                    </div>  
                                    <div class="box-footer">
                                        <a href="stock.index.php" class="btn btn-default">
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
    </body>
</html>


