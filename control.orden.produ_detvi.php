<?php 
require 'clases/conexion.php';
//session_start();
 $formulas = consultas::get_datos ("select * from v_orden_produ where cod_orden=".$_REQUEST['vcod_orden']) ; 
$detalles = consultas::get_datos("select * from v_detalle_orden where cod_orden=".$_REQUEST['vcod_orden']);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
    <h4 class="modal-title"><i class="fa fa-eye"></i>Vizualidar Productos</h4>
</div>
<form action="formula_dcontrol.php" method="POST" accept-charset="utf-8" class="form-horizontal">
    <input type="hidden" name="accion" value="2">
    <input type="hidden" name="vcod_orden" value="<?php echo $detalles[0]['cod_orden'];?>">
    <div class="modal-body">
        
        <!--INICIO DETALLE-->
        <div class="box-header">
                                        <i class="fa fa-list"></i>
                                        <h3 class="box-title">Porductos</h3>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                            <?php
                                             $detalles = consultas::get_datos("select * from v_detalle_orden where cod_orden =".$formulas[0]['cod_orden']); 
                                            if (!empty($detalles)) { ?>
                                            <div class="table-responsive">
                                                <table class="table col-lg-12 col-md-12 col-xs-12 table-bordered table-striped table-condensed">
                                                    <thead>
                                                    <th>#</th>
                                                    <th>Descripcion</th>
                                                    
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($detalles as $det) { ?>
                                                        <tr>
                                                            <td data-title="#"><?php echo $det['cod_produ'];?></td>
                                                            <td data-title="Descripcion"><?php echo $det['produ_descri'];?></td>
                                                            <td class="text-center">
                                                            
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



