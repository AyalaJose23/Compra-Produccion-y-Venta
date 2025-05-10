<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="image/x-icon" href="/lp3/favicon.ico">
        <title>LP3</title>
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
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <?php if(!empty($_SESSION['mensaje'])) { ?>
                            <div class="alert alert-danger" role="alert" id="mensaje">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                <?php echo $_SESSION['mensaje']; $_SESSION['mensaje'] = ''; ?>
                            </div>
                            <?php } ?>

                            <h3 class="page-header text-center alert-info">
                                <strong>DETALLE ORDEN DE COMPRA</strong>
                                <a href="orden.index.php" class="btn btn-primary pull-right" rel="tooltip" title="Atras">
                                    <i class="glyphicon glyphicon-arrow-left"></i>
                                </a>
                            </h3>

                            <!-- Panel Datos Cabecera de la Orden -->
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <strong>Datos Cabecera de la Orden</strong>
                                </div>
                                <div class="panel-body">
                                    <?php 
                                    $ordenes = consultas::get_datos("select * from v_orden_compra where orden_cod=" . $_REQUEST['vorden_cod']);
                                    if (!empty($ordenes)) { ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Fecha</th>
                                                        <th>Proveedor</th>
                                                        <th>Total</th>
                                                        <th>Estado</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($ordenes as $orden) { ?>
                                                    <tr>
                                                        <td><?php echo $orden['orden_cod']; ?></td>
                                                        <td><?php echo $orden['orden_fecha']; ?></td>
                                                        <td><?php echo $orden['proveedor']; ?></td>
                                                        <td><?php echo number_format($orden['orden_total'], 0, ",", "."); ?></td>
                                                        <td><?php echo $orden['orden_estado']; ?></td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php } else { ?>
                                        <div class="alert alert-info">
                                            <span class="glyphicon glyphicon-info-sign"></span> No se encontraron registros..
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <!-- Panel Detalle Items del Presupuesto -->
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <strong>Detalle Items del Presupuesto N°<?php echo $ordenes[0]['orden_cod']; ?></strong>
                                </div>
                                <div class="panel-body">
                                    <?php
                                    $presudet = consultas::get_datos("select * from v_detalle_pp where art_cod not in (select art_cod from v_detalle_ordens where orden_cod = " . $ordenes[0]['orden_cod'] . ") and cod_pp=" . $ordenes[0]['cod_pp']);
                                    if (!empty($presudet)) { ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-condensed table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Descripción</th>
                                                        <th>Cant.</th>
                                                        <th>Precio</th>
                                                        <th>Subtotal</th>
                                                        <th class="text-center">Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($presudet as $pdet) { ?>
                                                    <tr>
                                                        <td><?php echo $pdet['cod_pp']; ?></td>
                                                        <td>Articulo: <?php echo $pdet['art_descri']; ?> Marca: <?php echo $pdet['mar_descri']; ?></td>
                                                        <td><?php echo $pdet['cantidad']; ?></td>
                                                        <td><?php echo number_format($pdet['precio'], 0, ",", "."); ?></td>
                                                        <td><?php echo number_format($pdet['subtotal'], 0, ",", "."); ?></td>
                                                        <td class="text-center">
                                                            <a onclick="agregar(<?php echo $ordenes[0]['orden_cod']; ?>, <?php echo $pdet['cod_pp']; ?>, <?php echo $pdet['art_cod']; ?>)" class="btn btn-success btn-sm" data-title="Agregar" rel="tooltip" data-toggle="modal" data-target="#editar">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <!-- Panel Detalle de la Orden de Compras -->
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <strong>Detalle de la Orden de Compras</strong>
                                </div>
                                <div class="panel-body">
                                    <?php
                                    $detalles = consultas::get_datos("select * from v_detalle_ordens where orden_cod=" . $ordenes[0]['orden_cod']);
                                    if (!empty($detalles)) { ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-condensed table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Descripción</th>
                                                        <th>Cant.</th>
                                                        <th>Precio/u</th>
                                                        <th>Impuesto</th>
                                                        <th>Subtotal</th>
                                                        <th class="text-center">Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($detalles as $det) { ?>
                                                    <tr>
                                                        <td><?php echo $det['art_cod']; ?></td>
                                                        <td><?php echo $det['art_descri'] . " " . $det['mar_descri']; ?></td>
                                                        <td><?php echo $det['orden_cant']; ?></td>
                                                        <td><?php echo number_format($det['orden_precio'], 0, ",", "."); ?></td>
                                                        <td><?php echo $det['tipo_descri']; ?></td>
                                                        <td><?php echo number_format($det['subtotal'], 0, ",", "."); ?></td>
                                                        <td class="text-center">
                                                            <a onclick="editar(<?php echo $det['orden_cod']; ?>, <?php echo $det['art_cod']; ?>)" class="btn btn-warning btn-sm" data-title="Editar" rel="tooltip" data-toggle="modal" data-target="#editar">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <a onclick="borrar(<?php echo "'" . $det['orden_cod'] . "_" . $det['art_cod'] . "_" . $det['art_descri'] . " " . $det['mar_descri'] . "'"; ?>)" class="btn btn-danger btn-sm" data-title="Quitar" rel="tooltip" data-toggle="modal" data-target="#borrar">
                                                                <i class="fa fa-trash-o"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php } else { ?>
                                        <div class="alert alert-info">
                                            <span class="glyphicon glyphicon-info-sign"></span> La orden aún no tiene detalles cargados...
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <?php require 'menu/footer_lte.ctp'; ?><!--ARCHIVOS JS-->
            <!-- Modal Confirmar -->
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
            <!-- Modal Borrar -->
            <div class="modal" id="borrar" role="dialog">
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
            <!-- Modal Editar -->
            <div class="modal" id="editar" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content" id="detalles"></div>
                </div>
            </div>
        </div>
        <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
        <!-- ARCHIVOS JS -->
            <script>
                $("#mensaje").delay(4000).slideUp(200, function () {
                    $(this).alert('close');
                });
            </script>

            <script>
                function borrar(datos) {
                    var dat = datos.split('_');
                    $('#si').attr('href', 'orden_dcontrol.php?vorden_cod=' + dat[0] + '&vart_cod=' + dat[1] + '&accion=3');
                    $("#confirmacion").html('<span class="glyphicon glyphicon-warning-sign"></span> \\n\\ Desea quitar el articulo <strong>' + dat[2] + '</strong> ?');
                }

                function precio() {
                    var dat = $('#articulo').val().split('_');
                    $('#vprecio').val(dat[1]);
                }  
                


                function editar(com, art) {
                    $.ajax({
                        type: "GET",
                        url: "/tdp/orden_dedit.php?vorden_cod=" + com + "&vart_cod=" + art,
                        cache: false,
                        beforeSend: function () {
                            $('#detalles').html('<img src="img/loader.gif" /><strong>Cargando...</strong>');
                        },
                        success: function (data) {
                            $('#detalles').html(data);
                        }
                    });
                }

                function agregar(com, pr, art) {
                    $.ajax({
                        type: "GET",
                        url: "/tdp/orden_dadd.php?vorden_cod=" + com + "&vcop_pp=" + pr + "&vart_cod=" + art,
                        cache: false,
                        beforeSend: function () {
                            $('#detalles').html('<img src="img/loader.gif" /><strong>Cargando...</strong>');
                        },
                        success: function (data) {
                            $('#detalles').html(data);
                        }
                    });
                }

                function confirmar(datos) {
                    var dat = datos.split('_');
                    $('#sic').attr('href', 'orden_control.php?vorden_cod=' + dat[0] + '&accion=2');
                    $("#confirmacionc").html('<span class="glyphicon glyphicon-info-sign"></span> \\n\\ Desea confirmar la Compra N° <strong>' + dat[0] + '</strong> del proveedor <strong>' + dat[1] + '</strong> de fecha <strong>' + dat[2] + '</strong>')
                }
            </script>
                    
    </body>
</html>

    </body>
</html>
