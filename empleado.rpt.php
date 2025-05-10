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
                                    <i class="fa fa-list"></i> 
                                    <h3 class="box-title">Reporte de los Empleados</h3>
                                    <div class="box-tools">
                                        <a href="empleado.anadir.php" class="btn btn-primary btn-sm" data-title="Agregar" rel="tooltip" data-placement="left">
                                            <i class="fa fa-plus"></i></a>
                                            <a href="empleado.print.php" class="btn btn-default btn-sm" data-title="Imprimir" rel="tooltip" data-placement="left" target="print">
                                            <i class="fa fa-print"></i></a>                                            
                                    </div>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                             <?php $opcion='2';
                                             if (isset($_GET['opcion'])) {
                                                    $opcion=$_GET['opcion'];
                                            }  ?>
                                            <form action="empleado.print.php" method="get" accept-charset="utf-8" class="form-horizontal">
                                                <input type="hidden" value="<?php echo $opcion;?>" name="opcion"/>
                                                <div class="box-body">
                                                    <div class="col-md-4 col-sm-4 col-lg-4">
                                                        <div class="panel panel-primary">
                                                            <div class="panel-heading">
                                                                <strong>OPCIONES</strong>
                                                            </div>
                                                            <div class="panel-body">
                                                                <div class="list-group">
                                                                    <a href="empleado.rpt.php?opcion=1" class="list-group-item">Por Codigo</a>
                                                                    <a href="empleado.rpt.php?opcion=2" class="list-group-item">Por Nombre</a>
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
                                                                $empleados = consultas::get_datos("select * from v_empleado order by emp_cod");
                                                                ?>
                                                                <div class="form-group">
                                                                    <label class="col-md-2 control-label">Desde:</label>
                                                                    <div class="col-md-6">
                                                                        <select class="form-control select2" name="vdesde">
                                                                            <?php if (!empty($empleados)) {
                                                                             foreach ($empleados as $emp) { ?>
                                                                            <option value="<?php if ($opcion==='1') {
                                                                                 echo $emp['emp_cod'];}
                                                                                 else {$emp['emp_nombre']." ".$emp['emp_apellido'];}
                                                                                ?>">
                                                                                <?php if ($opcion=='1') {
                                                                                        echo $emp['emp_cod'];} else {
                                                                                        echo $emp['emp_nombre']." ".$emp['emp_apellido'];
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
                                                                            <?php if (!empty($empleados)) {
                                                                             foreach ($empleados as $emp) { ?>
                                                                            <option value="<?php if ($opcion==='1') {
                                                                                 echo $emp['emp_cod'];}
                                                                                 else {echo $emp['emp_nombre']." ".$emp['emp_apellido'];}
                                                                                ?>">
                                                                                <?php if ($opcion=='1') {
                                                                                        echo $emp['emp_cod'];} else {
                                                                                        echo $emp['emp_nombre']." ".$emp['emp_apellido'];
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
            /*function borrar(datos) {
                var dat = datos.split("_");
                $('#si').attr('href','deposito_control.php?vdep_cod='+dat[0]+'&vdep_descri='+dat[1]+
                        '&vsuc_descri='+dat[2]+'&accion=3');
                $('#confirmacion').html('<span class="glyphicon glyphicon-warning-sign"></span> \n\
                                Desea borrar el deposito <i><strong>'+dat[1]+" "+dat[2]+'</strong> ?</i>');
            }*/
        </script>
    </body>
</html>


