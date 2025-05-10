<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" href="img/mueble.png"/>
        <title>Todo Muebles - VENTAS</title>
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
            <div id="page-wrapper">
                <div class="row">
                    <!--impresion del titulo de la pagina-->
                    <div class="col-lg-12">
                        <h2 class="page-header text-center">CUENTAS A COBRAR VENTAS
                                                 
                        </h2>
                    </div>     
                    <!--Buscador-->
                    <div class="col-lg-12">
                        <div class="panel-heading">
                            <div class="input-group custom-search-form">
                                <input id="filtrar" type="text" class="form-control" placeholder="Buscar...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" rel="tooltip" title="Buscar">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>                      
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                Datos
                            </div>
                            <?php
                            $ctas_cobrar = consultas::get_datos("select * from v_ctas_cobrar_2 
                                         order by cta_id asc ");
                            if (!empty($ctas_cobrar)) {
                                ?>                         
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div>
                                        <table id="example1" width="100%" class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Nro. Cuenta</th>                                        
                                                    <th class="text-center">Venta</th>
                                                    <th class="text-center">Cliente</th>
                                                    <th class="text-center">Fecha Venta</th>
                                                    <th class="text-center">Condicion Venta</th>
                                                    <th class="text-center">Cta. Vence</th>
                                                    <th class="text-center">Importe</th>
                                                    <th class="text-center">Nro. Cuota</th>
                                                    <th class="text-center">Nro. Factura</th>
                                                    <th class="text-center">Estado</th>
<!--                                                    <th class="text-center">Acciones</th>-->
                                                </tr>
                                            </thead>
                                            <tbody class="buscar">
                                                <?php foreach ($ctas_cobrar as $cta_cobrar) { ?> 
                                                    <tr>
                                                        <td class="text-center"><?php echo $cta_cobrar['cta_id']; ?></td>
                                                        <td class="text-center"><?php echo $cta_cobrar['cod_factura']; ?></td>
                                                        <td class="text-center"><?php echo $cta_cobrar['cliente']; ?></td>
                                                        <td class="text-center"><?php echo $cta_cobrar['fecha_ven']; ?></td>
                                                        <td class="text-center"><?php echo $cta_cobrar['ven_condicion']; ?></td>
                                                        <td class="text-center"><?php echo $cta_cobrar['fecha_cta']; ?></td>
                                                        <td class="text-center"><?php echo number_format($cta_cobrar['cta_importe'], 0, ',', '.'); ?></td>
                                                        <td class="text-center"><?php echo $cta_cobrar['cta_cuo_nro']; ?></td>
                                                        <td class="text-center"><?php echo $cta_cobrar['nro_factura']; ?></td>
                                                        <td class="text-center"><?php echo $cta_cobrar['cta_estado']; ?></td>
                                                       
                                                    </tr>
                                             
                                                <?php } ?>
                                            </tbody>
                                        </table>                         
                                    </div><!--
                                <?php } else { ?>
                                    <div class="alert alert-info alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <strong>No se encontraron registros....!</strong>
                                    </div>
                                <?php } ?>  
                                <!-- /.panel-body -->
                            </div>
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
            <!--borrar-->
            <div class="modal fade" id="delete" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title custom_align" id="Heading">Atenci&oacute;n!!!</h4>
                        </div>
                        <div class="modal-body">

                            <div class="alert alert-warning" id="confirmacion"></div>

                        </div>
                        <div class="modal-footer">
                            <a id="si" role="button" class="btn btn-primary" ><span class="glyphicon glyphicon-ok-sign"></span> Si</a>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
                        </div>
                    </div>
                </div>
            </div> 
            <!--fin-->
        </div> 
        <!--archivos js-->  
        <?php require 'menu/js.ctp'; ?>


        <script>
            function editar(datos) {
                var dat = datos.split("_");
                $('#cod').val(dat[0]);
                $('#descri').val(dat[1]);

            }

            function cancelar(datos) {
                var dat = datos.split("_");
                $('#si').attr('href'
                , 'ctascobrar_control.php?vcodcta=' + dat[0] + 
                        '&vvencod=null' +
                        '&vvto=1900-01-01'+
                        '&vimporte=null'+
                        '&vcuo_nro=null'+
                        '&vestado=CANCELADO'+
                        '&accion=1'+
                        '&pagina=ctascobrar_index.php');
                $('#confirmacion').html('<span class="glyphicon glyphicon-warning-sign"></span>\n\
            Desea Cancelar la Cuenta <i><strong>' + dat[0] + '</strong></i> Pendiente a Cobrar de la Venta Nro: <i><strong>' + dat[1] + '</strong></i>?');
            }
        </script>


    </body>
</html>







