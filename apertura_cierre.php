<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" href="img/mueble.png"/>
        <title>Todo Muebles - Apertura y Cierre</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <?php 
        session_start(); /* Reanudar sesión */
        require 'menu/css_lte.ctp'; /* Archivos CSS */ 
        ?>
    </head>
    <body class="hold-transition skin-green sidebar-mini">
        <div class="wrapper">
            <?php require 'menu/header_lte.ctp'; /* CABECERA PRINCIPAL */ ?>
            <?php require 'menu/toolbar_lte.ctp'; /* MENU PRINCIPAL */ ?>

            <div class="content-wrapper">
                <div class="content">
                    <div class="row">
                        <div class="col-lg-12 col-xs-12 col-md-12">
                            <?php if (!empty($_SESSION['mensaje'])) { ?>
                            <div class="alert alert-danger" role="alert" id="mensaje">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                <?php echo $_SESSION['mensaje']; $_SESSION['mensaje']=''; ?>
                            </div>
                            <?php } ?>

                            <div class="col-lg-12">
                        <h3 class="page-header text-center"><strong>APERTURA Y CIERRES</strong>
                        <a href="/tdp/MANUAL DE USUARIO tdp.pdf" target="print">
                                    <span class="glyphicon glyphicon-question-sign"></span>
                                </a>
                                        <a href="apertura_cierre.anadir.php" id="btnAbrir" class="btn btn-success pull-right" value="Abrir" rel="tooltip" data-placement="left" onclick="apertura();">
                                            <i class="fa fa-money "></i>  ABRIR
                                        </a>
                                    </div>
                                </div>

                                <div class="box-body no-padding">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                            <form method="post" accept-charset="utf-8" class="form-horizontal">
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="input-group custom-search-form">
                                                                <input type="search" name="buscar" class="form-control" placeholder="Ingrese valor a buscar..." autofocus="" />
                                                                <span class="input-group-btn">
                                                                    <button type="submit" class="btn btn-primary btn-flat" data-title="Buscar" rel="tooltip">
                                                                        <i class="fa fa-search"></i>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                            <?php
                                            $aperturas = consultas::get_datos("SELECT * FROM v_aperturas WHERE (id_apercierre::varchar || fecha_apertura::varchar) ILIKE '%" . (isset($_REQUEST['buscar']) ? $_REQUEST['buscar'] : "") . "%' ORDER BY id_apercierre DESC");
                                            if (!empty($aperturas)) {
                                            ?>
                                            <div class="table-responsive">
                                                <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                    <th class="success  text-center">#</th>
                                                    <th class="success">Fecha Aper.</th>
                                                    <th class="success">Fecha Cierre</th>
                                                    <th class="success text-right">Monto Aper.</th>
                                                    <th class="hidden">IdCaja</th>
                                                    <th class="success">Caja</th>
                                                    <th class="success">Siguiente Factura</th>
                                                    <th class="success text-right">Efectivo</th>
                                                    <th class="success text-right">Cheque</th>
                                                    <th class="success text-right">Tarjeta</th>
                                                    <th class="success text-right">Total Cierre</th>
                                                    <th class="success text-right">Acciones</th>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($aperturas as $apertura) { ?>
                                                        <tr onclick="seleccion($(this));">
                                                            <td class="text-center">
                                                                <a style="color:blue;" target="blank" href="arqueo.php?id=<?php echo $apertura['id_apercierre']; ?>">
                                                                    <?php echo $apertura['id_apercierre']; ?>
                                                                </a>
                                                            </td>
                                                            <td><?php echo $apertura['fecha_aperformat']; ?></td>
                                                            <td><?php echo $apertura['fecha_cierreformat']; ?></td>
                                                            <td class="text-right"><?php echo number_format($apertura['aper_monto'], 0, ',', '.'); ?></td>
                                                            <td class="hidden"><?php echo $apertura['id_caja']; ?></td>
                                                            <td><?php echo $apertura['caja_descripcion']; ?></td>
                                                            <td><?php echo $apertura['siguiente_factura']; ?></td>
                                                            <td class="text-right"><?php echo number_format($apertura['monto_efectivo'], 0, ',', '.'); ?></td>
                                                            <td class="text-right"><?php echo number_format($apertura['monto_cheque'], 0, ',', '.'); ?></td>
                                                            <td class="text-right"><?php echo number_format($apertura['monto_tarjeta'], 0, ',', '.'); ?></td>
                                                            <td class="text-right"><?php echo number_format($apertura['monto_efectivo'] + $apertura['monto_cheque'] + $apertura['monto_tarjeta'], 0, ',', '.'); ?></td>
                                                            <td data-title="Acciones" class="text-right">
                                                                
                                                                <?php 
                                                                if($apertura['estado_aper'] == 'ABIERTA'){ ?>

                                                                    <a onclick="cerrar('<?php echo $apertura['id_apercierre']; ?>_<?php echo $apertura['aper_monto']; ?>_<?php echo $apertura['id_caja']; ?>')" 
                                                                    class="btn btn-danger btn-sm" data-title="Cerrar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#cierreModal">
                                                                    CERRAR CAJA
                                                                    </a>
                                                                <?php }
                                                                if($apertura['estado_aper']=='CERRADA'){?>
                                                                     <a class="btn btn-default btn-sm" data-title="CERRADO" rel="tooltip" data-placement="left"  disabled="">
                                                                    CAJA CERRADA</a>   

                                                                <?php }?>
                                                                
                                                                    <a href="compras.print.php?vcom_cod=<?php echo $compra['com_cod'];?>" class="btn btn-default btn-sm" data-title="Imprimir" rel="tooltip" data-placement="left" target="print">
                                                                        <i class="fa fa-print"></i>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php } else { ?>
                                            <div class="alert alert-info flat">
                                                <span class="glyphicon glyphicon-info-sign"></span>
                                                No se han registrado aperturas ni cierres.
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php require 'menu/footer_lte.ctp'; /* ARCHIVOS JS */ ?>
            <!-- MODAL cierre-->
            
                <div class="modal" id="cierreModal" role="dialog">
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
                <!-- FIN MODAL cierre-->
                 

                </div>
                <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->

            <script>
                $("#mensaje").delay(4000).slideUp(200, function() {
                    $(this).alert('close');
                });
            </script>


            <script>
                
                function cerrar(datos){
                    var dat = datos.split('_');
                    // Verifica que 'id_caja' (dat[2]) esté presente
                    if (dat.length === 3) {
                        // Añadimos 'vid_caja' al href de confirmación
                        $('#si').attr('href', 'apertura_cierre_control.php?vid_apercierre=' + dat[0] + '&vcierre_monto=' + dat[1] + '&id_caja=' + dat[2] + '&accion=2');
                        $("#confirmacion").html('<span class="glyphicon glyphicon-warning-sign"></span> \n\
                        Desea cerrar la Apertura n° <strong>' + dat[0] + '</strong>? Con Monto de: <strong>' + dat[1] + ' Gs</strong>');
                    } else {
                        console.error('Faltan datos en la función cerrar.');
                    }
                }


            </script>


        

        </div>
    </body>
</html>
