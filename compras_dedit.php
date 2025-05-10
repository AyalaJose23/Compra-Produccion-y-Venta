<?php 
require 'clases/conexion.php';
session_start();
$detalles = consultas::get_datos("select * from v_detalle_compras where com_cod=".$_REQUEST['vcom_cod']);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
    <h4 class="modal-title"><i class="fa fa-edit"></i>Editar Detalle de Ventas</h4>
</div>
<form action="compras_dcontrol.php" method="post" accept-charset="utf-8" class="form-horizontal">
    <input type="hidden" name="accion" value="2" />
    <input type="hidden" name="vcom_cod" value="<?php echo $detalles[0]['com_cod']?>"/>
    <input type="hidden" name="vart_cod" value="<?php echo $detalles[0]['art_cod']?>"/>
    <div class="box-body">
        <div class="form-group">
            <label class="col-sm-2 control-label">Deposito</label>
            
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Articulo:</label>
            <div class="col-sm-6 col-lg-6 col-xs-6 col-md-6">
                <input type="text" class="form-control" disabled="" value="<?php echo $detalles[0]['art_descri']." ".$detalles[0]['mar_descri']?>"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Cantidad:</label>
            <div class="col-sm-6 col-lg-6 col-xs-6 col-md-6">
                <input type="number" name="vcom_cant" class="form-control" min="1" required="" value="<?php echo $detalles[0]['com_cant']?>"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Precio:</label>
            <div class="col-sm-6 col-lg-6 col-xs-6 col-md-6">
                <input type="number" name="vcom_precio" class="form-control" min="1" required="" value="<?php echo $detalles[0]['com_precio']?>"/>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="reset" data-dismiss="modal" class="btn btn-default">
            <a class="fa fa-remove"></a> Cerrar</button>
        <button type="submit" class="btn btn-primary pull-right">
            <a class="fa fa-floppy-o"></a> actualizar</button>
    </div>
</form>



