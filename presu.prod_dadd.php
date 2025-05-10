<?php 
require 'clases/conexion.php';
session_start();

// Consulta para obtener los detalles del producto seleccionado
$detalles = consultas::get_datos("select * from v_detalle_pedventa where ped_cod =(select max(ped_cod)from v_detalle_pedventa)"." and cod_produ =".$_REQUEST['vcod_produ']);

// Consulta para obtener el precio del producto desde la tabla productos
$producto = consultas::get_datos("select precio_v from producto where cod_produ =".$_REQUEST['vcod_produ']);

?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
    <h4 class="modal-title"><i class="fa fa-plus"></i> <strong>Agregar Detalle de Presupuesto Producción</strong></h4>
</div>
<form action="presu_prod_dcontrol.php" method="post" accept-charset="utf-8" class="form-horizontal">
    <input type="hidden" name="accion" value="1"/>
    <input type="hidden" name="vcod_preprod" value="<?php echo $_REQUEST['vcod_preprod']?>"/>
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
                <input type="number" name="vpreprod_cantidad" class="form-control" min="1" required="" value="<?php echo $detalles[0]['ped_cant']?>"/>
            </div>
        </div> 
        <div class="form-group">
            <label class="control-label col-lg-2 col-sm-2 col-md-2">Precio:</label>
            <div class="col-lg-4 col-sm-4 col-md-4">
                <!-- Mostrar el precio del producto desde la tabla productos -->
                <input type="number" name="vpreprod_precio" class="form-control" min="1" required="" value="<?php echo $producto[0]['precio_v'] ?>"/>
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
