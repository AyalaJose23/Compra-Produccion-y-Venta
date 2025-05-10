<?php 
require 'clases/conexion.php';
session_start();
$detalles = consultas::get_datos("select * from v_detalle_preprod where cod_preprod =(select max(cod_preprod)from v_detalle_preprod)"." and cod_produ =".$_REQUEST['vcod_produ']);

        
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
    <h4 class="modal-title"><i class="fa fa-plus"></i> <strong>Agregar Detalle de Orden</strong></h4>
</div>
<form action="orden.produ_dcontrol.php" method="post" accept-charset="utf-8" class="form-horizontal">
    <input type="hidden" name="accion" value="1"/>
    <input type="hidden" name="vcod_orden" value="<?php echo $_REQUEST['vcod_orden']?>"/>
    <input type="hidden" name="vcod_produ" value="<?php echo $detalles[0]['cod_produ']?>"/>
    <div class="modal-body">
        
        <div class="form-group">
            <label class="control-label col-lg-2 col-sm-2 col-md-2">Producto:</label>
            <div class="col-lg-6 col-sm-6 col-md-6">
                <input type="text" class="form-control" disabled="" value="<?php echo $detalles[0]['produ_descri']?>"/>
            </div>
        </div> 
        <div class="form-group">
            <label class="control-label col-lg-2 col-sm-2 col-md-2">Cantidad:</label>
            <div class="col-lg-3 col-sm-3 col-md-3">
                <input type="number" name="vorden_cant" class="form-control" min="1" required="" value="<?php echo $detalles[0]['preprod_cantidad']?>"/>
            </div>
        </div> 
        <div class="form-group">
            <label class="control-label col-lg-2 col-sm-2 col-md-2">Precio:</label>
            <div class="col-lg-4 col-sm-4 col-md-4">
                <input type="number" name="vorden_precio" class="form-control" min="1" required="" value="<?php echo $detalles[0]['preprod_precio']?>"/>
            </div>
        </div>         
    </div>
    <div class="form-group">
                                                        <label class="control-label col-lg-2 col-sm-3 col-md-2 col-xs-3">Equipo Trabajo:</label>
                                                        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-6">
                                                            <?php $productos = consultas::get_datos("select * from v_equipo_t order by id_equipo");?>
                                                            <select class="form-control select2" name="vid_equipo" required="" id="producto" onchange="precio()">
                                                                <option value="">Seleccione un Equipo</option>
                                                                <?php foreach ($productos as $produ) { ?>
                                                                
                                                                <option value="<?php echo $produ['id_equipo'];?>"><?php echo $produ['nombre_equipo'];?></option>
                                                               <?php }  ?>                                                
                                                            </select>
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

