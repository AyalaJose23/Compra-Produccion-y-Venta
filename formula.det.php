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
    <body class="hold-transition skin-black sidebar-mini">
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
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="fa fa-plus"></i><i class="fa fa-list"></i>
                                    <h3 class="box-title">Agregar Detalle Formula</h3>
                                    <div class="box-tools">
                                        <a href="formula.index.php" class="btn btn-primary btn-sm" data-title="Volver" rel="tooltip" data-placement="left">
                                            <i class="fa fa-arrow-left"></i> VOLVER</a>                                            
                                    </div>
                                </div>
                                
                                <div class="box-body no-padding">
                                    <!--INICIO CABECERA-->
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                            <?php
                                             $formulas = consultas::get_datos
                                             ("select * from v_formula where cod_formula=".$_REQUEST['vcod_formula']) ;
                                            if (!empty($formulas)) { ?>
                                            <div class="table-responsive">
                                                <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                    <th>#</th>
                                                    <th>Fecha</th>
                                                    <th>Descripción</th>
                                                    <th>Producto</th>
                                                    <th>Estado</th>
                                                    
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($formulas as $formula) { ?>
                                                        <tr>
                                                            <td data-title="#"><?php echo $formula['cod_formula'];?></td>
                                                            <td data-title="Fecha"><?php echo $formula['formula_fecha'];?></td>
                                                            <td data-title="Descripcion"><?php echo $formula['formula_descrip'];?></td>
                                                            <td data-title="Producto"><?php echo $formula['producto'];?></td>
                                                            <td data-title="Estado"><?php echo $formula['formula_estado'];?></td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                          <?php  }else{ ?>
                                            <div class="alert alert-info flat">
                                                <span class="glyphicon glyphicon-info-sign"></span>
                                                No se han registrado formulas..
                                            </div>
                                         <?php   } ?>
                                        </div>
                                    </div>
                                    <!--INICIO CABECERA-->
                                    <!--INICIO DETALLE-->
                                    <div class="box-header">
                                        <i class="fa fa-plus"></i><i class="fa fa-list"></i>
                                        <h3 class="box-title">Detalle Items</h3>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                            <?php
                                             $detalles = consultas::get_datos("select * from v_detalle_formula where cod_formula =".$formulas[0]['cod_formula']); 
                                            if (!empty($detalles)) { ?>
                                            <div class="table-responsive">
                                                <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                    <th>#</th>
                                                    <th>Descripcion</th>
                                                    <th>Cant.</th>
                                                    <th>Presentación</th>
                                                    <th class="text-center">Acciones</th>
                                                    
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($detalles as $det) { ?>
                                                        <tr>
                                                            <td data-title="#"><?php echo $det['art_cod'];?></td>
                                                            <td data-title="Descripcion"><?php echo $det['art_descri'];?></td>
                                                            <td data-title="Cant."><?php echo $det['formula_cant'];?></td>
                                                            <td data-title="Cant."><?php echo $det['prece_descri'];?></td>
                                                            <td class="text-center">
                                                            <a onclick="editar(<?php echo $det['cod_formula']; ?>, <?php echo $det['art_cod']; ?>, <?php echo $det['cod_prece']; ?>)" class="btn btn-warning btn-sm" data-title="Editar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#editar">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                               
                                                                <a onclick="borrar(<?php echo "'".$det['cod_formula']."_".$det['art_cod']."_".$det['cod_prece']."'";?>)" class="btn btn-danger btn-sm" role="button" data-title="Borrar" rel="tooltip"
                                                                   data-placement="top" data-toggle="modal" data-target="#borrar"><i class="fa fa-trash"></i>  
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                          <?php  }else{ ?>
                                            <div class="alert alert-info flat">
                                                <span class="glyphicon glyphicon-info-sign"></span>
                                                El formula aun no tiene detalles cargados...
                                            </div>
                                         <?php   } ?>
                                        </div>
                                    </div>
                                    <!--FIN DETALLE-->

                                    <!--INICIO AGREGAR DETALLE-->
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                            <form action="formula_dcontrol.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                                <div class="box-body">
                                                    <input type="hidden" name="accion" value="1"/>
                                                    <input type="hidden" name="vcod_formula" value="<?php echo $formulas[0]['cod_formula']?>"/>
                                                    
                                                    <!--div class="form-group">
                                                    <?php  $tipomp = consultas::get_datos("SELECT * FROM tipo_mp WHERE tmp_estado = 'ACTIVO' ORDER BY tmp_descri");?>
                                                        <label class="control-label col-lg-2 col-md-2 col-sm-2">Tipo de Insumo:</label>
                                                        <div class="col-lg-5 col-md-5 col-sm-5">
                                                            <div class="input-group">
                                                                <select class="form-control select2" name="vtmp_cod" required id="tmp" onchange="tipo_insumo(); return false;">
                                                                    <option value="">Seleccione un tipo de Insumo</option>
                                                                    <?php foreach ($tipomp as $tmp) { ?>
                                                                    <option value="<?php echo $tmp['tmp_cod'];?>"><?php echo $tmp['tmp_descri'];?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <div id="tipo_insumo"></div>
                                                            </div>
                                                        </div-->
                                                        <div class="form-group">
                                                        <label class="control-label col-lg-2 col-sm-3 col-md-2 col-xs-2">Insumos:</label>
                                                        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-6">
                                                            <?php
                                                            $articulos = consultas::get_datos("SELECT * FROM v_articulo WHERE art_estado = 'ACTIVO'");
                                                            ?>
                                                            <select class="form-control select2" name="vart_cod">
                                                                <?php if (!empty($articulos)) { ?>            
                                                                    <option value="">Seleccione un articulo</option>        
                                                                    <?php foreach ($articulos as $art) { ?>
                                                                        <option value="<?php echo $art['art_cod']?>"><?php echo "Tipo:" . $art['tmp_descri'] . " - Descripcion: " . $art['art_descri'] ?></option>            
                                                                    <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <option value="">El proveedor no tiene articulos</option> 
                                                                <?php } ?>        
                                                            </select>
                                                        </div>
                                                        </div>
                                                      

  
                                                        <div class="form-group">
                                                            <label class="control-label col-lg-2 col-sm-3 col-md-2 col-xs-2">Cantidad:</label>
                                                            <div class="col-lg-4 col-sm-4 col-md-4 col-xs-6">
                                                                <input type="number" name="vformula_cant" class="form-control" value="1" step="0.01" required=""/>
                                                            </div>
                                                        </div>

                                               
                                                <div class="form-group">
                                                        <label class="control-label col-lg-2 col-sm-3 col-md-2 col-xs-2">Precentacion:</label>
                                                        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-6">
                                                            <?php
                                                            $precentacion = consultas::get_datos("SELECT * FROM precentacion WHERE prece_estado = 'ACTIVO' ORDER BY prece_descri");
                                                            ?>
                                                            <select class="form-control select2" name="vcod_prece">
                                                                <?php if (!empty($precentacion)) { ?>            
                                                                    <option value="">Seleccione una precentacion </option>        
                                                                    <?php foreach ($precentacion as $prece) { ?>
                                                                        <option value="<?php echo $prece['cod_prece']?>"><?php echo " Descripcion: " . $prece['prece_descri'] ?></option>            
                                                                    <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <option value="">El articulo no tiene precentacion</option> 
                                                                <?php } ?>        
                                                            </select>
                                                        </div>
                                                        </div>
                                                </div>
                                                
                                                <div class="box-footer">
                                                    <button type="submit" class="btn btn-primary pull-right">
                                                        <span class="fa fa-plus"> Agregar</span>
                                                    </button>
                                                </div>
                                            </form> 
                                        </div>
                                    </div>
                                    <!--FIN AGREGAR-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                  <?php require 'menu/footer_lte.ctp'; ?><!--ARCHIVOS JS--> 
                 
                 <!-- MODAL BORRAR-->
                 <div class="modal" id="borrar" role="dialog">
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
                  <!-- FIN MODAL BORRAR-->
                 <!-- MODAL EDITAR-->
                  <div class="modal" id="editar" role="dialog">
                      <div class="modal-dialog">
                          <div class="modal-content" id="detalles">
                          </div>
                      </div>
                  </div>
                  <!-- FIN MODAL EDITAR-->
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
            function borrar(datos) {
                    var dat = datos.split('_');
                    $('#si').attr('href', 'formula_dcontrol.php?vcod_formula=' + dat[0] + '&vart_cod=' + dat[1] + '&vcod_prece=' + dat[2] + '&accion=3');
                    $("#confirmacion").html('<span class="glyphicon glyphicon-warning-sign"></span> \\n\\ Desea quitar el articulo <strong>' + dat[1] + '</strong> ?');
                }
            
            function precio() {
                var dat = $('#produ').val().split("_");
                $('#vprecio').val(dat[1]);
               
            }
            function editar(formula,art){
            $.ajax({
                type    : "GET",
                url     : "formula_dedit.php?vcod_formula="+formula+"&vart_cod="+art,
                cache   : false,
                beforeSend: function () {
                                $('#detalles').html(`
                                    <div style="display: flex; justify-content: center; align-items: center; height: 50vh;">
                                        <img src="img/loader.gif" width="50" height="50" />
                                        <strong style="margin-left: 10px;">Cargando...</strong>
                                    </div>
                                `);
                            },

                            success: function (data) {
    setTimeout(function() {
        $('#detalles').html(data);
    }, 300); // Retraso de segundos
                        }
                    });
                }
        
        
        function tipo_insumo(){
            console.log($('#tmp').val()),
        $.ajax({
            type    : "GET",
            url     : "formula.tmp.php?vtmp_cod="+$('#tmp').val(),
            cache   : false,
            beforeSend:function(){
                $('#vart_cod').html('<img src="img/loader.gif" /><strong>Cargando...</strong>')
            },
            success:function(data){
                $('#vart_cod').html(data);
            }
        });
    }
    
        </script>
    </body>
</html>


