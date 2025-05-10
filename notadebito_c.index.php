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
    require 'menu/css_lte.ctp'; // ARCHIVOS CSS 
    ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php require 'menu/header_lte.ctp'; ?> <!-- CABECERA PRINCIPAL -->
        <?php require 'menu/toolbar_lte.ctp'; ?> <!-- MENU PRINCIPAL -->
        
        <div class="content-wrapper">
            <section class="content">
                <div class="row">
                    <div class="col-lg-12 col-xs-12 col-md-12">
                        <?php if (!empty($_SESSION['mensaje'])) { ?>
                            <div class="alert alert-danger" role="alert" id="mensaje">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                <?php echo $_SESSION['mensaje']; $_SESSION['mensaje']=''; ?>
                            </div>
                        <?php } ?>
                        
                        <h3 class="page-header text-center">
                            <strong>NOTA CRÉDITO/DÉBITO</strong>
                            <a href="/tdp/MANUAL DE USUARIO tdp.pdf" target="print">
                                <span class="glyphicon glyphicon-question-sign"></span>
                            </a>
                            <a href="notacredito_c.anadir.php" class="btn btn-primary pull-right" data-title="Agregar" rel="tooltip" data-placement="left">
                                <i class="fa fa-plus"></i> AGREGAR
                            </a>
                        </h3>
                        
                        <div class="box-body no-padding">
                            <form method="post" accept-charset="utf-8" class="form-horizontal">
                                <div class="form-group">
                                    <div class="input-group custom-search-form">
                                        <input type="search" name="buscar" class="form-control" placeholder="Ingrese valor a buscar..." autofocus="">
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-primary btn-flat" data-title="Buscar" rel="tooltip">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <div class="panel panel-success">
                            <div class="panel-heading">Datos</div>
                            <div class="panel-body">
                                <?php
                                $creditos = consultas::get_datos("SELECT * FROM v_notacreditocompra ORDER BY cod_nota_comp ASC");
                                if (!empty($creditos)) { ?>
                                    <div class="table-responsive">
                                        <table id="example1" width="100%" class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">USUARIO</th>
                                                    <th class="text-center">NRO. FACTURA</th>
                                                    <th class="text-center">PROVEEDOR</th>
                                                    <th class="text-center">NRO.CREDITO</th>
                                                    <th class="text-center">FECHA</th>
                                                    <th class="text-center">MOTIVO</th>
                                                    <th class="text-center">MOT. DESCRIP</th>
                                                    <th class="text-center">DESCUENTO</th>
                                                    <th class="text-center">TOTAL</th>
                                                    <th class="text-center">ESTADO</th>
                                                    <th class="text-center">ACCIONES</th>
                                                </tr>
                                            </thead>
                                            <tbody class="buscar">
                                                <?php foreach ($creditos as $credito) { ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $credito['cod_nota_comp']; ?></td>
                                                        <td class="text-center"><?php echo $credito['emp_nombre']; ?></td>
                                                        <td class="text-center"><?php echo $credito['com_cod'] . "-" . $credito['nro_com']; ?></td>
                                                        <td class="text-center"><?php echo $credito['prv_razonsocial']; ?></td>
                                                        <td class="text-center"><?php echo $credito['nro_nota_cred']; ?></td>
                                                        <td class="text-center"><?php echo $credito['nota_cred_fecha']; ?></td>
                                                        <td class="text-center"><?php echo $credito['cred_moti']; ?></td>
                                                        <td class="text-center"><?php echo $credito['cred_descrip']; ?></td>
                                                        <td class="text-center"><?php echo $credito['cred_descuento']; ?></td>
                                                        <td class="text-center"><?php echo number_format($credito['credi_total'], 0, ',', '.'); ?></td>
                                                        <td class="text-center"><?php echo $credito['nota_cred_estado']; ?></td>
                                                        <td class="text-center">
                                                            <?php if ($credito['nota_cred_estado'] == 'ANULADO') { ?> 
                                                                <a href="notcredito_detalle_1.php?vdetcred=<?php echo $credito['cod_nota_comp']; ?>&vcompr=<?php echo $credito['com_cod']; ?>" class="btn btn-primary btn-sm" data-title="Detalles" rel="tooltip" data-placement="left">
                                                                    <i class="fa fa-list"></i>
                                                                </a>
                                                            <?php } else { ?>
                                                                <a href="notcredito_detalle.php?vdetcred=<?php echo $credito['cod_nota_comp']; ?>&vcompr=<?php echo $credito['com_cod']; ?>" class="btn btn-sm btn-primary" rel="tooltip" data-title="Detalles">
                                                                    <span class="fa fa-list"></span>
                                                                </a>
                                                            <?php } ?>
                                                            <a href="imprimir_notacredito.php?vcod=<?php echo $credito['cod_nota_comp']; ?>" class="btn btn-default btn-sm" data-title="Imprimir" rel="tooltip" data-placement="left" target="print">
                                                                <i class="fa fa-print"></i>
                                                            </a>
                                                            <?php if ($credito['nota_cred_estado'] == 'ACTIVO') { ?>  
                                                                <a onclick="anular('<?php echo $credito['cod_nota_comp'] . "_" . $credito['nota_cred_estado']; ?>')" class="btn btn-danger btn-sm" data-title="Anular" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#anular">
                                                                    <i class="fa fa-remove"></i>
                                                                </a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php } else { ?>
                                    <div class="alert alert-info alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <strong>No se encontraron registros....!</strong>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php require 'menu/footer_lte.ctp'; ?> <!-- ARCHIVOS JS -->

        <!-- Modal -->
        <div class="modal fade" id="delete" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title custom_align" id="Heading">Atención!!!</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning" id="confirmacion"></div>
                    </div>
                    <div class="modal-footer">
                        <a id="si" role="button" class="btn btn-primary"><span class="glyphicon glyphicon-ok-sign"></span> Si</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            proveedor();
            calsubtotall();
            costo();
        });

        function anular(datos) {
            var dat = datos.split("_");
            $('#si').attr('href', 'nota_credito_control.php?vcred=' + dat[0] + '&vestado=ANULADO&pagina=nota_credito.php');
            $('#confirmacion').html('<span class="glyphicon glyphicon-warning-sign"></span> Desea anular la nota de credito');
        }
        // Funciones adicionales (validarvigencia, solo_timbrado, etc.) según sea necesario.
    </script>
</body>
</html>
