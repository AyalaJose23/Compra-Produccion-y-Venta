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
                        <div class="col-lg-12">
                            <?php if(!empty($_SESSION['mensaje'])) { ?>
                            <div class="alert alert-danger" role="alert" id="mensaje">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                <?php echo $_SESSION['mensaje']; $_SESSION['mensaje'] = ''; ?>
                            </div>
                            <?php } ?>
                            <h3 class="page-header text-center alert-info">
                                <strong>DETALLE PRESUPUESTO DE COMPRA</strong>
                                <a href="presupuesto.index.php" class="btn btn-primary pull-right" rel="tooltip" title="Atras">
                                    <i class="glyphicon glyphicon-arrow-left"></i>
                                </a>
                            </h3>
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <strong>Datos Cabecera del Presupuesto</strong>
                                </div>
                                <div class="panel-body">
                                    <?php
                                    $presupuestos = consultas::get_datos("select * from v_pp where cod_pp=" . $_REQUEST['vcod_pp'] . ""); 
                                    if (!empty($presupuestos)) { ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-condensed">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Fecha</th>
                                                    <th>Validez</th>
                                                    <th>Proveedor</th>
                                                    <th>Total</th>
                                                    <th>Observaciones</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($presupuestos as $presu) { ?>
                                                <tr>
                                                    <td><?php echo $presu['cod_pp']; ?></td>
                                                    <td><?php echo $presu['pp_fecha']; ?></td>
                                                    <td><?php echo $presu['pp_validez']; ?></td>
                                                    <td><?php echo $presu['proveedor']; ?></td>
                                                    <td><?php echo number_format($presu['monto'], 0, ",", "."); ?></td>
                                                    <td><?php echo $presu['pp_obs']; ?></td>
                                                    <td><?php echo $presu['estado']; ?></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php } else { ?>
                                    <div class="alert alert-info">
                                        <span class="glyphicon glyphicon-info-sign"></span> No se encontraron registros.
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <strong>Detalle Pedido de Compra N°<?php echo $presupuestos[0]['cod_pp']; ?></strong>
                                </div>
                                <div class="panel-body">
                                    <?php
                                    $pedidodet = consultas::get_datos("select * from v_detalle_pedcompra where art_cod not in (select art_cod from v_detalle_pp where cod_pp = ".$presupuestos[0]['cod_pp'].") and ped_com= ".$presupuestos[0]['ped_com']."");
                                    if (!empty($pedidodet)) { ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-condensed">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Descripción</th>
                                                    <th>Cant.</th>
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($pedidodet as $pdet) { ?>
                                                <tr>
                                                    <td><?php echo $pdet['ped_com']; ?></td>
                                                    <td><?php echo $pdet['art_descri']; ?></td>
                                                    <td><?php echo $pdet['ped_cant']; ?></td>
                                                    <td class="text-center">
                                                        <a onclick="agregar(<?php echo $presupuestos[0]['cod_pp']; ?>, <?php echo $pdet['ped_com']; ?>, <?php echo $pdet['art_cod']; ?>)" class="btn btn-success btn-sm" data-title="Agregar" rel="tooltip" data-toggle="modal" data-target="#editar">
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

                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <strong>Detalle de Presupuesto Compras</strong>
                                </div>
                                <div class="panel-body">
                                    <?php $detalles = consultas::get_datos("select * from v_detalle_pp where cod_pp =" . $presupuestos[0]['cod_pp']);
                                    if (!empty($detalles)) { ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-condensed">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Descripción</th>
                                                    <th>Cant.</th>
                                                    <th>Precio/u</th>
                                                    <th>Subtotal</th>
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($detalles as $det) { ?>
                                                <tr>
                                                    <td><?php echo $det['cod_pp']; ?></td>
                                                    <td>Articulo: <?php echo $det['art_descri']; ?> Marca: <?php echo $det['mar_descri']; ?></td>
                                                    <td><?php echo $det['cantidad']; ?></td>
                                                    <td><?php echo number_format($det['precio'], 0, ",", "."); ?></td>
                                                    <td><?php echo number_format($det['subtotal'], 0, ",", "."); ?></td>
                                                    <td class="text-center">
                                                        <a onclick="borrar('<?php echo $det['cod_pp'] . '_' . $det['art_cod'] . '_' . $det['art_descri']; ?>')" class="btn btn-danger btn-sm" data-title="Quitar" rel="tooltip" data-toggle="modal" data-target="#borrar">
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
                                        <span class="glyphicon glyphicon-info-sign"></span> No hay detalles cargados.
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <?php require 'menu/footer_lte.ctp'; ?><!--ARCHIVOS JS-->
            <!-- MODAL CONFIRMAR-->
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
            <!-- FIN MODAL CONFIRMAR-->
            <!-- MODAL BORRAR-->
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
            <!-- FIN MODAL BORRAR-->
            <!-- MODAL EDITAR-->
            <div class="modal" id="editar" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content" id="detalles"></div>
                </div>
            </div>
            <!-- FIN MODAL EDITAR-->
        </div>

        <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
        <script>
            $("#mensaje").delay(4000).slideUp(200, function () {
                $(this).alert('close');
            });
        </script>
        <script>
            function borrar(datos) {
                var dat = datos.split('_');
                $('#si').attr('href', 'presupuesto_dcontrol.php?vcod_pp=' + dat[0] + '&vart_cod=' + dat[1] + '&accion=3');
                $("#confirmacion").html('<span class="glyphicon glyphicon-warning-sign"></span> \\n\\ Desea quitar el articulo <strong>' + dat[2] + '</strong> ?');
            }

            function agregar(com, pr, art) {
                $.ajax({
                    type: "GET",
                    url: "/tdp/presupuesto_dadd.php?vcod_pp=" + com + "&vped_com=" + pr + "&vart_cod=" + art,
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
                $('#sic').attr('href', 'presupuesto_control.php?vcod_pp=' + dat[0] + '&accion=2');
                $("#confirmacionc").html('<span class="glyphicon glyphicon-info-sign"></span> \\n\\ Desea confirmar el presupuesto N° <strong>' + dat[0] + '</strong> del proveedor <strong>' + dat[1] + '</strong> de fecha <strong>' + dat[2] + '</strong>')
            }
        </script>
    </body>
</html>
