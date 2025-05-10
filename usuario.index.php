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
                                    <i class="fa fa-clipboard"></i> 
                                    <h3 class="box-title">Usuarios</h3>
                                    <div class="box-tools">
                                        <a href="usuario.anadir.php" class="btn btn-primary btn-sm" data-title="Agregar" rel="tooltip" data-placement="left">
                                            <i class="fa fa-plus"></i></a>
                                            <a href="usuario.print.php" class="btn btn-default btn-sm" data-title="Imprimir" rel="tooltip" data-placement="left" target="print">
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
                                            <?php $usuarios = consultas::get_datos("select * from v_usuarios where (usu_nick) ilike '%".(isset($_REQUEST['buscar'])? $_REQUEST['buscar']:"")."%' order by usu_cod"); 
                                                if (!empty($usuarios)) { ?>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-condensed table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>USUARIO</th>
                                                            <th>CLAVE</th>
                                                            <th>Nombre Empleado</th>
                                                           <!-- <th>Impuesto</th>-->
                                                            <th class="text-center">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($usuarios as $usuario) { ?>
                                                        <tr>
                                                            <td data-title="USUARIO"><?php echo $usuario['usu_nick'];?></td>
                                                            <th>*********</th>
                                                            <td data-title="Nombre Empleado"><?php echo $usuario['empleado'];?></td>
                                                            <!--<td data-title="Impuesto"></?php echo $usuario['tipo_descri'];?></td>-->
                                                            <td data-title="Acciones" class="text-center">
                                                                <a href="usuario.editar.php?vusu_cod=<?php echo $usuario['usu_cod'];?>" class="btn btn-success btn-sm" data-title="Editar" rel="tooltip" data-placement="left">
                                                                    <i class="fa fa-edit"></i></a> 
                                                                <!--<a href="articulo.borrar.php?vart_cod=<//?php echo $articulo['art_cod'];?>" class="btn btn-danger btn-sm" data-title="Borrar" rel="tooltip" data-placement="left">
                                                                    <i class="fa fa-trash"></i></a>-->
                                                                <a onclick="borrar(<?php echo "'".$usuario['usu_cod']."_".$usuario['usu_nick']."_".$usuario['usu_clave'].
                                                                        "_".$usuario['empleado']."_".$usuario['gru_nombre'].
                                                                        "'"?>)" 
                                                                   class="btn btn-sm btn-danger" role="button" data-title="Borrar"
                                                                    rel="tooltip" data-placement="top" data-toggle="modal" data-target="#borrar">
                                                                    <span class="glyphicon glyphicon-trash"></span>     
                                                                </a>
                                                            </td>
                                                        </tr>  
                                                        <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php }else{ ?>
                                            <div class="alert alert-info">
                                                <span class="glyphicon glyphicon-info-sign"></span> 
                                                No se han registrado usuarios...
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
            function borrar(datos) {
                var dat = datos.split("_");
                $('#si').attr('href','usuario_control.php?vusu_cod='+dat[0]+'&vusu_nick='+dat[1]+
                        '&vusu_clave='+dat[2]+'&accion=3');
                $('#confirmacion').html('<span class="glyphicon glyphicon-warning-sign"></span> \n\
                                Desea borrar el usuario <i><strong>'+dat[1]+'</strong> ?</i>');
            }
        </script>
    </body>
</html>


