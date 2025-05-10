<?php 
require 'clases/conexion.php';
//session_start();
$detalles = consultas::get_datos("select * from v_detalle_control"
            . " where cod_control=" . $_REQUEST['vcod_control'] . " and cod_produ =" . $_REQUEST['vcod_produ']);?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
    <h4 class="modal-title"><i class="fa fa-eye"></i> Detalle de la Etapa</h4>
</div>

    <form action="control.produ_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
    <input type="hidden" name="accion" value="3"/>
    <input type="hidden" name="vcod_control" value="<?php echo $detalles[0]['cod_control'] ?>"/>
    <input type="hidden" name="vcod_produ" value="<?php echo $detalles[0]['cod_produ'] ?>"/>
    <div class="modal-body">
        <!--INICIO DETALLE-->
        <div class="box-header">
                                        <h3 class="fa fa-list" class="box-title"> Detalle de Etapas del Porducto N°: <?php echo $detalles[0]['cod_produ'];?> - Producto:<?php echo $detalles[0]['produ_descri'];?></h3>
                                           
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                            <?php
                                             
                                             $consulta = consultas::get_datos("select et.cod_etapa_p,et.etapa_descrip_p,et.etapa_estado_p from 
                                             etapa et,detalle_etapa det,etapa_prod ep, producto p where det.cod_etapa_p=et.cod_etapa_p and 
                                             det.cod_etapa=ep.cod_etapa and ep.cod_produ = p.cod_produ and p.cod_produ =".$detalles[0]['cod_produ']); 
                                             
                                            if (!empty($consulta)) { ?>
                                            <div class="table-responsive">
                                                <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                    <th>Nro Etapa</th>
                                                    <th>Descripcion</th>
                                                    <th class="text-center">Acciones</th>
                                                    
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($consulta as $det) { ?>
                                                        <tr>
                                                            <td data-title="Nro Etapa"><?php echo $det['cod_etapa_p'];?></td>
                                                            <td data-title="Descripcion"><?php echo $det['etapa_descrip_p'];?></td>
                                                            <td class="text-center"> 
                                                            <a onclick="confirm(<?php
                                                        echo "'" . $pedidosdeta['cod_etapa_p'] . "_" . $pedidosdeta['etapa_descrip_p'] . "'"; ?>)" 


                                                        class="btn btn-success btn-sm" 
                                                                data-title="Agregar" rel="tooltip" 
                                                                data-placement="left" data-toggle="modal" data-target="#confirm">
                                                                <i class="fa fa-check"></i>
                                                            
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
    <div class="modal-footer">
        <button type="reset" data-dismiss="modal" class="btn btn-default">
            <a class="fa fa-remove"></a> Cerrar</button>
    </div>
</form>

 <!--MODAL SOBRE MODAL-->

 <div class="modal" id="confirm" role="dialog">
                      <div class="modal-dialog">
                          <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" 
                                    data-dismiss="modal" arial-label="Close">x</button>
                            <h4 class="modal-title"><strong>Registrar Etapa como Terminado</strong></h4>
                        </div>
                        <form action="control_dcontrol.php" method="post" accept-charset="utf-8" class="form-horizontal">
                            <div class="panel-body">
                            <input name="accion" value="1" type="hidden"/>
                            <input type="hidden" name="vcod_control" value="<?php echo $_REQUEST['vcod_control'] ?>">
                            <input type="hidden" name="vcod_produ" value="<?php echo $_REQUEST['vcod_produ'] ?>">
                            <!--input type="hidden" name="vcod_etapa" value="<?php echo $_REQUEST['vcod_etapa_p'] ?>"-->

                                <span class="col-md-1"></span>
                                <div class="form-group">
                                    <div class="col-md-5">
                                        <label class="col-md-2 control-label"><h3>Observacion:</h3></label>
                                        <input  type="text" required="" 
                                                placeholder="..."
                                                class="form-control" id="vobs">
                                                </div>
                                                </div>    
                                                <button type="submit" class="btn btn-primary pull-right">
                                        <i class="fa fa-refresh"></i> Registrar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


