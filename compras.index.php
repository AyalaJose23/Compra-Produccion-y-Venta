<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" href="img/mueble.png"/>
        <title>Todo Muebles</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php 
        session_start();
        require 'menu/css_lte.ctp'; ?><!--ARCHIVOS CSS-->
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php require 'menu/header_lte.ctp'; ?><!--CABECERA PRINCIPAL-->
            <?php require 'menu/toolbar_lte.ctp'; ?><!--MENU PRINCIPAL-->

            <div class="content-wrapper">
                <section class="content">
                    <div class="row">
                        <div class="col-lg-12 col-xs-12 col-md-12">
                            <?php if (!empty($_SESSION['mensaje'])) { ?>
                                <div class="alert alert-danger" role="alert" id="mensaje">
                                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                                    <?php echo $_SESSION['mensaje']; $_SESSION['mensaje'] = ''; ?>
                                </div>
                            <?php } ?>
                            
                            <h3 class="page-header text-center">
                                <strong>FACTURA DE COMPRA</strong>
                                <a href="/tdp/MANUAL DE USUARIO tdp.pdf" target="print">
                                    <span class="glyphicon glyphicon-question-sign"></span>
                                </a>
                                <a href="compras.anadir.php" class="btn btn-primary pull-right" data-title="Agregar" rel="tooltip" data-placement="left">
                                    <i class="fa fa-plus"></i> AGREGAR
                                </a>
                            </h3>
                            
                            <div class="box-body no-padding">
                                <form method="post" accept-charset="utf-8" class="form-horizontal">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <div class="input-group custom-search-form">
                                                <input type="search" name="buscar" class="form-control" placeholder="Ingrese valor a buscar..." autofocus=""/>
                                                <span class="input-group-btn">
                                                    <button type="submit" class="btn btn-primary btn-flat" data-title="Buscar" rel="tooltip">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    Datos
                                </div>
                                <div class="panel-body">
                                    <?php
                                    $compras = consultas::get_datos("select * from v_compras where (com_cod::varchar||com_fecha::varchar) ilike '%" . (isset($_REQUEST['buscar']) ? $_REQUEST['buscar'] : "") . "%' order by com_cod desc");
                                    if (!empty($compras)) { ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Fecha Compra</th>
                                                        <th>Proveedor</th>
                                                        <th>Condición</th>
                                                        <th>Estado</th>
                                                        <th class="text-center">Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($compras as $compra) { ?>
                                                    <tr>
                                                        <td><?php echo $compra['com_cod']; ?></td>
                                                        <td><?php echo $compra['com_fecha']; ?></td>
                                                        <td><?php echo $compra['proveedor']; ?></td>
                                                        <td><?php echo $compra['tipo_compra']; ?></td>
                                                        <td><?php echo $compra['com_estado']; ?></td>
                                                        <td class="text-center">
                                                            <?php if($compra['com_estado'] == 'PENDIENTE') { ?>
                                                                <a onclick="confirmar('<?php echo $compra['com_cod'] . '_' . $compra['proveedor'] . '_' . $compra['com_fecha'] . '_' . $compra['orden_cod']; ?>')" 
                                                                   class="btn btn-success btn-sm" data-title="Confirmar" rel="tooltip" data-toggle="modal" data-target="#confirmar">
                                                                    <i class="fa fa-check"></i>
                                                                </a>   
                                                                <a onclick="anular('<?php echo $compra['com_cod'] . '_' . $compra['proveedor'] . '_' . $compra['com_fecha']; ?>')" 
                                                                   class="btn btn-danger btn-sm" data-title="Anular" rel="tooltip" data-toggle="modal" data-target="#anular">
                                                                    <i class="fa fa-remove"></i>
                                                                </a> 
                                                            <?php } ?>
                                                            <?php if ($compra['com_estado'] == 'PENDIENTE' || $compra['com_estado'] == 'CONFIRMADO') { ?>
                                                                <a href="compras.det.php?vcom_cod=<?php echo $compra['com_cod']; ?>" class="btn btn-primary btn-sm" data-title="Detalles" rel="tooltip">
                                                                    <i class="fa fa-list"></i>
                                                                </a>                                                                                                                                                                   
                                                            <?php } ?>
                                                            <a href="compras.print.php?vcom_cod=<?php echo $compra['com_cod']; ?>" class="btn btn-default btn-sm" data-title="Imprimir" rel="tooltip" target="print">
                                                                <i class="fa fa-print"></i>
                                                            </a>   
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php } else { ?>
                                        <div class="alert alert-info flat">
                                            <span class="glyphicon glyphicon-info-sign"></span>
                                            No se han registrado compras..
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <?php require 'menu/footer_lte.ctp'; ?><!--ARCHIVOS JS--> 
            
            <!-- MODAL CONFIRMAR -->
            <div class="modal" id="confirmar" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                            <h4 class="modal-title custom_align">Atención!!!</h4>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-success" id="confirmacionc"></div>
                        </div>
                        <div class="modal-footer">
                            <a id="sic" role="button" class="btn btn-primary">
                                <span class="glyphicon glyphicon-ok-sign"></span> SI
                            </a>
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                <span class="glyphicon glyphicon-remove"></span> NO
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODAL ANULAR -->
            <div class="modal" id="anular" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                            <h4 class="modal-title custom_align">Atención!!!</h4>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger" id="confirmacion"></div>
                        </div>
                        <div class="modal-footer">
                            <a id="si" role="button" class="btn btn-primary">
                                <span class="glyphicon glyphicon-ok-sign"></span> SI
                            </a>
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                <span class="glyphicon glyphicon-remove"></span> NO
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
        
        <script>
            $("#mensaje").delay(4000).slideUp(200, function() {
                $(this).alert('close'); 
            });
            
            function anular(datos) {
                var dat = datos.split('_');
                $('#si').attr('href', 'compras_control.php?vcom_cod=' + dat[0] + '&accion=3');
                $("#confirmacion").html('<span class="glyphicon glyphicon-warning-sign"></span> \n\
                Desea anular la Compra N° <strong>' + dat[0] + '</strong> del proveedor <strong>' + dat[1] + '</strong> de fecha <strong>' + dat[2] + '</strong>')
            }

            function confirmar(datos) {
                var dat = datos.split('_');
                $('#sic').attr('href', 'compras_control.php?vcom_cod=' + dat[0] + '&vorden_cod=' + dat[3] + '&accion=2');
                $("#confirmacionc").html('<span class="glyphicon glyphicon-info-sign"></span> \n\
                Desea confirmar la compra N° <strong>' + dat[0] + '</strong> del proveedor <strong>' + dat[1] + '</strong> de fecha <strong>' + dat[2] + '</strong>')
            }
        </script>
    </body>
</html>
