<?php 
require 'clases/conexion.php';
session_start();
$detalles = consultas::get_datos("select * from v_detalle_equipos where equi_cod=".$_REQUEST['vequi_cod']
        ." and per_cod =".$_REQUEST['vper_cod']);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
    <h4 class="modal-title"><i class="fa fa-plus"></i> <strong>Agregar Detalle equipo de trabajo</strong></h4>
</div>
<form action="costoproduccionequip_dcontrol.php" method="post" accept-charset="utf-8" class="form-horizontal">
    <input type="hidden" name="accion" value="1"/>
    <input type="hidden" name="vcospro_cod" value="<?php echo $_REQUEST['vcospro_cod']?>"/>   
    <!--<input type="hidden" name="vdep_cod" value="<d?php echo $detalles[0]['dep_cod']?>"/>-->
    <input type="hidden" name="vper_cod" value="<?php echo $detalles[0]['per_cod']?>"/>
    <div class="modal-body">
      <!--  <div class="form-group">
            <label class="control-label col-lg-2 col-sm-2 col-md-2">Deposito:</label>
            <div class="col-lg-6 col-sm-6 col-md-6">
                <input type="text" class="form-control" disabled="" value="</?php echo $detalles[0]['dep_descripcion']?>"/>
            </div>
        </div>-->
        <div class="form-group">
            <label class="control-label col-lg-2 col-sm-2 col-md-2">Nombre:</label>
            <div class="col-lg-6 col-sm-6 col-md-6">
                <input type="text" class="form-control" disabled="" value="<?php echo $detalles[0]['per_nombre']." ".$detalles[0]['per_apellido']?>"/>
            </div>
        </div> 
        <div class="form-group">
            <label class="control-label col-lg-2 col-sm-2 col-md-2">Cant. Hora:</label>
            <div class="col-lg-3 col-sm-3 col-md-3">
                <input type="number" name="vcant_detcosto" class="form-control" min="1"  value="<?php echo $detalles[0]['equi_cantidad']?>"/>
            </div>
        </div> 
        <div class="form-group">
            <label class="control-label col-lg-2 col-sm-2 col-md-2">Precio x Hora:</label>
            <div class="col-lg-4 col-sm-4 col-md-4">
                <input type="number" name="vprecio_detcosto" class="form-control" min="1"  value="<?php echo $detalles[0]['equi_precio']?>"/>
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

