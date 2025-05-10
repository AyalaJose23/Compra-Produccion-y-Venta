<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="/lp3/favicon.ico">
    <title>LP3</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <?php 
    session_start(); /* Reanudar sesión */
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
                                <h3 class="box-title">
                                    <?php echo isset($_GET['vcli_cod']) ? "Editar Cliente" : "Agregar Cliente"; ?>
                                </h3>
                                <div class="box-tools">
                                    <a href="cliente.index.php" class="btn btn-primary pull-right btn-sm" data-title="Volver" rel="tooltip"><i class="fa fa-arrow-left"></i></a>
                                </div>
                            </div>
                            <form action="cliente_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                <input type="hidden" name="accion" value="<?php echo isset($_GET['vcli_cod']) ? '2' : '1'; ?>" />
                                <input type="hidden" name="vcli_cod" value="<?php echo isset($_GET['vcli_cod']) ? $_GET['vcli_cod'] : '0'; ?>" />
                                
                                <div class="box-body">
                                    <!-- Campo C.I. con validación de dígitos -->
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">C.I N°:</label>
                                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
                                            <input type="text" name="vcli_ci" class="form-control" required=""
                                                   onkeypress="return valideKey(event);" maxlength="8" minlength="6"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Nombres:</label>
                                        <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5">
                                            <input type="text" name="vcli_nombre" class="form-control" required="" />
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Apellidos:</label>
                                        <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5">
                                            <input type="text" name="vcli_apellido" class="form-control" required="" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Teléfono:</label>
                                        <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5">
                                            <input type="tel" name="vcli_telefono" class="form-control" required="" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Dirección:</label>
                                        <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5">
                                            <input type="text" name="vcli_direcc" class="form-control" required="" />
                                        </div>
                                    </div> 
                                </div>

                                <div class="box-footer">
                                    <a href="cliente.index.php" class="btn btn-default">
                                        <i class="fa fa-remove"></i> Cancelar
                                    </a>                                      
                                    <button type="submit" class="btn btn-primary pull-right" data-title="Guardar datos" rel="tooltip">
                                        <i class="fa fa-floppy-o"> Registrar</i>
                                    </button>
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
    function valideKey(evt) {
        var code = (evt.which) ? evt.which : evt.keyCode;
        if (code == 8) { // backspace
            return true;
        } else if (code >= 48 && code <= 57) { // es un número
            return true;
        } else { // otras teclas
            return false;
        }
    }
    </script>
</body>
</html>
