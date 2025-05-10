<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-7">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon"  href=" img/mueble.png"/>
        <title>Todo Muebles</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <?php 
        session_start();/*Reanudar sesion*/
        require 'menu/css_lte.ctp'; ?><!--ARCHIVOS CSS-->

    </head>
    <body class="hold-transition skin-green sidebar-mini">
        <div class="wrapper">
            <?php require 'menu/header_lte.ctp'; ?><!--CABECERA PRINCIPAL-->
            <?php require 'menu/toolbar_lte.ctp';?><!--MENU PRINCIPAL-->
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
                                <div class="col-lg-12">
                                <h3 class="page-header text-center"><strong>PRESUPUESTO DE VENTA</strong>
                                <a href="/tdp/MANUAL DE USUARIO tdp.pdf" target="print">
                                    <span class="glyphicon glyphicon-question-sign"></span>
                                </a>
                                            <a href="presu.prod.anadir.php" class="btn btn-success pull-right" data-title="Agregar" rel="tooltip" data-placement="left">
                                                <i class="fa fa-plus"></i> AGREGAR</a>                                            
                                </div>
                        </div>
                    </div>
                                
                                
                                <div class="box-body no-padding">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                            <form method="post" accept-charset="utf-7" class="form-horizontal">
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="input-group custom-search-form">                                                                
                                                                <input type="search" name="buscar" class="form-control" placeholder="Ingrese valor a buscar..." autofocus=""/>
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
                                            $presupuestos = consultas::get_datos("select * from v_presu_prod where (cod_preprod::varchar||preprod_fecha::varchar) ilike '%".(isset($_REQUEST['buscar'])? $_REQUEST['buscar']:"")."%' order by cod_preprod desc"); 
                                            if (!empty($presupuestos)) { ?>

                                            <div class="table-responsive">
                                                <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                        <th class="success">#</th>
                                                        <th  class="text-center success">Nro Presupuesto</th>
                                                        <th  class="success">Cliente</th>
                                                        <th  class="success">Fecha</th>
                                                        <th  class="success">Validez</th>
                                                        <th  class="success">Monto</th>
                                                        <th  class="success">Estado</th>
                                                        <th class="text-right success">Acciones</th>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($presupuestos as $presu) { ?>
                                                        <tr>
                                                        <td data-title="#"><?php echo $presu['cod_preprod'];?></td>
                                                        <td class="text-center" data-title="Nro Presupuesto"><?php echo $presu['preprod_nro'];?></td>
                                                        <td data-title="Cliente  "><?php echo $presu['clientes'];?></td>
                                                        <td data-title="Fecha"><?php echo $presu['preprod_fecha'];?></td>
                                                        <td data-title="Validez"><?php echo $presu['preprod_validez'];?></td>
                                                       <td data-title="Monto"><?php echo number_format($presu['preprod_monto'],0,",",".");?></td>
                                                        <td data-title="Estado"><?php echo $presu['preprod_estado'];?></td>
                                                            <td data-title="Acciones" class="text-right">
                                                           
                                                                 <?php if ($presu['preprod_monto'] > 0 ) { ?> 
                                                                    <a href="presu.prod.print.php?vcod_preprod=<?php echo $presu['cod_preprod']; ?>"
                                                                        target="_blank" class="btn btn-sm btn-default" rel="tooltip" data-title="imprimir">
                                                                <span class="glyphicon glyphicon-print"></span></a>
                                                            <?php } else { ?>
                                                                     <?php } ?>
                                                                
                                                                   <?php if ($presu['preprod_monto'] > 0 && $presu['preprod_estado'] == 'REGISTRADO') { ?>   
                                                                    <a onclick="confirmar(<?php echo "'".$presu['cod_preprod']."_".$presu['ped_cod']."'";?>)" 
                                                                       class="btn btn-primary btn-sm" data-title="Confirmar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#confirmar">
                                                                    <i class="fa fa-check"></i></a>   
                                                                            
                                                                    
                                                                <?php }
                                                                if($presu['preprod_estado']=='PENDIENTE' || $presu['preprod_estado']=='REGISTRADO' || $presu['preprod_estado']=='EN PROCESO'|| $presu['preprod_estado']=='CONFIRMADO'){?>
                                                                      
                                                            <a href="presu.prod.det.php?vcod_preprod=<?php echo $presu['cod_preprod'];?>" class="btn btn-success btn-sm" data-title="Detalles" rel="tooltip" data-placement="left">
                                                                    <i class="fa fa-list"></i></a>   
                                                                    <a onclick="anular(<?php echo "'".$presu['cod_preprod']."_".$presu['ped_cod']."_".$presu['cli_cod']."_".$presu['preprod_nro']."_".$presu['preprod_fecha']."_".$presu['preprod_validez']."_".$presu['preprod_obs']."'";?>)" 
                                                                       class="btn btn-danger btn-sm" data-title="Anular" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#anular">
                                                                    <i class="fa fa-remove"></i></a>                                                                                                                                                                        
                                                                <?php }?>
                                                                
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>                         
                                        </div>
                                    <?php } else { ?>
                                        <div class="alert alert-info alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <strong>No se encontraron registro....!</strong>
                                        </div>
                                    <?php } ?> 
                                        </div>
                                    </div>
                                </div>
                                </div>
                                    </div>
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
                  <!-- MODAL ANULAR-->
                  <div class="modal" id="anular" role="dialog">
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
                                  <a id="si" role="buttom" class="btn btn-primary">
                                      <span class="glyphicon glyphicon-ok-sign"></span> SI
                                  </a>
                                  <button type="button" class="btn btn-default" data-dismiss="modal">
                                      <span class="glyphicon glyphicon-remove"></span> NO
                                  </button>
                              </div>
                          </div>
                      </div>
                  </div>
                  <!-- FIN MODAL ANULAR-->    
            </div>   
                           
        <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
        <script>
             $("#mensaje").delay(3000).slideUp(200,function(){
           $(this).alert('close'); 
        });
        </script>
        <script>
       function anular(datos){
            var dat = datos.split('_');

            $('#si').attr('href', 'presu.prod_control.php?vcod_preprod=' + dat[0] + '&accion=3' );
                          
$("#confirmacion").html('<span class="glyphicon glyphicon-warning-sign mensaje-anulacion">Desea anular el Presupuesto N° <strong>'+dat[0]+'</strong> de fecha <strong>'+dat[4]+'</strong></span>');

            $("#confirmacion").html('<span class="glyphicon glyphicon-warning-sign"></span> \n\
            Desea anular el Presupuesto N° <strong>'+dat[0]+'</strong> de fecha <strong>'+dat[4]+'</strong>')
        }
        function confirmar(datos){
            var dat = datos.split('_');
            $('#sic').attr('href', 'presu.prod_control.php?vcod_preprod=' + dat[0] + '&vped_cod=' + dat[1] +'&accion=2' );

            $("#confirmacionc").html('<span class="glyphicon glyphicon-info-sign"></span> \n\
            Desea confirmar el Presupuesto N° <strong>'+dat[0]+'</strong> de fecha <strong>'+dat[1]+'</strong>')
        }       
        </script>
    </body>
</html>