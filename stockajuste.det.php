<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="/lp3/favicon.ico">
    <title>TDP</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php 
        session_start();/*Reanudar sesión*/
        require 'menu/css_lte.ctp'; //ARCHIVOS CSS
    ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php require 'menu/header_lte.ctp'; //CABECERA PRINCIPAL?>
        <?php require 'menu/toolbar_lte.ctp';//MENU PRINCIPAL?>
        <div class="content-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-lg-12 col-xs-12 col-md-12">
                        <?php if (!empty($_SESSION['mensaje'])) { ?>
                            <div class="alert alert-danger" role="alert" id="mensaje">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                <?php echo $_SESSION['mensaje'];
                                $_SESSION['mensaje']='';?>
                            </div>
                        <?php } ?>
                        <div class="box box-primary">
                            <div class="box-header">
                                <i class="fa fa-money"></i><i class="fa fa-list"></i>
                                <h3 class="box-title">Agregar Detalle Ajustes</h3>
                                <div class="box-tools">
                                    <?php
                                    $estokes = consultas::get_datos("SELECT * FROM v_ajuste WHERE ajuste_cod=" . $_REQUEST['vajuste_cod']);
                                    if ($estokes[0]['ajuste_cod'] > 0) {
                                    ?>
                                        <!-- Botón de confirmar -->
                                    <?php } ?>
                                    <a href="stockajuste.index.php" class="btn btn-primary btn-sm" data-title="Volver" rel="tooltip" data-placement="left">
                                        <i class="fa fa-arrow-left"></i> VOLVER</a>
                                </div>
                            </div>
                            <div class="box-body no-padding">
                                <!-- INICIO CABECERA -->
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-xs-12">
                                        <?php
                                        if (!empty($estokes)) { ?>
                                            <div class="table-responsive">
                                                <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                        <th>#</th>
                                                        <th>Fecha</th>
                                                        <th>Motivo</th>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($estokes as $estok) { ?>
                                                            <tr>
                                                                <td data-title="#"><?php echo $estok['ajuste_cod']; ?></td>
                                                                <td data-title="Fecha"><?php echo $estok['ajuste_fecha']; ?></td>
                                                                <td data-title="Cliente"><?php echo $estok['ajuste_motivo']; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php  } else { ?>
                                            <div class="alert alert-info flat">
                                                <span class="glyphicon glyphicon-info-sign"></span>
                                                No se encontraron ajustes..
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!-- INICIO CABECERA -->
                                <!-- INICIO DETALLE -->
                                <div class="box-header">
                                    <i class="fa fa-plus"></i><i class="fa fa-list"></i>
                                    <h3 class="box-title">Detalle Items</h3>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-xs-12">
                                        <?php
                                        $detalles = consultas::get_datos("SELECT * FROM v_detalle_ajuste WHERE ajuste_cod =" . $estokes[0]['ajuste_cod']);
                                        if (!empty($detalles)) { ?>
                                            <div class="table-responsive">
                                                <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                        <th>#</th>
                                                        <th>Articulo</th>
                                                        <th>Motivo</th>
                                                        <th>Cant.</th>
                                                        <th class="text-center">Acciones</th>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($detalles as $det) { ?>
                                                            <tr>
                                                                <td data-title="#"><?php echo $det['art_cod']; ?></td>
                                                                <td data-title="Articulo"><?php echo $det['art_descri'] . " " . $det['mar_descri']; ?></td>
                                                                <td data-title="Motivo"><?php echo $det['ajuste_motivo']; ?></td>
                                                                <td data-title="Cant."><?php echo $det['cantidad']; ?></td>
                                                                <td class="text-center">
                                                                    <a onclick="editar(<?php echo $det['ajuste_cod']; ?>,<?php echo $det['art_cod']; ?>)"
                                                                       class="btn btn-warning btn-sm" data-title="Editar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#editar">
                                                                        <i class="fa fa-edit"></i></a>
                                                                    <a onclick="borrar(<?php echo "'" . $det['ajuste_cod'] . "_" . $det['art_cod']
                                                                        . "_" . $det['art_descri'] . "'"; ?>)" class="btn btn-danger btn-sm" role="button" data-title="Borrar" rel="tooltip"
                                                                       data-placement="top" data-toggle="modal" data-target="#borrar"><i class="fa fa-trash"></i>  
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php  } else { ?>
                                            <div class="alert alert-info flat">
                                                <span class="glyphicon glyphicon-info-sign"></span>
                                                El ajuste aun no tiene detalles cargados...
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!-- FIN DETALLE -->
                                <!-- INICIO AGREGAR DETALLE -->
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                        <form action="stockajuste_dcontrol.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                            <div class="box-body">
                                                <input type="hidden" name="accion" value="1" />
                                                <input type="hidden" name="vajuste_cod" value="<?php echo $estokes[0]['ajuste_cod'] ?>" />
                                                <div class="form-group">
                                                    <label class="control-label col-lg-2 col-sm-3 col-md-2 col-xs-3">Articulo:</label>
                                                    <div class="col-lg-4 col-sm-4 col-md-4 col-xs-6">
                                                        <?php $articulos = consultas::get_datos("SELECT * FROM v_articulo ORDER BY art_cod"); ?>
                                                        <select class="form-control select2" name="vart_cod" required="" id="articulo" onchange="precio()">
                                                            <option value="">Seleccione un articulo</option>
                                                            <?php foreach ($articulos as $articulo) { ?>
                                                                <option value="<?php echo $articulo['art_cod'] . "_" . $articulo['art_preciov']; ?>"><?php echo $articulo['art_descri'] . " " . $articulo['mar_descri']; ?></option>
                                                            <?php }  ?>                                                
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-lg-2 col-sm-3 col-md-2 col-xs-2">Cantidad:</label>
                                                    <div class="col-lg-4 col-sm-4 col-md-4 col-xs-6">
                                                        <input type="number" name="vcantidad" class="form-control" min="1" value="1" required="" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="box-footer">
                                                <button type="submit" class="btn btn-primary pull-right">
                                                    <span class="fa fa-plus"> Agregar</span>
                                                </button>
                                            </div>
                                        </form> 
                                    </div>
                                </div>
                                <!-- FIN AGREGAR -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require 'menu/footer_lte.ctp'; //ARCHIVOS JS?>
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
                        <a id="sic" role="buttom" class="btn btn-primary">
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
        <!-- INICIA MODAL ELIMINAR-->
        <div class="modal fade" id="borrar" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">x</button>
                        <h4 class="data-title custom_align" id="Heading">Atencion!!!</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning" id="confirmacion"></div>
                    </div>
                    <div class="modal-footer">
                        <a id="si" role="button" class="btn btn-primary">
                            <span class="glyphicon glyphicon-ok-sign"></span> Si</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <span class="glyphicon glyphicon-remove"></span> No</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIN MODAL ELIMINAR-->
        <!-- INICIA MODAL EDITAR-->
        <div class="modal" id="editar" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content" id="detalles">
                </div>
            </div>
        </div>
        <!-- FIN MODAL EDITAR-->
    </div>
    <?php require 'menu/js_lte.ctp'; //ARCHIVOS JS?>
    <script>
        $("#mensaje").delay(4000).slideUp(200, function() {
            $(this).alert('close');
        });
        $('.modal').on('shown.bs.modal', function() {
            $(this).find('input:text:visible:first').focus();
        });
    </script>
    <script>
        function borrar(datos) {
            var dat = datos.split('_');
            $('#si').attr('href', 'stockajuste_dcontrol.php?vajuste_cod=' + dat[0] + '&vart_cod=' + dat[2] + '&accion=3');
            $('#confirmacion').html('<span class="glyphicon glyphicon-warning-sign"></span> \n\
            Desea quitar el articulo <i><strong>' + dat[3] + '</strong>');
        };

        function precio() {
            var dat = $('#articulo').val().split("_");
            $('#vprecio').val(dat[1]);
        }

        function editar(ven, art) {
            $.ajax({
                type: "GET",
                url: "/tdp/stockajuste_dedit.php?vajuste_cod=" + ven + "&vart_cod=" + art,
                cache: false,
                beforeSend: function() {
                    $('#detalles').html('<img src="img/loader.gif" /><strong>Cargando...</strong>');
                },
                success: function(data) {
                    $('#detalles').html(data);
                }
            })
        };
    </script>
</body>
</html>


