<?php 
require 'clases/conexion.php';
session_start();
$detalles = consultas::get_datos("select * from v_detalle_pedcompra where ped_com =(select max(ped_com)from v_detalle_pedcompra)"." and art_cod =".$_REQUEST['vart_cod']);

        
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
    <h4 class="modal-title"><i class="fa fa-plus"></i> <strong>Agregar Detalle de Presupuesto Produccion</strong></h4>
</div>
<form action="presupuesto_dcontrol.php" method="post" accept-charset="utf-8" class="form-horizontal">
    <input type="hidden" name="accion" value="1"/>
    <input type="hidden" name="vcod_pp" value="<?php echo $_REQUEST['vcod_pp']?>"/>
    <input type="hidden" name="vart_cod" value="<?php echo $detalles[0]['art_cod']?>"/>
    <div class="modal-body">
        
        <div class="form-group">
            <label class="control-label col-lg-2 col-sm-2 col-md-2">Articulo:</label>
            <div class="col-lg-6 col-sm-6 col-md-6">
                <input type="text" class="form-control" disabled="" value="<?php echo $detalles[0]['art_descri']?>"/>
            </div>
        </div> 
        <div class="form-group">
            <label class="control-label col-lg-2 col-sm-2 col-md-2">Cantidad:</label>
            <div class="col-lg-3 col-sm-3 col-md-3">
                <input type="number" name="vcantidad" class="form-control" min="1" required="" value="<?php echo $detalles[0]['ped_cant']?>"/>
            </div>
        </div> 
        <div class="form-group">
            <label class="control-label col-lg-2 col-sm-2 col-md-2">Precio:</label>
            <div class="col-lg-4 col-sm-4 col-md-4">
                <input type="number" name="vprecio" class="form-control" min="1" required="" value="<?php echo $detalles[0]['ped_precio']?>"/>
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

