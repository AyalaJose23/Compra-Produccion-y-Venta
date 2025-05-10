<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
                        <div class="col-lg-12 col-md-12 col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-plus"></i>
                                    <h3 class="box-title">Modificar Articulos</h3>
                                    <div class="box-tools">
                                        <a href="articulo.index.php" class="btn btn-primary pull-right">
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    </div>
                                </div>
                                <form action="articulo_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                     <input type="hidden" name="accion" value="2"/>
                                    <div class="box-body">
                                        <?php $articulos = consultas::get_datos("select * from v_articulo where art_cod =".$_REQUEST['vart_cod'])?>
                                        
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">COD BARRA:</label>
                                            <div class="col-lg-3 col-md-3 col-sm-4">
                                                <input type="hidden" name="vart_cod" value="<?php echo $articulos[0]['art_cod']?>"/>
                                                <input type="text" name="vart_codbarra" value="<?php echo $articulos[0]['art_codbarra']?>"
                                                       class="form-control" autofocus=""/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php $marca = consultas::get_datos("select * from marca order by mar_cod =".$articulos[0]['mar_cod']."desc");?>
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Marca:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <div class="input-group">
                                                    <select class="form-control select2" name="vmar_cod" required="">
                                                        <?php foreach ($marca as $mar) { ?>
                                                        <option value="<?php echo $mar['mar_cod'];?>"><?php echo $mar['mar_descri'];?></option>
                                                        <?php } ?>
                                                         <option value="">Seleccione una marca</option>
                                                    </select>
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-primary btn-flat" 
                                                                data-toggle="modal" data-target="#registrar">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Descripcion:</label>
                                            <div class="col-lg-6 col-md-6 col-sm-7">
                                                <input type="text" name="vart_descri" value="<?php echo $articulos[0]['art_descri']?>"
                                                       class="form-control" required="" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php $tipo_mp = consultas::get_datos("select * from tipo_mp order by tmp_descri");?>
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Tipo Insumo:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <div class="input-group">
                                                    <select class="form-control select2" name="vtmp_cod" required="">
                                                        <option value="">Seleccione un Tipo de Insumo</option>
                                                        <?php foreach ($tipo_mp as $tmp) { ?>
                                                        <option value="<?php echo $tmp['tmp_cod'];?>"><?php echo $tmp['tmp_descri'];?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Precio Costo:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-5">
                                                <input type="number" name="vart_precioc" value="<?php echo $articulos[0]['art_precioc']?>"
                                                       min="0"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Precio Venta:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-5">
                                                <input type="number" name="vart_preciov" value="<?php echo $articulos[0]['art_preciov']?>"
                                                       min="0"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php $impuestos = consultas::get_datos("select * from tipo_impuesto order by tipo_cod =".$articulos[0]['tipo_cod']."desc");?>
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Impuesto:</label>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <div class="input-group">
                                                    <select class="form-control select2" name="vtipo_cod" required="">
                                                        <?php foreach ($impuestos as $impu) { ?>
                                                        <option value="<?php echo $impu['tipo_cod'];?>"><?php echo $impu['tipo_descri'];?></option>
                                                        <?php } ?>
                                                        <option value="">Seleccione un impuesto</option>
                                                    </select>
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-primary btn-flat" 
                                                                data-toggle="modal" data-target="#registrar2">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>      
                                    </div>
                                    <div class="box-footer">
                                        <a href="articulo.index.php" class="btn btn-default">
                                            <i class="fa fa-remove"></i> Cancelar
                                        </a>
                                        <button type="submit" class="btn btn-info pull-right" data-title="Actualizar datos" rel="tooltip">
                                            <i class="fa fa-pencil"> Actualizar</i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                  <?php require 'menu/footer_lte.ctp'; ?><!--ARCHIVOS JS--> 
                  <!--INICIA MODAL REGISTRAR MARCA-->
                  <div class="modal" id="registrar" role="dialog">
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                  <h4 class="modal-title"><i class="fa fa-plus"></i> <strong>Registrar Marca</strong></h4>
                              </div>
                              <form action="articulo_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                  <input type="hidden" name="accion" value="4"/>
                                  <input type="hidden" name="vmar_cod" value="0"/>
                                  <div class="modal-body">
                                      <div class="form-group">
                                          <label class="control-label col-lg-2 col-sm-2 col-md-2">Descripción:</label>
                                          <div class="col-lg-10 col-sm-10 col-md-10">
                                              <input type="text" name="vart_descri" class="form-control" required=""/>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="modal-footer">
                                      <button type="reset" data-dismiss="modal" class="btn btn-default">
                                          <i class="fa fa-remove"></i> Cerrar
                                      </button>
                                      <button type="submit" class="btn btn-primary">
                                          <i class="fa fa-floppy-o"></i> Guardar
                                      </button>                                      
                                  </div>
                              </form>
                          </div>
                      </div>
                  </div>
                 <!--FIN MODAL REGISTRAR MARCA-->
                 <!--INICIA MODAL REGISTRAR TIPO IMPUESTO-->
                 <div class="modal fade" id="registrar2" role="dialog">
                     <div class="modal-dialog">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
                                 <h4 class="modal-title">Registrar Tipo impuesto</h4>
                             </div>
                             <form action="articulo_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                 <input name="accion" value="5" type="hidden"/>
                                 <input name="vtipo_cod" value="0" type="hidden"/>
                                 <div class="box-body">
                                     <div class="form-group">
                                         <label class="col-sm-2 control-label">Descripcion</label>
                                         <div class="col-sm-6 col-lg-6 col-xs-6 col-md-6">
                                             <input type="text" class="form-control" name="vart_descri" required=""/>
                                         </div>
                                     </div>
                                     <div class="form-group">
                                            <label class="col-sm-2 control-label">Porcentaje:</label>
                                            <div class="col-lg-6 col-md-6 col-sm-7">
                                                <input type="number" name="vtipo_cod" class="form-control" required="" 
                                                       min="0" />
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
            </div>                  
        <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
        <script type="text/javascript"> 
            $("input[type=text]").focus(function(){	   
             this.select();
            });
       </script>
    </body>
</html>


