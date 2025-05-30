<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="image/x-icon" href="/lp3/favicon.ico">
        <title>LP3</title>
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
                        <div class="col-lg-12 col-md-12 col-xs-12">
                            <?php if (!empty($_SESSION['mensaje'])) { ?>
                            <div class="alert alert-danger" role="alert" id="mensaje">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                <?php echo $_SESSION['mensaje'];
                                $_SESSION['mensaje']='';?>
                            </div>
                             <?php } ?>
                            <div class="box box-primary"> <!--linea azul-->
                                <div class="box-header">  <!--compo blanco-->
                                    <i class="ion ion-person"></i>
                                    <h3 class="box-title">Tipo Impuesto</h3>
                                    <div class="box-tools">
                                        <a class="btn btn-primary btn-sm" data-toggle="modal" role="button" data-target="#registrar">
                                            <i class="fa fa-plus"></i></a>
                                        <a href="tipoimpuesto.print.php" class="btn btn-default btn-sm" data-title="Imprimir" rel="tooltip" data-placement="left" target="print">
                                            <i class="fa fa-print"></i></a>                            
                                    </div>
                                </div>
                                <!------------------------------------------------------------------------------------------------>
                                <div class="box-body no-padding">
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12 col-lg-12">
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
                                            <?php
                                            $impuestos = consultas::get_datos("select * from tipo_impuesto where tipo_descri ilike '%".(isset($_REQUEST['buscar'])? $_REQUEST['buscar']:"")."%' order by tipo_cod");
                                            if (!empty($impuestos)) { ?>
                                            <div class="table-responsive">
                                                <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                        <tr>
                                                            <th>Descripcion</th>
                                                            <th>Porcentaje</th>
                                                            <th class="text-center">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($impuestos as $impu) { ?>
                                                        <tr>
                                                            <td data-title="Descripcion"><?php echo $impu['tipo_descri'];?></td>
                                                            <td data-title="Porcentaje"><?php echo $impu['tipo_porcen'];?></td>
                                                            <td data-title="Acciones" class="text-center">
                                                                <a onclick="editar(<?php echo "'".$impu['tipo_cod']."_".$impu['tipo_descri']."_".$impu['tipo_porcen']."'"?>)" 
                                                                   class="btn btn-xs btn-warning" role="button" data-title="Editar"
                                                                    rel="tooltip" data-placement="top" data-toggle="modal" data-target="#editar">
                                                                    <span class="glyphicon glyphicon-pencil"></span>     
                                                                </a>
                                                                <a onclick="borrar(<?php echo "'".$impu['tipo_cod']."_".$impu['tipo_descri']."_".$impu['tipo_porcen']."'"?>)" 
                                                                   class="btn btn-xs btn-danger" role="button" data-title="Borrar"
                                                                    rel="tooltip" data-placement="top" data-toggle="modal" data-target="#borrar">
                                                                    <span class="glyphicon glyphicon-trash"></span>     
                                                                </a>
                                                            </td>
                                                        </tr> 
                                                      <?php   } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                           <?php } else { ?>
                                            <div class="alert alert-info flat">
                                                <span class="glyphicon glyphicon-info-sign"></span>
                                                No se han registrado Tipo impuesto...
                                            </div>
                                          <?php   } ?>
                                        </div>
                                    </div>
                                </div>
                                <!---------------------------------------------------------------------------------------------->
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
                  <?php require 'menu/footer_lte.ctp'; ?><!--ARCHIVOS JS-->  
                  <!--INICIA MODAL REGISTRAR TIPO IMPUESTO-->
                 <div class="modal fade" id="registrar" role="dialog">
                     <div class="modal-dialog">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                 <h4 class="modal-title">Registrar Tipo impuesto</h4>
                             </div>
                             <form action="tipoimpuesto_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                 <input name="accion" value="1" type="hidden"/>
                                 <input name="vtipo_cod" value="0" type="hidden"/>
                                 <div class="box-body">
                                     <div class="form-group">
                                         <label class="col-sm-2 control-label">Descripcion</label>
                                         <div class="col-sm-6 col-lg-6 col-xs-6 col-md-6">
                                             <input type="text" class="form-control" name="vtipo_descri" required=""/>
                                         </div>
                                     </div>
                                     <div class="form-group">
                                            <label class="col-sm-2 control-label">Porcentaje:</label>
                                            <div class="col-lg-6 col-md-6 col-sm-7">
                                                <input type="number" name="vtipo_porcen" class="form-control" required="" autofocus=""
                                                       min="0" pattern="^[0-9]+"/>
                                            </div>
                                        </div>
                                 </div>
                                 <div class="modal-footer">
                                     <button type="reset" data-dismiss="modal" class="btn btn-default">
                                         <a class="fa fa-remove"></a> Cerrar</button>
                                     <button type="submit" class="btn btn-primary pull-right">
                                         <a class="fa fa-floppy-o"></a> Registrar</button>
                                 </div>
                             </form>
                         </div>
                     </div>
                 </div>
                 <!--FIN MODAL REGISTRAR TIPO IMPUESTO-->
                 <!--INICIA MODAL EDITAR-->
                 <div class="modal fade" id="editar" role="dialog">
                     <div class="modal-dialog">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                 <h4 class="modal-title">Editar Tipo impuesto</h4>
                             </div>
                             <form action="tipoimpuesto_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                 <input name="accion" value="2" type="hidden"/>
                                 <input id="cod" name="vtipo_cod" type="hidden"/>
                                 <div class="box-body">
                                     <div class="form-group">
                                         <label class="col-sm-2 control-label">Descripcion</label>
                                         <div class="col-sm-7 col-lg-6 col-xs-6 col-md-6">
                                             <input id="descri" type="text" class="form-control" name="vtipo_descri" required=""
                                                    onclick="this.select();"/>
                                         </div>
                                     </div>
                                     <div class="form-group">
                                            <label class="col-sm-2 control-label">Porcentaje:</label>
                                            <div class="col-lg-6 col-md-6 col-sm-7">
                                                <input id="porcen" type="number" name="vtipo_porcen" class="form-control" required="" autofocus=""
                                                       min="0" pattern="^[0-9]+"/>
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
                 <!--INICIA MODAL ELIMINAR-->
                 <div class="modal fade" id="borrar" role="dialog">
                     <div class="modal-dialog">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <button type="button" class="close" data-dismiss="modal">x</button>
                                 <h4 class="data-title custom_align" id="Heading" >Atencion!!!</h4>
                             </div>
                             <div class="modal-body">
                                 <div class="alert alert-warning" id="confirmacion"></div>
                             </div>
                             <div class="modal-footer">
                                 <a id="si" role="button" class="btn btn-primary">
                                     <span class="glyphicon glyphicon-ok-sign"></span> Si</a>
                                     <button type="button" class="btn btn-default" data-dismiss="modal">
                                         <span class="glyphicon glyphicon-remove"></span> No</button>
                             </div>
                         </div>
                     </div>
                 </div>
                 <!--FIN MODAL ELIMINAR-->
        </div>                  
        <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
        <script>
            $("#mensaje").delay(4000).slideUp(200, function() {
               $(this).alert('close'); 
            });
            $('.modal').on('shown.bs.modal', function() {
                $(this).find('input:text:visible:first').focus();
            });
        </script>
        <script>
            function editar(datos) {
                var dat = datos.split("_");
                $('#cod').val(dat[0]);
                $('#descri').val(dat[1]);
                $('#porcen').val(dat[2]);
            }
            function borrar(datos) {
                var dat = datos.split("_");
                $('#si').attr('href','tipoimpuesto_control.php?vtipo_cod='+dat[0]+'&vtipo_descri='+dat[1]+'&vtipo_porcen='+dat[2]+'&accion=3');
                $('#confirmacion').html('<span class="glyphicon glyphicon-warning-sign"></span> \n\
                                Desea borrar el tipo Impusto <i><strong>'+dat[1]+'</strong></i>');
            }
        </script>
    </body>
</html>


