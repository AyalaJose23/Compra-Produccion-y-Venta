<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" href="img/mueble.png"/>
        <title>Todo Muebles - CUENTAS A PAGAR</title>
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
                                    <h3 class="page-header text-center"><strong>CUENTAS A PAGAR</strong>
                                    <a href="/tdp/MANUAL DE USUARIO tdp.pdf" target="print">
                                    <span class="glyphicon glyphicon-question-sign"></span>
                                </a>
                                            <a href="ventas_anadir.php" id="btnAbrir" class="btn btn-success  pull-right" value="Abrir" rel="tooltip" data-placement="left" onclick="ven();">
                                                <i class="fa fa-plus"></i> AÑADIR
                                            </a>
                                        
                                </div>
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
                                        </div>
                                    </div>
                                </div>
                                            
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-success">
                                            <div class="panel-heading">
                                                Datos
                                            </div>                     
                                                    <!-- /.panel-heading -->
                                        <div class="panel-body">
                            <?php
                            $ctas_pagar = consultas::get_datos("select * from v_ctas_pagar 
                                         order by nro_cuota asc ");
                            if (!empty($ctas_pagar)) {
                                ?>                         
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div>
                                        <table id="example1" width="100%" class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Nro. Cuenta</th>                                        
                                                    <th class="text-center">Compra</th>
                                                    <th class="text-center">Fecha Compra</th>
                                                    <th class="text-center">Condicion Comp.</th>
                                                    <th class="text-center">Cta. Vence</th>
                                                    <th class="text-center">Importe</th>
                                                    <th class="text-center">Nro. Cuota</th>
                                                    <th class="text-center">Estado</th>
<!--                                                    <th class="text-center">Acciones</th>-->
                                                </tr>
                                            </thead>
                                            <tbody class="buscar">
                                                <?php foreach ($ctas_pagar as $cta_pagar) { ?> 
                                                    <tr>
                                                        <td class="text-center"><?php echo $cta_pagar['nro_cuota']; ?></td>
                                                        <td class="text-center"><?php echo $cta_pagar['com_cod']; ?></td>
                                                        <td class="text-center"><?php echo $cta_pagar['fecha_comp']; ?></td>
                                                        <td class="text-center"><?php echo $cta_pagar['tipo_compra']; ?></td>
                                                        <td class="text-center"><?php echo $cta_pagar['fecha_cta']; ?></td>
                                                        <td class="text-center"><?php echo number_format($cta_pagar['cta_importe'], 0, ',', '.'); ?></td>
                                                        <td class="text-center"><?php echo $cta_pagar['nro_cuota']; ?></td>
                                                        <td class="text-center"><?php echo $cta_pagar['cta_estado']; ?></td>
                                                     
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

            function pagar(datos) {
                var dat = datos.split("_");
                $('#si').attr('href'
                , 'ctaspagar_control.php?vcodctapag=' + dat[0] + 
                        '&vcomcod=null' +
                        '&vvto=1900-01-01'+
                        '&vimporte=null'+
                        '&vcuo_nro=null'+
                        '&vestado=PAGADO'+
                        '&accion=1'+
                        '&pagina=ctaspagar_index.php');
                $('#confirmacion').html('<span class="glyphicon glyphicon-warning-sign"></span>\n\
            Desea Pagar la Cuenta <i><strong>' + dat[0] + '</strong></i> Pendiente de la Compra Nro: <i><strong>' + dat[1] + '</strong></i>?');
            }
        </script>


    </body>
</html>