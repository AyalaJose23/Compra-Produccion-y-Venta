<?php 
require 'clases/conexion.php';
session_start();
$detalles = consultas::get_datos("select * from v_detalle_pedinsumos where pedins_cod=".$_REQUEST['vpedins_cod']
        ." and ins_cod =".$_REQUEST['vins_cod']);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
    <h4 class="modal-title"><i class="fa fa-plus"></i> <strong>Agregar Detalle Pedido insumo</strong></h4>
</div>
<form action="costoproduccion_dcontrol.php" method="post" accept-charset="utf-8" class="form-horizontal">
    <input type="hidden" name="accion" value="1"/>
    <input type="hidden" name="vcospro_cod" value="<?php echo $_REQUEST['vcospro_cod']?>"/>   
    <!--<input type="hidden" name="vdep_cod" value="<d?php echo $detalles[0]['dep_cod']?>"/>-->
    <input type="hidden" name="vins_cod" value="<?php echo $detalles[0]['ins_cod']?>"/>
    <div class="modal-body">
      <!--  <div class="form-group">
            <label class="control-label col-lg-2 col-sm-2 col-md-2">Deposito:</label>
            <div class="col-lg-6 col-sm-6 col-md-6">
                <input type="text" class="form-control" disabled="" value="</?php echo $detalles[0]['dep_descripcion']?>"/>
            </div>
        </div>-->
        <div class="form-group">
            <label class="control-label col-lg-2 col-sm-2 col-md-2">Insumo:</label>
            <div class="col-lg-6 col-sm-6 col-md-6">
                <input type="text" class="form-control" disabled="" value="<?php echo $detalles[0]['ins_descripcion']." ".$detalles[0]['pres_descripcion']?>"/>
            </div>
        </div> 
        <div class="form-group">
            <label class="control-label col-lg-2 col-sm-2 col-md-2">Cantidad:</label>
            <div class="col-lg-3 col-sm-3 col-md-3">
                <input type="number" name="vdetcos_cantidad" class="form-control" min="1"   value="<?php echo $detalles[0]['detins_cant']?>"/>
            </div>
        </div> 
        <div class="form-group">
            <label class="control-label col-lg-2 col-sm-2 col-md-2">Precio:</label>
            <div class="col-lg-4 col-sm-4 col-md-4">
                <input type="number" name="vdetcos_preciounitario" class="form-control" min="1"  value="<?php echo $detalles[0]['detins_precio']?>"/>
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

