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
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="fa fa-list"></i>
                                    <h3 class="box-title">Reporte de Modulos</h3>
                                    <div class="box-tools">
                                        <a class="btn btn-primary btn-sm" data-toggle="modal" role="button" data-target="#registrar">
                                            <i class="fa fa-plus"></i></a>
                                        <a href="modulo.print.php" class="btn btn-default btn-sm" data-title="Imprimir" rel="tooltip" data-placement="left" target="print">
                                            <i class="fa fa-print"></i></a>
                                    </div>
                                </div>
                                <div class="box-body no-padding">
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12 col-lg-12">
                                            <?php $opcion='2';
                                             if (isset($_GET['opcion'])) {
                                                    $opcion=$_GET['opcion'];
                                            }  ?>
                                            <form action="modulo.print.php" method="get" accept-charset="utf-8" class="form-horizontal">
                                                <input type="hidden" value="<?php echo $opcion;?>" name="opcion"/>
                                                <div class="box-body">
                                                    <div class="col-md-4 col-sm-4 col-lg-4">
                                                        <div class="panel panel-primary">
                                                            <div class="panel-heading">
                                                                <strong>OPCIONES</strong>
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="list-group">
                                                                    <a href="modulo.rpt.php?opcion=1" class="list-group-item">Por Codigo</a>
                                                                    <a href="modulo.rpt.php?opcion=2" class="list-group-item">Por Nombre</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-sm-8 col-lg-8">
                                                        <div class="panel panel-primary">
                                                            <div class="panel-heading">
                                                                <strong>FILTROS</strong>
                                                            </div>
                                                            <div class="panel-body">
                                                                <?php
                                                                $modulos = consultas::get_datos("select * from modulos order by mod_cod");
                                                                ?>
                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label">Desde:</label>
                                                                    <div class="col-md-6">
                                                                        <select class="form-control select2" name="vdesde">
                                                                            <?php if (!empty($modulos)) {
                                                                             foreach ($modulos as $mod) { ?>
                                                                            <option value="<?php if ($opcion==='1') {
                                                                                 echo $mod['mod_cod'];}
                                                                                 else {$mod['mod_nombre'];}
                                                                                ?>">
                                                                                <?php if ($opcion=='1') {
                                                                                        echo $mod['mod_cod'];} else {
                                                                                        echo $mod['mod_nombre'];
                                                                                        }?>
                                                                            </option>
                                                                             <?php }
                                                                                } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label">Hasta:</label>
                                                                    <div class="col-md-6">
                                                                        <select class="form-control select2" name="vhasta">
                                                                            <?php if (!empty($modulos)) {
                                                                             foreach ($modulos as $mod) { ?>
                                                                            <option value="<?php if ($opcion==='1') {
                                                                                 echo $mod['mod_cod'];}
                                                                                 else {echo $mod['mod_nombre'];}
                                                                                ?>">
                                                                                <?php if ($opcion=='1') {
                                                                                        echo $mod['mod_cod'];} else {
                                                                                        echo $mod['mod_nombre'];
                                                                                        }?>
                                                                            </option>
                                                                             <?php }
                                                                                } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="box-footer">
                                                    <button type="submit" class="btn btn-primary pull-right" >
                                                        <i class="fa fa-print" target="print"></i> Listar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                  <?php require 'menu/footer_lte.ctp'; ?><!--ARCHIVOS JS-->  
                  <!--INICIA MODAL REGISTRAR-->
                 <div class="modal fade" id="registrar" role="dialog">
                     <div class="modal-dialog">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                 <h4 class="modal-title">Registrar Modulo</h4>
                             </div>
                             <form action="modulo_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                 <input name="accion" value="1" type="hidden"/>
                                 <input name="vmod_cod" value="0" type="hidden"/>
                                 <div class="box-body">
                                     <div class="form-group">
                                         <label class="col-sm-2 control-label">Nombre</label>
                                         <div class="col-sm-6 col-lg-6 col-xs-6 col-md-6">
                                             <input type="text" class="form-control" name="vmod_nombre" required=""/>
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
                 <!--FIN MODAL REGISTRAR-->
                 <!--INICIA MODAL EDITAR-->
                 <div class="modal fade" id="editar" role="dialog">
                     <div class="modal-dialog">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                 <h4 class="modal-title">Editar Modulo</h4>
                             </div>
                             <form action="modulo_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                 <input name="accion" value="2" type="hidden"/>
                                 <input id="cod" name="vmod_cod" type="hidden"/>
                                 <div class="box-body">
                                     <div class="form-group">
                                         <label class="col-sm-2 control-label">Nombre</label>
                                         <div class="col-sm-6 col-lg-6 col-xs-6 col-md-6">
                                             <input id="descri" type="text" class="form-control" name="vmod_nombre" required=""
                                                    onclick="this.select();"/>
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
        <!--selecciona todo para editar el texto-->
        <script type="text/javascript"> 
            $("input[type=text]").focus(function(){	   
             this.select();
            });
       </script>
        <script>
            function editar(datos) {
                var dat = datos.split("_");
                $('#cod').val(dat[0]);
                $('#descri').val(dat[1]);
            }
            function borrar(datos) {
                var dat = datos.split("_");
                $('#si').attr('href','modulo_control.php?vmod_cod='+dat[0]+'&vmod_nombre='+dat[1]+'&accion=3');
                $('#confirmacion').html('<span class="glyphicon glyphicon-warning-sign"></span> \n\
                                Desea borrar el modulo <i><strong>'+dat[1]+'</strong> ?</i>');
            }
        </script>
    </body>
</html>


