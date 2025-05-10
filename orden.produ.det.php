<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon"  href=" img/mueble.png"/>
        <title>Todo Muebles</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php 
        session_start();
        require 'menu/css_lte.ctp'; ?><!--ARCHIVOS CSS-->
    </head>
    <body class="hold-transition skin-black sidebar-mini">
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

                            <h3 class="page-header text-center  alert alert-dark">
                                <strong >DETALLE ORDEN DE PRODUCCIÓN</strong>
                                <a href="orden.produ.index.php" class="btn btn-primary pull-right" rel="tooltip" title="Atras">
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
                                    $ordenes = consultas::get_datos("select * from v_orden_produ  where cod_orden=" . $_REQUEST['vcod_orden']);
                                    if (!empty($ordenes)) { ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-condensed">
                                                <thead>
                                                    <tr>
                                                    <th>#</th>
                                                        <th>Nro Presupuesto</th>
                                                        <th>Cliente</th>
                                                        <th>Fecha Inicio</th>
                                                        <th>Fecah Fin</th>
                                                        <th>Estado</th>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($ordenes as $orden) { ?>
                                                        <tr>
                                                        <td data-title="#"><?php echo $orden['cod_orden'];?></td>
                                                        <td data-title="Nro Presupuesto"><?php echo $orden['cod_preprod'];?></td>
                                                        <td data-title="Cliente  "><?php echo $orden['clientes'];?></td>
                                                        <td data-title="Fecha"><?php echo $orden['ord_prod_fecha'];?></td>
                                                        <td data-title="Validez"><?php echo $orden['orden_prod_feha_fin'];?></td>
                                                        <td data-title="Estado"><?php echo $orden['orden_prod_estado'];?></td>
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
                                    <strong>Detalle Items del Presupuesto N°<?php echo $ordenes[0]['cod_orden']; ?></strong>
                                </div>
                                <div class="panel-body">
                                    <?php
                                    $presudet = consultas::get_datos("select * from v_detalle_preprod  where cod_produ not in (select cod_produ from v_detalle_orden where cod_orden = " . $ordenes[0]['cod_orden'] . ") and cod_preprod=" . $ordenes[0]['cod_preprod']);
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
                                                        <td><?php echo $pdet['cod_preprod']; ?></td>
                                                        <td>PRODUCTO: <?php echo $pdet['produ_descri']; ?></td>
                                                        <td><?php echo $pdet['preprod_cantidad']; ?></td>
                                                        <td><?php echo number_format($pdet['preprod_precio'], 0, ",", "."); ?></td>
                                                        <td><?php echo number_format($pdet['subtotal'], 0, ",", "."); ?></td>
                                                        <td class="text-center">
                                                            <a onclick="agregar(<?php echo $ordenes[0]['cod_orden']; ?>, <?php echo $pdet['cod_preprod']; ?>, <?php echo $pdet['cod_produ']; ?>)" class="btn btn-success btn-sm" data-title="Agregar" rel="tooltip" data-toggle="modal" data-target="#editar">
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
        <strong>Detalle de la Orden de Producción</strong>
    </div>
    <div class="panel-body">
        <?php
        $detalles = consultas::get_datos("select * from v_detalle_orden where cod_orden=" . $ordenes[0]['cod_orden']);
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
                            <td><?php echo $det['cod_produ']; ?></td>
                            <td><?php echo $det['nombre_equipo']; ?></td>
                            <td><?php echo $det['produ_descri']; ?></td>
                            <td><?php echo $det['orden_cant']; ?></td>
                            <td><?php echo number_format($det['orden_precio'], 0, ",", "."); ?></td>
                            <td><?php echo $det['tipo_descri']; ?></td>
                            <td><?php echo number_format($det['subtotal'], 0, ",", "."); ?></td>
                            <td class="text-center">
                                <?php if ($ordenes[0]['orden_prod_estado'] == 'REGISTRADO') { ?>
                                    <a onclick="editar(<?php echo $det['cod_orden']; ?>, <?php echo $det['cod_produ']; ?>)" class="btn btn-warning btn-sm" data-title="Editar" rel="tooltip" data-toggle="modal" data-target="#editar">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a onclick="borrar(<?php echo "'" . $det['cod_orden'] . "_" . $det['cod_produ'] . "_" . $det['produ_descri'] . "'"; ?>)" class="btn btn-danger btn-sm" data-title="Quitar" rel="tooltip" data-toggle="modal" data-target="#borrar">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                <?php } ?>
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
                    $('#si').attr('href', 'orden.produ_dcontrol.php?vcod_orden=' + dat[0] + '&vcod_produ=' + dat[1] + '&accion=3');
                    $("#confirmacion").html('<span class="glyphicon glyphicon-warning-sign"></span> \\n\\ Desea quitar el articulo <strong>' + dat[2] + '</strong> ?');
                }

                function precio() {
                var dat = $('#producto').val().split("_");
                $('#vprecio').val(dat[7]);
               
                }
                


                function editar(com, art) {
                    $.ajax({
                        type: "GET",
                        url: "/tdp/orden_dedit.php?vcod_orden=" + com + "&vcod_produ=" + art,
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
                        url: "/tdp/orden.produ_dadd.php?vcod_orden=" + com + "&vcod_preprod=" + pr + "&vcod_produ=" + art,
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
                    $('#sic').attr('href', 'orden.produ_dcontrol.php?vcod_orden=' + dat[0] + '&accion=2');
                    $("#confirmacionc").html('<span class="glyphicon glyphicon-info-sign"></span> \\n\\ Desea confirmar la Compra N° <strong>' + dat[0] + '</strong> del proveedor <strong>' + dat[1] + '</strong> de fecha <strong>' + dat[2] + '</strong>')
                }
            </script>
                    
    </body>
</html>

    </body>
</html>
