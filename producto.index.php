<!DOCTYPE html>
<html>
    <head>
       <link rel="shortcut icon"  href=" img/mueble.png"/>
        <meta charset="utf-8">
        <link rel="shortcut icon"  href=" img/mueble.png"/>
        <title>Todo Muebles</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <?php 
        session_start();/*Reanudar sesion*/
        require 'menu/css_lte.ctp'; ?><!--ARCHIVOS CSS-->

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php require 'menu/header_lte.ctp'; ?><!--CABECERA PRINCIPAL-->
            <?php require 'menu/toolbar_lte.ctp';?><!--MENU PRINCIPAL-->
            <div class="content-wrapper">
                <div class="content">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <?php if(!empty($_SESSION['mensaje'])){ ?>
                            <div class="alert alert-danger" role="alert" id="mensaje">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                <?php echo $_SESSION['mensaje'];
                                $_SESSION['mensaje'] = '' ;?>
                            </div>
                            <?php } ?>
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="fa fa-clipboard"></i> 
                                    <h3 class="box-title">Productos</h3>
                                    <div class="box-tools">
                                        <a href="producto.anadir.php" class="btn btn-primary btn-sm" data-title="Agregar" rel="tooltip" data-placement="left">
                                            <i class="fa fa-plus"></i></a>
                                            <a href="producto.print.php" class="btn btn-default btn-sm" data-title="Imprimir" rel="tooltip" data-placement="left" target="print">
                                            <i class="fa fa-print"></i></a>                                            
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <form method="post" accept-charset="utf-8" class="form-horizontal">
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
                                            <?php $articulos = consultas::get_datos("select * from v_producto where (produ_descri) ilike '%".(isset($_REQUEST['buscar'])? $_REQUEST['buscar']:"")."%' order by cod_produ"); 
                                                if (!empty($articulos)) { ?>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-condensed table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Descripción</th>
                                                            <th>Tipo de Insumo</th>
                                                            <th>Estado</th>
                                                            <th class="text-center">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($articulos as $articulo) { ?>
                                                        <tr>
                                                            <td data-title="#"><?php echo $articulo['cod_produ'];?></td>
                                                            <td data-title="Descripción"><?php echo $articulo['produ_descri'];?></td>
                                                            <td data-title="Tipo de Insumo"><?php echo $articulo['tipo_descri'];?></td>
                                                            <td data-title="Estado"><?php echo $articulo['produ_estado'];?></td>
                                                            <td data-title="Acciones" class="text-center">

                                                            <?php if($articulo['produ_estado']=='ACTIVO'){?>
                                                                    <a onclick="desactivar(<?php echo "'".$articulo['cod_produ']."_".$articulo['produ_descri']."'";?>)" 
                                                                       class="btn btn-danger btn-sm" data-title="Desactivar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#desactivar">
                                                                    <i class="fa fa-remove"></i></a>

                                                                    <a href="producto.editar.php?vart_cod=<?php echo $articulo['cod_produ'];?>" class="btn btn-success btn-sm" data-title="Editar" rel="tooltip" data-placement="left">
                                                                    <i class="fa fa-edit"></i></a>
                                                                    <?php }
                                                                if($articulo['produ_estado']=='INACTIVO'){?>
                                                                     <a onclick="activar(<?php echo "'".$articulo['cod_produ']."_".$articulo['produ_descri']."'";?>)" 
                                                                       class="btn btn-primary btn-sm" data-title="Activar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#activar">
                                                                    <i class="fa fa-check"></i></a>   

                                                                <?php }?>
                                                            </td>
                                                        </tr>  
                                                        <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php }else{ ?>
                                            <div class="alert alert-info">
                                                <span class="glyphicon glyphicon-info-sign"></span> 
                                                No se han registrado articulos...
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
                  <?php require 'menu/footer_lte.ctp'; ?><!--ARCHIVOS JS--> 
                 
                 <!--INICIA MODAL EDITAR-->
                 <div class="modal fade" id="editar" role="dialog">
                     <div class="modal-dialog">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                 <h4 class="modal-title">Editar Marcas</h4>
                             </div>
                             <form action="articulo_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                 <input name="accion" value="2" type="hidden"/>
                                 <input id="cod" name="vcar_cod" type="hidden"/>
                                 <div class="box-body">
                                     <div class="form-group">
                                         <label class="col-sm-2 control-label">Descripcion</label>
                                         <div class="col-sm-12 col-lg-12 col-xs-12 col-md-12">
                                             <input id="descri" type="text" class="form-control" name="vcar_descri" required=""/>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="modal-footer">
                                     <button type="reset" data-dismiss="modal" class="btn btn-default">
                                         <a class="fa fa-remove"></a> Cerrar</button>
                                     <button type="submit" class="btn btn-primary pull-right">
                                         <a class="fa fa-floppy-o"></a> Actualizar</button>
                                 </div>
                             </form>
                         </div>
                     </div>
                 </div>
                 <!--FIN MODAL EDITAR-->
                 <!-- MODAL activar-->
                <div class="modal" id="activar" role="dialog">
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
                  <!-- FIN MODAL activar-->  

                  <!-- MODAL desactivar-->
                  <div class="modal" id="desactivar" role="dialog">
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
                  <!-- FIN MODAL desactivar--> 
            </div>                  
        <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
        <script>
            $("#mensaje").delay(4000).slideUp(200, function() {
               $(this).alert('close'); 
            });
           /* $('.modal').on('shown.bs.modal', function() {
                $(this).find('input:text:visible:first').focus();
            });*/
        </script>
       <script>
            function editar(datos) {
                var dat = datos.split("_");
                $('#cod').val(dat[0]);
                $('#descri').val(dat[1]);
            }
            function desactivar(datos){
                var dat = datos.split('_');
                $('#si').attr('href','articulo_control.php?vart_cod='+dat[0]+'&accion=3');
                $("#confirmacion").html('<span class="glyphicon glyphicon-warning-sign"></span> \n\
                Desea Inactivar el Articulo  <strong>'+dat[0]+'</strong> <strong>'+dat[1])
            }
            function activar(datos){
                var dat = datos.split('_');
                $('#sic').attr('href','articulo_control.php?vart_cod='+dat[0]+'&accion=5');
                $("#confirmacionc").html('<span class="glyphicon glyphicon-info-sign"></span> \n\
                Desea Activar el Articulo  <strong>'+dat[0]+'</strong> <strong>'+dat[1])
            }        
        
       
        </script>
    </body>
</html>


