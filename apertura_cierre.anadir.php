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
            <div class="content-wrapper">
                <div class="content">
                    <div class="row">
                        <!-- Impresión del título de la página -->
                        <div class="col-lg-12">
                            <h3 class="page-header text-center alert-success">
                                <strong>AÑADIR APERTURA DE CAJA</strong>
                                
                                <a href="apertura_cierre.php" class="btn btn-success pull-right" rel="tooltip" title="Atrás">
                                    <i class="glyphicon glyphicon-arrow-left"></i>
                                </a> 
                            </h3>
                        </div>
                    </div>

                    <!-- Buscador -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <strong>Registrar Apertura de Caja</strong>
                                </div>
                                <form action="apertura_cierre_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                    <input type="hidden" name="accion" value="1"/>
                                    <input type="hidden" name="vid_apercierre" value="0"/>                                    
                                    <div class="box-body"> 

                                    <!-- Monto Inicial -->
                                    <div class="form-group">
                                        <label class="control-label col-lg-2 col-md-2">Monto Inicial:</label>
                                        <div class="col-lg-3 col-md-3">
                                            <input type="number" name="vaper_monto" class="form-control" required placeholder="Ingrese el monto inicial"/>
                                        </div>
                                    </div>

                                        <!-- Seleccionar Caja -->
                                        
                                        <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2">Caja:</label>
                                            <div class="col-lg-5 col-md-5">
                                                <select required class="form-control" name="id_caja" id="detalles">
                                                <option value="0">Seleccione una caja</option>
                                                <?php
                                                $cajas = consultas::get_datos("SELECT * FROM cajas");
                                                foreach ($cajas as $c) {
                                                    echo "<option value='{$c['id_caja']}'>{$c['caja_descripcion']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                        <!-- Fecha de Apertura -->
                                        <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2">Fecha de Apertura:</label>
                                            <div class="col-lg-3 col-md-3">
                                                <input type="text" class="form-control" value="<?php echo date('d/m/Y H:i:s'); ?>" readonly/>
                                            </div>
                                        </div>
                                        <!-- Monto Inicial -->
                                        <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2" for="montocierre">Monto Cierre:</label>
                                            <div class="col-lg-3 col-md-3">
                                                <input type="text" name="txtmontocierre" id="txtmontocierre" title="txtmontocierre" class="form-control" value="" disabled=""/>
                                            </div>
                                        </div>
                                        

                                    </div>

                                    <!-- Botones -->
                                    <div class="box-footer">
                                        <button type="reset" class="btn btn-default" data-title="Cancelar" rel="tooltip">
                                            <i class="fa fa-remove"></i> Cancelar</button>                                        
                                        <!-- Botón de submit -->
                                        <button type="submit" class="btn btn-primary pull-right">Confirmar Apertura</button>
                                    </form>
                                            <!--div class="col-md-2 text-right">
                                                <input id="btnGrabar" type="button" class="form-control btn-success" value="Grabar"  onclick="grabar();"/>
                                            </div-->
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
            document.querySelector('form').addEventListener('submit', function(event) {
                const cajaSelect = document.querySelector('select[name="id_caja"]');
                if (cajaSelect.value === "0") {
                    alert("Por favor seleccione una caja válida.");
                    event.preventDefault();
                }
            });
            </script>


            <?php require 'menu/footer_lte.ctp'; ?><!--ARCHIVOS JS-->
        </div>

        <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
    </body>
</html>
