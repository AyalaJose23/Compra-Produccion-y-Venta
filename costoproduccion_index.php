
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
    <body class="hold-transition skin-black sidebar-mini">
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
                                    <h3 class="page-header text-center"><strong>COSTO DE PRODUCCIÓN</strong>
                                    <a href="/tdp/MANUAL DE USUARIO tdp.pdf" target="print">
                                    <span class="glyphicon glyphicon-question-sign"></span>
                                </a>
                                            <a href="costoproduccion_anadir.php" id="btnAbrir" class="btn btn-primary  pull-right" value="Abrir" rel="tooltip" data-placement="left" onclick="ven();">
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
                                <div class="panel panel-info">
                                            <div class="panel-heading">
                                                Datos
                                            </div>                     
                                                    <!-- /.panel-heading -->
                                        <div class="panel-body">
                                            <?php
                                             $costoproduc = consultas::get_datos("select * from v_costo_p where (id_costo::varchar||fecha_costo::varchar) ilike '%".(isset($_REQUEST['buscar'])? $_REQUEST['buscar']:"")."%' order by id_costo desc");
                                            if (!empty($costoproduc)) { ?>
                                            <div class="table-responsive">
                                                <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                    <th>#</th>
                                                    <th>Fecha</th>
                                                    <th>Orden N°</th>
                                                    <th>Total</th>
                                                    <th>Estado</th>
                                                    <th class="text-center">Acciones</th>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($costoproduc as $costoprod) { ?>
                                                             <tr>
                                                        <td data-title="#"><?php echo $costoprod['id_costo'];?></td>
                                                        <td data-title="Fecha"><?php echo $costoprod['fecha_costo'];?></td>
                                                        <td data-title="#"><?php echo $costoprod['cod_orden'];?></td>
                                                        <!--<td data-title="Proveedor"></?php echo $costoprod['proveedor'];?></td>-->
                                                        <td data-title="Total"><?php echo number_format($costoprod['costo_total'],0,",",".");?></td>
                                                        <td data-title="Estado"><?php echo $costoprod['costo_estado'];?></td>
                                                            <td data-title="Acciones" class="text-center">
                                                                <?PHP if ($costoprod['costo_estado']=='PENDIENTE') { ?>
                                                                <a onclick="confirmar(<?php echo "'".$costoproduc[0]['id_costo']."_".$costoproduc[0]['fecha_costo']."'";?>)" 
                                                                class="btn btn-success btn-sm" data-title="Confirmar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#confirmar">
                                                                <i class="fa fa-check"></i></a>
                                                                <a href="costoproduccion_det.php?vid_costo=<?php echo $costoprod['id_costo'];?>" class="btn btn-primary btn-sm" data-title="Detalles" rel="tooltip" data-placement="left">
                                                                    <i class="fa fa-list"></i></a> 
                                                                <!--<a href="pedcompras_editar.php?vpedcom_cod=</?php echo $costoprod['pedcom_cod'];?>" class="btn btn-warning btn-sm" data-title="Editar" rel="tooltip" data-placement="left">
                                                                    <i class="fa fa-edit"></i></a>-->
                                                                    <a onclick="anular(<?php echo "'".$costoprod['id_costo']."_".$costoprod['fecha_costo']."'";?>)" 
                                                                       class="btn btn-danger btn-sm" data-title="Anular" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#anular">
                                                                    <i class="fa fa-remove"></i></a>
                                                                <?php }?> 
                                                                <a href="costoproduccion_print.php?vcospro_cod=<?php echo $costoprod['id_costo'];?>" class="btn btn-default btn-sm" data-title="Imprimir" rel="tooltip" data-placement="left" target="print">
                                                                    <i class="fa fa-print"></i></a>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                          <?php  }else{ ?>
                                            <div class="alert alert-info flat">
                                                <span class="glyphicon glyphicon-info-sign"></span>
                                                No se han registrado costo de produccion..
                                            </div>
                                         <?php   } ?>
                                        </div>
                                    </div>
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
             $("#mensaje").delay(4000).slideUp(200,function(){
           $(this).alert('close'); 
        });
        </script>
        <script>

            function confirmar(datos) {
        var dat = datos.split('_');
        $('#sic').attr('href', 'costoproduccion_control.php?vcospro_cod=' + dat[0] + '&vcospro_fecha=' + dat[1] + '&accion=2');
        $("#confirmacionc").html('<span class="glyphicon glyphicon-info-sign"></span> \n\
            Desea confirmar el costo produccion N° <strong>' + dat[0] + '</strong> de fecha <strong>' + dat[1] + '</strong>');
        }  
        
        function anular(datos){
            var dat = datos.split('_');
            $('#si').attr('href','costoproduccion_control.php?vcospro_cod='+dat[0]+'&accion=3');
            $("#confirmacion").html('<span class="glyphicon glyphicon-warning-sign"></span> \n\
            Desea anular el costo de Produccion N° <strong>'+dat[0]+'</strong> de fecha <strong>'+dat[1]+'</strong>')
        }
               
        </script>
    </body>
</html>


