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
    require 'menu/css_lte.ctp'; 
    ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php require 'menu/header_lte.ctp'; ?>
        <?php require 'menu/toolbar_lte.ctp'; ?>
        
        <div class="content-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?php if (!empty($_SESSION['mensaje'])) { ?>
                            <div class="alert alert-danger" role="alert" id="mensaje">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                <?php echo $_SESSION['mensaje'];
                                $_SESSION['mensaje'] = ''; ?>
                            </div>
                        <?php } ?>
                        
                        <h3 class="page-header text-center alert-info">
                            <strong>DETALLE NOTA REMISIÓN</strong>
                            <a href="nota_remision.index.php" class="btn btn-primary pull-right" rel="tooltip" title="Atras">
                                <i class="glyphicon glyphicon-arrow-left"></i>
                            </a>
                        </h3>

                        <!-- Panel Datos Cabecera de la Orden -->
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <strong>Datos Cabecera de la Nota Remisión</strong>
                            </div>
                            
                            <div class="panel-body">
                                <?php $remision = consultas::get_datos("select * from v_notaremicompra where cod_nota_remision=" . $_REQUEST['vcod_nota']);
                                if (!empty($remision)) { ?>
                                    <a onclick="confirmar('<?php echo $remision[0]['cod_nota_remision'] . "_" . $remision[0]['proveedor'] . "_" . $remision[0]['remi_fecha']; ?>')"
                                       class="btn btn-success btn-sm pull-right" data-title="Confirmar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#confirmar">
                                        <i class="fa fa-check"></i>
                                    </a>
                                <?php } ?>

                                <!-- INICIO CABECERA -->
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-xs-12">
                                        <?php if (!empty($remision)) { ?>
                                            <div class="table-responsive">
                                                <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Empleado</th>
                                                            <th>Nro. Factura</th>
                                                            <th>Nro. Remision</th>
                                                            <th>Proveedor</th>
                                                            <th>Fecha</th>
                                                            <th>Motivo</th>
                                                            <th>Conductor</th>
                                                            <th>Fecha Salida</th>
                                                            <th>Fecha Llegada</th>
                                                            <th>Estado</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($remision as $remi) { ?>
                                                            <tr>
                                                                <td><?php echo $remi['cod_nota_remision']; ?></td>
                                                                <td class="text-center"><?php echo $remi['empleado']; ?></td>
                                                                <td><?php echo $remi['com_cod'] . "-" . $remi['nro_com']; ?></td>
                                                                <td><?php echo $remi['remi_nro']; ?></td>
                                                                <td><?php echo $remi['proveedor']; ?></td>
                                                                <td><?php echo $remi['remi_fecha']; ?></td>
                                                                <td><?php echo $remi['remi_motivo']; ?></td>
                                                                <td><?php echo $remi['remi_conductor']; ?></td>
                                                                <td><?php echo $remi['remi_fecha_salida']; ?></td>
                                                                <td><?php echo $remi['remi_fecha_llegada']; ?></td>
                                                                <td><?php echo $remi['remi_estado']; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php } else { ?>
                                            <div class="alert alert-info flat">
                                                <span class="glyphicon glyphicon-info-sign"></span> No se encontraron registros.
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!-- FIN CABECERA -->
                            </div>
                        </div>

                        <!-- INICIO DETALLE COMPRA -->
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <strong>Detalle Items de la Compra N°<?php echo $remision[0]['com_cod']; ?></strong>
                            </div>
                            <div class="panel-body">
                                <?php $remidet = consultas::get_datos("select * from v_detalle_compras where com_cod =" . $remision[0]['com_cod'] . " and art_cod not in(select art_cod from det_remicom where cod_nota_remision=" . $remision[0]['cod_nota_remision'] . ")");
                                if (!empty($remidet)) { ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-condensed table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th class="text-center">Descripción</th>
                                                    <th>Cantidad</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($remidet as $rdet) { ?>
                                                    <tr>
                                                        <td><?php echo $rdet['art_cod']; ?></td>
                                                        <td class="text-center"><?php echo $rdet['art_descri'] . " " . $rdet['mar_descri']; ?></td>
                                                        <td><?php echo $rdet['com_cant']; ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- FIN DETALLE COMPRA -->
                    </div>
                </div>
            </div>
        </div>

        <?php require 'menu/footer_lte.ctp'; ?>

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
        <!-- FIN MODAL CONFIRMAR -->

        <?php require 'menu/js_lte.ctp'; ?>
        <script>
        $("#mensaje").delay(4000).slideUp(200,function(){
           $(this).alert('close'); 
        });
        </script>
        <script>
        
        function precio(){
            var dat = $('#articulo').val().split('_');
            $('#vprecio').val(dat[1]);
        };
        

        // Función en JS
        function confirmar(datos){
            var dat = datos.split('_');
            $('#sic').attr('href','nota_remision.control.php?vcod_nota='+dat[0]+'&accion=3  ');
            $("#confirmacionc").html('<span class="glyphicon glyphicon-info-sign"></span> \n\
            Desea confirmar la Nota Remisión N° <strong>'+dat[0]+'</strong> del proveedor <strong>'+dat[1]+'</strong> de fecha <strong>'+dat[2]+'</strong>')
        } 
                         
                 
        </script>        
    </body>
</html>

