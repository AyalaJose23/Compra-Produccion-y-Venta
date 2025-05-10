<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="img/mueble.png"/>
    <title>Todo Muebles</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <?php 
    session_start(); /* Reanudar sesión */
    require 'menu/css_lte.ctp'; ?><!-- ARCHIVOS CSS -->
</head>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">

    <?php require 'menu/header_lte.ctp'; ?><!-- CABECERA PRINCIPAL -->
    <?php require 'menu/toolbar_lte.ctp'; ?><!-- MENU PRINCIPAL -->
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
                    <div class="box box-success">
                        <div class="box-header">
                            <i class="fa fa-money"></i><i class="fa fa-list"></i>
                            <h3 class="box-title">Agregar Detalle de Ventas</h3>
                            <div class="box-tools">
                                <?php 
                                $ventas = consultas::get_datos("select * from v_ventas where id_venta=" . $_REQUEST['vid_venta']);
                                if (!empty($ventas) && isset($ventas[0]['ven_total']) && $ventas[0]['ven_total'] > 0) { ?>
                                    <a onclick="confirmar('<?php echo $ventas[0]['id_venta'] . "_" . $ventas[0]['cliente'] . "_" . $ventas[0]['ven_fecha']; ?>')"
                                       class="btn btn-success btn-sm" data-title="Confirmar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#confirmar">
                                        <i class="fa fa-check"></i>
                                    </a>
                                <?php } ?>
                                <a href="ventas_index.php" class="btn btn-success btn-sm" data-title="Volver" rel="tooltip" data-placement="left">
                                    <i class="fa fa-arrow-left"></i> VOLVER
                                </a>
                            </div>
                        </div>
                        <div class="box-body">

                            <!-- INICIO CABECERA -->
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12">
                                    <?php if (!empty($ventas)) { ?>
                                        <div class="table-responsive">
                                            <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Fecha</th>
                                                        <th>Cliente</th>
                                                        <th>Timbrado</th>
                                                        <th>Condición</th>
                                                        <th>Total</th>
                                                        <th>Estado</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($ventas as $ven) { ?>
                                                        <tr>
                                                            <td data-title="#"><?php echo $ven['id_venta']; ?></td>
                                                            <td data-title="Fecha"><?php echo $ven['ven_fecha']; ?></td>
                                                            <td data-title="Proveedor"><?php echo $ven['cliente']; ?></td>
                                                            <td data-title="Timbrado"><?php echo $ven['timb_cod']; ?></td>
                                                            <td data-title="Condicion"><?php echo $ven['ven_tipo']; ?></td>
                                                            <td data-title="Total"><?php echo number_format($ven['ven_total'], 0, ",", "."); ?></td>
                                                            <td data-title="Estado"><?php echo $ven['ven_estado']; ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php } else { ?>
                                        <div class="alert alert-info flat">
                                            <span class="glyphicon glyphicon-info-sign"></span>
                                            No se encontraron registros..
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <!-- FIN CABECERA -->

                            <!-- INICIO DETALLE presupuesto -->
                            <?php
                            if (!empty($ventas) && isset($ventas[0]['cod_preprod'])) {
                                $presudet = consultas::get_datos("select * from v_detalle_preprod where cod_produ not in(select cod_produ from v_detalle_ventas where id_venta = " . $ventas[0]['id_venta'] . ") and cod_preprod= " . $ventas[0]['cod_preprod']);
                                if (!empty($presudet)) { ?>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="box-header">
                                                <i class="fa fa-list"></i>
                                                <h3 class="box-title">Detalle Producto del Presupuesto N°<?php echo $ventas[0]['id_venta']; ?></h3>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-condensed table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Descripción</th>
                                                            <th>Cant.</th>
                                                            <?php if (isset($ven['ven_estado']) && $ven['ven_estado'] == 'PENDIENTE') { ?>
                                                                <th class="text-center">Acciones</th>
                                                            <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($presudet as $pres) { ?>
                                                        <tr>
                                                            <td data-title="#"><?php echo $pres['cod_produ'];?></td>
                                                            <td data-title="Descripción"><?php echo $pres['produ_descri'];?></td>
                                                            <td data-title="Cant."><?php echo $pres['preprod_cantidad'];?></td>
                                                            <td class="text-center"> 
                                                            <?php if ($ventas['ven_estado'] == 'PENDIENTE') { ?>   
                                                                <a onclick="agregar(<?php echo $presupuestos[0]['cod_preprod'];?>,
                                                                <?php echo $pres['ped_cod'];?>,
                                                                <?php echo $pres['cod_produ'];?>)" 
                                                                class="btn btn-success btn-sm" data-title="Agregar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#editar"> 
                                                                <i class="fa fa-plus"></i></a> </td>
                                                        </tr>  
                                                        <?php }?>
                                                        <?php }?>
                                                    </tbody>
                                                   
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                            <!-- FIN DETALLE PRESUPUESTO VENTA -->

                            <!-- INICIO DETALLE -->
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <?php 
                                    if (!empty($ventas)) {
                                        $detalles = consultas::get_datos("select * from v_detalle_ventas where id_venta =" . $ventas[0]['id_venta']);
                                        if (!empty($detalles)) { ?>
                                            <div class="box-header">
                                                <i class="fa fa-list"></i>
                                                <h3 class="box-title">Detalle Items</h3>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-condensed table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Descripción</th>
                                                            <th>Cant.</th>
                                                            <th>Precio</th>
                                                            <th>Impuesto</th>
                                                            <th>Subtotal</th>
                                                            <?php if (isset($ven['ven_estado']) && $ven['ven_estado'] == 'REGISTRADO') { ?>
                                                                <th class="text-center">Acciones</th>
                                                            <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($detalles as $det) { ?>
                                                            <tr>
                                                                <td data-title="#"><?php echo $det['cod_produ']; ?></td>
                                                                <td data-title="Descripción"><?php echo $det['produ_descri']; ?></td>
                                                                <td data-title="Cant."><?php echo $det['com_cant']; ?></td>
                                                                <td data-title="Precio"><?php echo number_format($det['com_precio'], 0, ",", "."); ?></td>
                                                                <td data-title="Impuesto"><?php echo $det['tipo_descri']; ?></td>
                                                                <td data-title="Subtotal"><?php echo number_format($det['subtotal'], 0, ",", "."); ?></td>
                                                                <td class="text-center">
                                                                    <?php if (isset($ven['ven_estado']) && $ven['ven_estado'] == 'REGISTRADO') { ?>
                                                                        <a onclick="eliminar(<?php echo $det['id_detalle']; ?>)" class="btn btn-danger btn-sm" data-title="Eliminar" rel="tooltip" data-placement="left">
                                                                            <i class="fa fa-trash"></i>
                                                                        </a>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php } else { ?>
                                            <div class="alert alert-info flat">
                                                <span class="glyphicon glyphicon-info-sign"></span>
                                                No hay detalles para esta venta.
                                            </div>
                                        <?php } 
                                    } ?>
                                </div>
                            </div>
                            <!-- FIN DETALLE -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require 'menu/footer_lte.ctp'; ?><!-- PIE DE PAGINA -->

<script>
    // Aquí puedes incluir cualquier script adicional que necesites
</script>

</body>
</html>
