<?php 
require 'clases/conexion.php';
//session_start();
$detalles = consultas::get_datos("select * from v_detalle_pedmp where ped_mp=".$_REQUEST['vped_mp']
        ." and art_cod=".$_REQUEST['vart_cod']);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
    <h4 class="modal-title"><i class="fa fa-edit"></i>Editar Detalle del Pedido</h4>
</div>
<form action="pedmp_dcontrol.php" method="POST" accept-charset="utf-8" class="form-horizontal">
    <input type="hidden" name="accion" value="2">
    <input type="hidden" name="vped_mp" value="<?php echo $detalles[0]['ped_mp'];?>">
    <input type="hidden" name="vart_cod" value="<?php echo $detalles[0]['art_cod'];?>">
    <div class="modal-body">
        
        <div class="form-group">
            <label class="control-label col-lg-2 col-md-2 col-sm-2">Articulos:</label>
            <div class="col-lg-6 col-md-6 col-sm-7">
                <input type="text" class="form-control" name="vart_descri" value="<?php echo $detalles[0]['art_descri']." ".$detalles[0]['mar_descri'];?>" readonly="">
            </div>
        </div> 
        <div class="form-group">
            <label class="control-label col-lg-2 col-md-2 col-sm-2">Cantidad:</label>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <input type="number" class="form-control" name="vped_cant" min="1" value="<?php echo $detalles[0]['ped_cant'];?>"/>
            </div>
        </div>
        
    </div>
    <div class="modal-footer">
        <button type="reset" data-dismiss="modal" class="btn btn-default">
            <a class="fa fa-remove"></a> Cerrar</button>
        <button type="submit" class="btn btn-primary pull-right">
            <a class="fa fa-floppy-o"></a> Guardar</button>
    </div>
</form>



