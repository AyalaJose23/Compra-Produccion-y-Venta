<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="img/mueble.png"/>
    <title>Todo Muebles</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php 
    session_start();
    require 'menu/css_lte.ctp'; ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php require 'menu/header_lte.ctp'; ?>
        <?php require 'menu/toolbar_lte.ctp'; ?>
        <div class="content-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?php if(!empty($_SESSION['mensaje'])) { ?>
                        <div class="alert alert-danger" role="alert" id="mensaje">
                            <span class="glyphicon glyphicon-exclamation-sign"></span>
                            <?php echo $_SESSION['mensaje']; $_SESSION['mensaje'] = ''; ?>
                        </div>
                        <?php } ?>
                        
                        <h3 class="page-header text-center alert-info">
                            <strong>DETALLE AJUSTES STOCK</strong>
                            <a href="ajuste_stock.index.php" class="btn btn-primary pull-right" rel="tooltip" title="Atras">
                                <i class="glyphicon glyphicon-arrow-left"></i>
                            </a>
                        </h3>

                        <!-- Panel Datos Cabecera de la Orden -->
                        <div class="panel panel-info">
                            <div class="panel-heading"><strong>Datos Cabecera del Ajuste</strong></div>
                            <div class="panel-body">
                                <?php 
                                $ajuste_stock = consultas::get_datos("SELECT * FROM v_ajuste_stock WHERE id_ajuste = " . $_REQUEST['vid_ajuste']);
                                if (!empty($ajuste_stock)) { ?>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-condensed">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">Fecha</th>
                                                    <th class="text-center">Funcionario</th>
                                                    <th class="text-center">Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($ajuste_stock as $ajustes) { ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $ajustes['id_ajuste']; ?></td>
                                                    <td class="text-center"><?php echo $ajustes['fecha']; ?></td>
                                                    <td class="text-center"><?php echo $ajustes['empleado']; ?></td>
                                                    <td class="text-center"><?php echo $ajustes['estado']; ?></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php } else { ?>
                                    <div class="alert alert-info flat">
                                        <span class="glyphicon glyphicon-info-sign"></span>
                                        No se encontraron registros.
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        
                        <!-- Panel Detalle del Ajuste -->
                        <div class="panel panel-info">
                            <div class="panel-heading"><strong>Detalle del Ajuste</strong></div>
                            <div class="panel-body">
                                <?php 
                                $ordendet = consultas::get_datos("SELECT * FROM v_detalle_ajuste WHERE id_ajuste=" . $_REQUEST['vid_ajuste'] . " ORDER BY id_ajuste ASC");
                                if (!empty($ordendet)) { ?>                                    
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-condensed table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Descripción</th>
                                                    <th>Cant.</th>
                                                    <th>Precio</th>
                                                    <th>Impuesto</th>
                                                    <th>Subtotal</th>
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($ordendet as $odet) { ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $ajustedeta['cod_ajuste']; ?></td>
                                                    <td class="text-center"><?php echo $ajustedeta['art_descri']; ?></td>
                                                    <td class="text-center"><?php echo $ajustedeta['dep_descri']; ?></td>
                                                    <td class="text-center"><?php echo $ajustedeta['motivo_ajuste']; ?></td>
                                                    <td class="text-center"><?php echo $ajustedeta['descri_motivo']; ?></td>
                                                    <td class="text-center"><?php echo $ajustedeta['canti_fisica_actual']; ?></td>
                                                    <td class="text-center"><?php echo $ajustedeta['canti_logica_anterior']; ?></td>
                                                    <td class="text-center">
                                                        <a onclick="agregar(<?php echo $ajustes[0]['id_ajuste'];?>, <?php echo $odet['orden_cod'];?>, <?php echo $odet['art_cod'];?>)"
                                                        class="btn btn-success btn-sm" data-title="Agregar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#editar">
                                                        <i class="fa fa-plus"></i>
                                                        </a>                                                                 
                                                    </td>
                                                </tr>  
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-md-12">
                                        <div class="alert alert-info alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <strong>No se encontraron detalles para el ajuste.</strong>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <!-- Panel Agregar Detalle -->
                        <div class="panel panel-info">
                            <div class="panel-heading"><strong>Agregar Detalle del Ajuste</strong></div>
                            <div class="panel-body">
                                <form action="ajuste_stock.detcontrol.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                    <input type="hidden" name="accion" value="1"/>
                                    <input type="hidden" name="vid_ajuste" value="<?php echo $pedido[0]['id_ajuste']?>"/>
                                    
                                    <!-- Selección de Depósito -->
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Depósito:</label>
                                        <div class="col-md-4">
                                            <?php $articulos = consultas::get_datos("SELECT * FROM deposito ORDER BY dep_cod"); ?>
                                            <select class="form-control select2" name="vdep_cod" required id="deposito">
                                                <option value="">Seleccione un depósito</option>
                                                <?php foreach ($articulos as $articulo) { ?>
                                                <option value="<?php echo $articulo['art_cod']; ?>">
                                                    <?php echo $articulo['art_descri']." ".$articulo['mar_descri']; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        
                                        <label class="control-label col-md-2">Artículos:</label>
                                        <div class="col-md-4" id="detalles">
                                            <select class="form-control" required>
                                                <option>Seleccione un artículo</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <!-- Descripción del Ajuste -->
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Descripción:</label>
                                        <div class="col-md-4">
                                            <select name="vdescri" class="form-control" id="vcondicion" onchange="tiposelect();">
                                                <option value="ESTUVO EXTRAVIADO">ESTUVO EXTRAVIADO</option>
                                                <option value="NO EXISTE">NO EXISTE</option>
                                                <option value="REVISION DESPUES DE COMPRAS">REVISION DESPUES DE COMPRAS</option>
                                                <option value="REVISION DESPUES DE VENTAS">REVISION DESPUES DE VENTAS</option>
                                                <option value="ROBO O HURTO">ROBO O HURTO</option>
                                                <option value="REVISION DE RUTINA">REVISION DE RUTINA</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <!-- Motivo del Ajuste -->
                                    <div class="form-group">
                                        <label class="control-label col-md-2"><strong>Motivo:</strong></label>
                                        <div class="col-md-4">
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="vmotivo" id="entrada" value="ENTRADA" checked> ENTRADA
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="vmotivo" id="salida" value="SALIDA"> SALIDA
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Cantidades Lógica y Física -->
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Cant. Lógica:</label>
                                        <div class="col-md-4">
                                            <input type="number" placeholder="Cantidad en Stock" class="form-control" name="vcant_logica" readonly>
                                        </div>
                                        
                                        <label class="control-label col-md-2">Cant. Física:</label>
                                        <div class="col-md-4">
                                            <input type="number" required placeholder="Especifique Cantidad" class="form-control" min="1" name="vcant" id="cant" value="0" onchange="stock()">
                                        </div>
                                    </div>
                                    
                                    <!-- Botón de Agregar -->
                                    <div class="form-group">
                                        <div class="col-md-12 text-right">
                                            <button type="submit" class="btn btn-primary">
                                                <span class="fa fa-plus"> Agregar</span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <?php require 'menu/footer_lte.ctp'; ?>
                    </div>
                </div>
            </div>
        </div>
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
        $("#mensaje").delay(4000).slideUp(200,function(){
           $(this).alert('close'); 
        });
        </script>
        <script>
        function borrar(datos){
            var dat = datos.split('_');
            $('#si').attr('href', 'compras_dcontrol.php?vid_ajuste=' + dat[0] + '&vart_cod=' + dat[1] + '&accion=3');
            $("#confirmacion").html('<span class="glyphicon glyphicon-warning-sign"></span> \n\
            Desea quitar el articulo <strong>' + dat[2] + '</strong> ?');
        };

        function precio(){
            var dat = $('#articulo').val().split('_');
            $('#vprecio').val(dat[1]);
        };
        function editar(com, art) {
            $.ajax({
                type: "GET",
                url: "/tdp/compras_dedit.php?vid_ajuste=" + com + "&vart_cod=" + art,
                cache: false,
                beforeSend: function () {
                    $('#detalles').html('<img src="img/loader.gif" /><strong>Cargando...</strong>');
                },
                success: function (data) {
                    $('#detalles').html(data);
                }
            });
        };

        // Función en JS
                    function agregar(com, ord, art) {

                    $.ajax({
                        type: "GET",
                        url: "/tdp/compras_dadd.php?vid_ajuste=" + com + "&vorden_cod=" + ord + "&vart_cod=" + art,
                        cache: false,

                    beforeSend: function() {
                        $('#detalles').html('<img src="img/loader.gif" /><strong>Cargando...</strong>');
                    },
                    success: function(data) {
                        $('#detalles').html(data);
                    }
                    })

                    };        
        function confirmar(datos){
            var dat = datos.split('_');
            $('#sic').attr('href','compras_control.php?vid_ajuste='+dat[0]+'&accion=2');
            $("#confirmacionc").html('<span class="glyphicon glyphicon-info-sign"></span> \n\
            Desea confirmar la Compra N° <strong>'+dat[0]+'</strong> del proveedor <strong>'+dat[1]+'</strong> de fecha <strong>'+dat[2]+'</strong>')
        }           
        </script> 
    </body>
</html>
