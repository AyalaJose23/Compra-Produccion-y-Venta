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
                                        <h3 class="page-header text-center alert-info"> <strong>DETALLE COSTO PRODUCCIÓN</strong>
                                            <a href="costoproduccion_index.php" 
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
                                        <strong>Datos Cabecera del Costo Producción</strong>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                        <?php
                                             $costoproduc = consultas::get_datos("select * from v_costo_p where id_costo= ".$_REQUEST['vid_costo'].""); 
                                             $codigo = $costoproduc[0]['id_costo'];
                                            if (!empty($costoproduc)) { ?>
                                            <!-- Mostrar el botón Confirmar solo si el estado es "PENDIENTE" --> 
                                            <?php if (!empty($costoproduc) && $costoproduc[0]['costo_estado'] == 'PENDIENTE') { ?> 
                                                <a onclick="confirmar('<?php echo $costoproduc[0]['id_costo'] . "_" . $costoproduc[0]['cod_orden'] ; ?>')" class="btn btn-success btn-sm pull-right" data-title="Confirmar" rel="tooltip" data-placement="left" data-toggle="modal" data-target="#confirmar"> <i class="fa fa-check"></i> </a> <?php } ?>
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
                                                        <?php foreach ($costoproduc as $costoprod) { ?>
                                                        <tr>
                                                        <td data-title="#"><?php echo $costoprod['id_costo'];?></td>
                                                        <td data-title="#"><?php echo $costoprod['cod_orden'];?></td>
                                                        <td data-title="Fecha"><?php echo $costoprod['fecha_costo'];?></td>
                                                        <td data-title="Empleado"><?php echo $costoprod['empleado'];?></td>
                                                        <td data-title="Estado"><?php echo $costoprod['costo_estado'];?></td>
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
                                        <strong>Detalle de Costo </strong>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12">   
                                            <?php $detalles = consultas::get_datos("select * from v_detalle_costoproduccion where id_costo =".$costoproduc[0]['id_costo']);
                                            if (!empty($detalles)) { ?>
                                            <div class="table-responsive">
                                                <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                    <th>#</th>
                                                    <th>Orden N°</th>
                                                    <th>Producto</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio</th>
                                                    <th>Costo Indirecto </th>
                                                    <th>Tipo Costo </th>
                                                    <th>Monto</th>
                                                    <th class="text-center">Acciones</th>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($detalles as $det) { ?>
                                                        <tr>
                                                            <td data-title="#"><?php echo $det['id_costo'];?></td>
                                                           <!-- <td data-title="#"></?php echo $det['ins_cod'];?></td> -->
                                                            <td data-title="Etapas"><?php echo $det['cod_orden'];?></td>
                                                            <td data-title="Insumos"><?php echo $det['produ_descri'];?></td>  
                                                            <td data-title="Descrp."><?php echo $det['cantidad'];?></td>                                                          
                                                            <td data-title="Descrp."><?php echo $det['orden_precio'];?></td>
                                                            <td data-title="Obs."><?php echo $det['ci_descri'];?></td>
                                                            <td data-title="Obs."><?php echo $det['descri'];?></td>
                                                            <td data-title="Estado."><?php echo $det['ci_monto'];?></td>
                                                           <td class="text-center">
                                                            <?php if ($costoprod['costo_estado'] == 'PENDIENTE') { ?>
                                                                <a onclick="borrar(<?php echo "'".$det['id_costo']."_".$det['cod_orden']."_".$det['id_costo_indirecto']."_".$det['ci_descri']."'";?>)" class="btn btn-danger btn-sm" role="button" data-title="Borrar" rel="tooltip"
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
                                            <form action="costoproduccion_dcontrol.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                                <div class="box-body">
                                                    <input type="hidden" name="accion" value="1"/>
                                                    <input type="hidden" name="vid_costo" value="<?php echo $conproduc[0]['id_costo']?>"/>
                                                    <div class="form-group">
                                          <?php $equipos = consultas::get_datos("select * from v_costos_indirectos order by id_costo_indirecto"); ?>
                                          <label class="control-label col-lg-2 col-md-2 col-sm-2" style="left: 120px">TIPO COSTO:</label>
                                          <div class="col-lg-6 col-md-6 col-sm-6">
                                              <div class="input-group" style="left: 138px;">
                                                  <select class="form-control select2" name="vid_costo_indirecto" required="" style="width: 300px;">
                                                      <option value="">Seleccione equipo trabajo</option>
                                                      <?php foreach ($equipos as $equi) { ?>
                                                          <?php if ($equi['ci_estado'] == 'ACTIVO') { ?>
                                                              <option value="<?php echo $equi['id_costo_indirecto']; ?>"><?php echo " / " . $equi['ci_descri']; ?></option>
                                                          <?php } ?>
                                                      <?php } ?>
                                                  </select>
                                              </div>
                                          </div>                               
                                      </div>
                                                <div class="modal-footer">
                                                    <button type="reset" data-dismiss="modal" class="btn btn-default">
                                                        <i class="fa fa-remove"></i> Cerrar
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fa fa-plus"></i> Agregar
                                                    </button>                                      
                                                </div>
                                            </form>

