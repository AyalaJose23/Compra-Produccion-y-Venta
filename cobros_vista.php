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

            <div class="content-wrapper">
                <div class="content">
                <div class="row">
                    <!--impresion del titulo de la pagina-->
                    <div class="col-lg-12">
                        <h3 class="page-header text-center alert-warning"> <strong>DATOS DE COBROS</strong>
                            <a href="cobros.php" 
                               class="btn btn-success btn-microsoft pull-right" 
                               rel='tooltip' title="Atras">
                                <i class="glyphicon glyphicon-arrow-left"></i>
                            </a> 

                        </h3>
                    </div>     
                    <!--Buscador-->

                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <strong>Datos Cabecera de Cobros</strong>
                            </div>
                            <?php
                            $cobros = consultas::get_datos("select * from v_cobro_recibo_imprimir where id_cobros=" .
                                            $_REQUEST ['vcod'] . " order by id_cobros asc ");
                            ?>                         
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table width="100%"
                                           class="table table-bordered">
                                        <thead>
                                            <tr class="panel-primary">
                                             <th class="text-center">#Cobro</th>
                                                    <th class="text-center">CAJERO</th>
                                                    <th class="text-center">FECHA COBRO</th> 
                                                    <th class="text-center">APERTURA</th> 
                                                    <th class="text-center">EFECTIVO</th> 
                                                    <th class="text-center">TARJETA</th>
                                                    <th class="text-center">CHEQUE</th>
                                                    <th class="text-center">IMPORTE COBRADO</th> 
                                                    <th class="text-center">IMPORTE TOTAL</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($cobros as $cobro) { ?> 
                                                <tr>
                                                    <td class="text-center"><?php echo $cobro['id_cobros']; ?></td>
                                                    <td class="text-center"><?php echo $cobro['empleado']; ?></td>
                                                    <td class="text-center"><?php echo $cobro['cob_fecha']; ?></td>
                                                    <td class="text-center"><?php echo $cobro['id_apercierre']; ?></td>
                                                    <td class="text-center"><?= number_format($cobro['efectivo'], 0, ',', '.'); ?></td>
                                                    <td class="text-center"><?= number_format($cobro['tarjeta'], 0, ',', '.'); ?></td>
                                                    <td class="text-center"><?= number_format($cobro['cheque'], 0, ',', '.'); ?></td>
                                                    <td class="text-center"><?= number_format($cobro['monto_total'], 0, ',', '.'); ?></td>
                                                    <td class="text-center"><?= number_format($cobro['ctaacobrar'], 0, ',', '.'); ?></td>
                                                           
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>                         
                                </div>
                            </div>
                        </div>
                        <!-- comienzo para el detalle-->
<!--                        <?php
                        $detcobros = consultas::get_datos
                                        ("select * from  v_deta_cobros"
                                        . " where id_cobros=" . $_REQUEST['vcod'] .
                                        "order by id_cobros asc");
                        ?>
-->                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <strong> Detalle de Cobros - EFECTIVO</strong>
                            </div>
                            <?php if (!empty($detcobros)) { ?>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center"># </th>
                                                <th class="text-center">#CUENTA</th>
                                                <th class="text-center">DETALLE FACTURA-CUOTA-MONTO</th>
                                                <th class="text-center">EFECTIVO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($detcobros as $detcobro) { ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $detcobro['id_cobros']; ?></td>
                                                    <td class="text-center"><?php echo $detcobro['cta_id']." - ".$detcobro['cli_nombre']." - ".$detcobro['cli_apellido']; ?></td>
                                                    <td class="text-center"><?php echo $detcobro['descripcion']; ?></td>
                                                    <td class="text-center"><?= number_format($cobro['efectivo'], 0, ',', '.'); ?></td>
                                                </tr>
                                    <?php } ?>
                                        </tbody>
                                    </table>
<?php } else { ?>
                                    
<?php } ?>
                            </div>
                        </div>

                         <!-- comienzo para el detalle-->
                    <div class="row">
                    <div class="col-lg-12">
                       
<!--                        <?php
                        $detcobros = consultas::get_datos
                                        ("select * from  v_cobro_tarjetas"
                                        . " where id_cobros=" . $_REQUEST['vcod'] .
                                        "order by id_cobros asc");
                        ?>
-->                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <strong> Detalle de Cobros - TARJETA</strong>
                            </div>
                            <?php if (!empty($detcobros)) { ?>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#Cob -#Det</th>
                                                <th class="text-center">#TARJETA</th>
                                                <th class="text-center">#TIPO TARJETA</th>
                                                 <th class="text-center">POS</th>
                                                <th class="text-center">#VOUCHER</th>
                                                <th class="text-center">ENTIDAD</th>
                                                <th class="text-center">IMPORTE TARJETA</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($detcobros as $detcobro) { ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $detcobro['id_cobros'] ." - ". $detcobro['cod_tarjeta']; ?></td>
                                                    <td class="text-center"><?php echo $detcobro['nro_tarjeta']; ?></td>
                                                    <td class="text-center"><?php echo $detcobro['tarj_tipo']; ?></td>
                                                    <td class="text-center"><?php echo $detcobro['descri_post']; ?></td>
                                                    <td class="text-center"><?php echo $detcobro['nro_vaucher']; ?></td>
                                                    <td class="text-center"><?php echo $detcobro['entidad_descri']; ?></td>
                                                     <td class="text-center"><?= number_format($detcobro['importe'], 0, ',', '.'); ?></td>
                                                </tr>
                                    <?php } ?>
                                        </tbody>
                                    </table>
<?php } else { ?>
                                    
<?php } ?>
                           
                        </div>
                        </div>
                        </div>
                        </div>

                    <div class="row">
                    <div class="col-lg-12">
                        

                          <?php
                        $detcobros = consultas::get_datos
                                        ("select * from  v_cobro_cheques"
                                        . " where id_cobros=" . $_REQUEST['vcod'] .
                                        "order by id_cobros asc");
                        ?>
                       <div class="panel panel-info">
                            <div class="panel-heading">
                                <strong> Detalle de Cobros - CHEQUE</strong>
                            </div>
                            <?php if (!empty($detcobros)) { ?>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#Cob -#Det</th>
                                                <th class="text-center">#CHEQUE</th>
                                                <th class="text-center">#TIPO CHEQUE</th>
                                                 <th class="text-center">FECHA EMISION</th>
                                                <th class="text-center">TITULAR</th>
                                                <th class="text-center">BANCO</th>
                                                <th class="text-center">IMPORTE CHEQUE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($detcobros as $detcobro) { ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $detcobro['id_cobros'] ." - ". $detcobro['cod_cheque']; ?></td>
                                                    <td class="text-center"><?php echo $detcobro['nro_cheque']; ?></td>
                                                    <td class="text-center"><?php echo $detcobro['descri']; ?></td>
                                                    <td class="text-center"><?php echo $detcobro['fecha_emision']; ?></td>
                                                    <td class="text-center"><?php echo $detcobro['titular']; ?></td>
                                                    <td class="text-center"><?php echo $detcobro['entidad_descri']; ?></td>
                                                     <td class="text-center"><?= number_format($detcobro['importe'], 0, ',', '.'); ?></td>
                                                </tr>
                                    <?php } ?>
                                        </tbody>
                                    </table>
<?php } else { ?>
                                    
<?php } ?>
                            
                        </div>
                        </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

             
            </div> 
        <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
         
       
            <script>
                function stock() {
                    var cant = parseInt($('#cantstock').val());
                    if(cant > 0) {
                        if (parseInt($('#cant').val()) > cant) {
                            alert('SOLO HAY '+ cant +
                                    'EN STOCK ESTE PRODUCTO');
                            $('#cant').val(cant);
                        }
                    } else{
                        $('#cant').val('0');
                    }
                }
</script>  


        <script>  
   
      
             function sololetras() {
                var numero = document.getElementById("descri").value;
                if (numero.match(/^[a-z A-Z]+$/))
                {

                } else {
                    alert("Solo letras");
                    document.getElementById("descri").value ="";
                }
            }
                   
        </script>
        <script>
        function solonumeros() {
                var numero = document.getElementById("cant").value;
                if (numero.match(/^-?[0-9]+(\.[0-9](1,2))?$/))
                {

                } else {
                    alert("Solo numeros");
                    document.getElementById("cant").value = "";
                }
            }
            
                    </script>
<script>
    function borrar(datos) {
        var dat = datos.split("_");
        $('#si').attr('href',
        'detrecep_control.php?vcod=' + dat[1] +
                '&vreme=' + dat[0] +
                '&vcant=' + dat[2] +
                '&vdescri=' + dat[3]+
                '&vimagen=' + dat[4]+
                '&vdcod=null'
                +'&accion=3' +
                '&pagina=detrecep_agregar.php');
        $('#confirmacion').html
        ('<span class="glyphicon glyphicon-warning-sign"></span>\n\
        Desea borrar el detalle?');
    }
</script>
    
    
    </body>
</html>
