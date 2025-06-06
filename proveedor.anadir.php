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
                                    <i class="ion ion-person-add"></i>
                                    <h3 class="box-title">Agregar Proveedor</h3>
                                    <div class="box-tools">
                                        <a href="proveedor.index.php" class="btn btn-primary pull-right btn-sm"
                                           data-title="Volver" rel="tooltip"  ><i class="fa fa-arrow-left"></i>
                                        </a>
                                    </div>
                                </div>
                                <form action="proveedor_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                    <input type="hidden" name="accion" value="1"/>
                                    <input type="hidden" name="vprv_cod" value="0"/>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">RUC N°:</label>
                                            <div class="col-lg-3 col-md-3 col-sm-4">
                                                <input type="text" name="vprv_ruc" class="form-control" required="" autofocus="" maxlength="9" minlength="6"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Razon Social:</label>
                                            <div class="col-lg-6 col-md-6 col-sm-7">
                                                <input type="text" name="vprv_razonsocial" class="form-control" required="" autofocus=""/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Direccion:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-5">
                                                <input type="text" name="vprv_direccion" class="form-control" required="" autofocus=""/>
                                            </div>
                                        </div>
                                         <div class="form-group">
                                            <label class="control-label col-lg-2">Telefono:</label>
                                            <div class="col-lg-6 col-md-6 col-sm-7">
                                                <input type="tel" name="vprv_telefono" class="form-control" required="" autofocus=""/>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="box-footer">
                                        <a href="proveedor.index.php" class="btn btn-default">
                                            <i class="fa fa-remove"></i> Cancelar
                                        </a>
                                        <button type="submit" class="btn btn-primary pull-right" data-title="Guardar datos" rel="tooltip">
                                            <i class="fa fa-floppy-o"> Registrar</i></button>
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


