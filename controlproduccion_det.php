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
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <?php if(!empty($_SESSION['mensaje'])){ ?>
                            <div class="alert alert-danger" role="alert" id="mensaje">
                                <span class="glyphicon glyphicon-exclamation-sign"></span>
                                <?php echo $_SESSION['mensaje'];
                                $_SESSION['mensaje'] = '' ;?>
                            </div>
                            <?php } ?>
                            <div class="content">
                                <div class="row">
                                    <!--impresion del titulo de la pagina-->
                                    <div class="col-lg-12">
                                        <h3 class="page-header text-center alert-info"> <strong>DETALLE CONTROL PRODUCCIÓN</strong>
                                            <a href="controlproduccion_index.php" 
                                            class="btn btn-primary pull-right" 
                                            rel='tooltip' title="Atras">
                                                <i class="glyphicon glyphicon-arrow-left"></i>
                                            </a> 

                                        </h3>
                                    </div>     
                                    <!--Buscador-->
                                </div>
                                <!--INICIO cabecera-->
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <strong>Datos Cabecera del Control Producción</strong>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                            
                                        <?php
                                             $conproduc = consultas::get_datos("select * from v_control_produccion where cod_control= ".$_REQUEST['vcod_control'].""); 
                                             $codigo = $conproduc[0]['cod_control'];
                                            if (!empty($conproduc)) { ?>
                                            <!-- Mostrar el botón Confirmar solo si el estado es "PENDIENTE" --> 
                                            <?php if (!empty($conproduc) && $conproduc[0]['control_estado'] == 'PENDIENTE') { ?> 
                                                <a onclick="confirmar('<?php echo $conproduc[0]['cod_control'] . "_" . $conproduc[0]['cod_orden'] . "_" . $conproduc[0]['fecha']; ?>')" class="btn btn-success btn-sm pull-right" data-title="Confirmar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#confirmar"> <i class="fa fa-check"></i> </a> <?php } ?>
                                            <div class="table-responsive">
                                                <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                <thead>
                                                        <th>#</th>
                                                        <th>Orden N°</th>
                                                        <th>Fecha</th>       
                                                        <th>Empleado</th>
                                                        <th>Estado</th>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($conproduc as $conprod) { ?>
                                                        <tr>
                                                        <td data-title="#"><?php echo $conprod['cod_control'];?></td>
                                                        <td data-title="#"><?php echo $conprod['cod_orden'];?></td>
                                                        <td data-title="Fecha"><?php echo $conprod['fecha'];?></td>
                                                        <td data-title="Empleado"><?php echo $conprod['empleado'];?></td>
                                                        <td data-title="Estado"><?php echo $conprod['control_estado'];?></td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                          <?php  }else{ ?>
                                            <div class="alert alert-info flat">
                                                <span class="glyphicon glyphicon-info-sign"></span>
                                                No se han registrado control de produccion..
                                            </div>
                                         <?php   } ?>
                                        </div>
                                    </div>
                                    </div>
                                    </div>
                                    <!--INICIO CABECERA-->
                                    <!-- INICIO DETALLE PRESUPUESTO PRODUCCION-->
                                    <div class="panel panel-warning">
                                    <div class="panel-heading">
                                        <strong>Detalle de Control </strong>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12">   
                                            <!--?php $detalles = consultas::get_datos("select * from v_detalle_orden where cod_produ not in(select cod_produ from v_detalle_controlproduccion where cod_control = ".$conproduc[0]['cod_control'].")  and cod_orden= ".$conproduc[0]['cod_orden']."");-->
                                            <?php $detalles = consultas::get_datos("select * from v_detalle_controlproduccion where cod_control =".$conproduc[0]['cod_control']);
                                            if (!empty($detalles)) { ?>
                                            <div class="table-responsive">
                                                <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                    <th>#</th>
                                                    <th>Orden N°</th>
                                                    <th>Producto</th>
                                                    <th>Cantidad</th>
                                                    <th>Etapa</th>
                                                    <th>Fecha Inicio</th>
                                                    <th>Fecha Fin</th>
                                                    <th>Estado</th>
                                                    <?php if ($conprod['control_estado'] == 'PENDIENTE') { ?>
                                                    <th class="text-center">Acciones</th>
                                                    <?php } ?>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($detalles as $det) { ?>
                                                        <tr>
                                                            <td data-title="#"><?php echo $det['cod_control'];?></td>
                                                           <!-- <td data-title="#"></?php echo $det['ins_cod'];?></td> -->
                                                            <td data-title="Etapas"><?php echo $det['cod_orden'];?></td>
                                                            <td data-title="Insumos"><?php echo $det['produ_descri'];?></td>                                                            
                                                            <td data-title="Descrp."><?php echo $det['cantidad'];?></td>
                                                            <td data-title="Obs."><?php echo $det['etapa_descrip_p'];?></td>
                                                            <td data-title="Duracion."><?php echo $det['fecha_inicio'];?></td>
                                                            <td data-title="Duracion."><?php echo $det['fecha_fin'];?></td>
                                                            <td data-title="Estado."><?php echo $det['estado'];?></td>
                                                           <td class="text-center">
                                                            <?php if ($conprod['control_estado'] == 'PENDIENTE') { ?>
                                                                <a onclick="borrar(<?php echo "'".$det['cod_control']."_".$det['cod_orden']."_".$det['cod_etapa_p']."_".$det['etapa_descrip_p']."'";?>)" class="btn btn-danger btn-sm" role="button" data-title="Borrar" rel="tooltip"
                                                                   data-placement="top" data-toggle="modal" data-target="#borrar"><i class="fa fa-trash"></i>  
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                       <?php } ?> 
                                                    </tbody>
                                                </table>
                                            </div>
                                          <?php  }else{ ?>
                                            <div class="alert alert-info flat">
                                                <span class="glyphicon glyphicon-info-sign"></span>
                                                control produccion aun no tiene detalles cargados...
                                            </div>
                                         <?php   } ?>
                                        </div>
                                    </div>
                                    <!--FIN DETALLE-->
                                    <!--INICIO AGREGAR DETALLE-->
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                                            <form action="controlproduccion_dcontrol.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                                <div class="box-body">
                                                    <input type="hidden" name="accion" value="1"/>
                                                    <input type="hidden" name="vcod_control" value="<?php echo $conproduc[0]['cod_control']?>"/>
                                                   <div class="form-group">
                                                        <label class="control-label col-lg-2 col-md-2">Etapas:</label>
                                                        <div class="col-lg-3 col-md-3">
                                                            <?php $etapas = consultas::get_datos("select * from etapa order by cod_etapa_p asc");?>
                                                            <select class="form-control select2" name="vcod_etapa_p" required="">
                                                                <option value="">Seleccione una etapa</option>
                                                                <?php foreach ($etapas as $etapa) { ?>
                                                                <?php if ($etapa['etapa_estado_p'] == 'ACTIVO') { ?>
                                                                <option value="<?php echo $etapa['cod_etapa_p'];?>"><?php echo $etapa['etapa_descrip_p'];?></option>
                                                               <?php }  ?>
                                                               <?php }  ?>                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-lg-2 col-md-2">Orden:</label>
                                                        <div class="col-lg-3 col-md-3">
                                                        <?php 
                                                            
                                                            // Modificando la consulta para filtrar por el cod_control
                                                            $pedidos = consultas::get_datos("SELECT o.cod_orden, o.produ_descri, o.orden_cant 
                                                                                            FROM v_detalle_orden o
                                                                                            JOIN control_produ c ON c.cod_orden = o.cod_orden
                                                                                            WHERE c.cod_control = '$codigo'
                                                                                            ORDER BY o.cod_orden"); 
                                                        ?>
                                                            <select class="form-control select2" name="vcod_orden" required="">
                                                                <option value="">Seleccione la orden</option>
                                                                <?php foreach ($pedidos as $pedido) { ?>
                                                                    <option value="<?php echo $pedido['cod_orden'];?>">
                                                                        <?php echo "Orden N°: ".$pedido['cod_orden']."/ Producto: ".$pedido['produ_descri']."/ Cant: ".$pedido['orden_cant'];?>
                                                                    </option> 
                                                                <?php } ?>                                                 
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group"> <label class="control-label col-lg-2 col-md-2">Fecha Inicio:</label> 
                                                        <div class="col-lg-3 col-md-3"> 
                                                            <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" readonly value="<?php echo date('Y-m-d'); ?>"/> 
                                                        </div> 
                                                    </div>
                                                    <div class="form-group has-feedback">
                                                        <label class="control-label col-lg-2 col-md-2">Fecha Fin:</label>
                                                        <div class="col-lg-3 col-md-3">
                                                            <input type="date" name="vfecha_fin" class="form-control" min="<?php echo date('Y-m-d');?>" value="<?php echo date('Y-m-d'); ?>"/>
                                                            <i class="fa fa-calendar form-control-feedback"></i>
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
            
          function confirmar(datos) {
            var dat = datos.split('_');
            $('#sic').attr('href', 'control.produ_control.php?vcod_control=' + dat[0] + '&fecha=' + dat[1] + '&accion=2');
            $("#confirmacionc").html('<span class="glyphicon glyphicon-info-sign"></span> \n\
                Desea confirmar el Control Produccion N° <strong>' + dat[0] + '</strong> de fecha <strong>' + dat[1] + '</strong>');
            } 
            
            function borrar(datos) {
                var dat = datos.split('_');
                $('#si').attr('href','controlproduccion_dcontrol.php?vcod_etapa_p='+dat[0]+'&vcod_control='+dat[1]+'&vcod_orden='+dat[2]+'&vins_cod='+dat[3]+'&accion=3');
                $('#confirmacion').html('<span class="glyphicon glyphicon-warning-sign"></span> \n\
                                Desea quitar el insumo <i><strong>'+dat[4]+'</strong>');
            };

            function precios() {
                var dat = $('#insumo').val().split("_");
                $('#vprecio').val(dat[1]);
              
            }
            function stock() {
                var dat = $('#can').val().split("_");
                $('#vreal').val(dat[1]);
               
            };
            
        // Get the current date in the format "YYYY-MM-DD"
    function getCurrentDate() {
        const today = new Date();
        const year = today.getFullYear();
        const month = (today.getMonth() + 1).toString().padStart(2, '0'); // January is 0
        const day = today.getDate().toString().padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    // Set the current date as the default value for the date input
    const vinsFechavenceInput = document.getElementById("vins_fechavence");
    vinsFechavenceInput.value = getCurrentDate();
        </script>
    </body>
</html>


