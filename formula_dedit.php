<?php 
require 'clases/conexion.php';
//session_start();
$detalles = consultas::get_datos("select * from v_detalle_formula where cod_formula=".$_REQUEST['vcod_formula']
        ." and art_cod=".$_REQUEST['vart_cod']);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
    <h4 class="modal-title"><i class="fa fa-edit"></i>Editar Detalle de la Formula</h4>
</div>
<form action="formula_dcontrol.php" method="POST" accept-charset="utf-8" class="form-horizontal">
    <input type="hidden" name="accion" value="2">
    <input type="hidden" name="vcod_formula" value="<?php echo $detalles[0]['cod_formula'];?>">
    <input type="hidden" name="vart_cod" value="<?php echo $detalles[0]['art_cod'];?>">
    <input type="hidden" name="vcod_prece" value="<?php echo $detalles[0]['cod_prece'];?>">
    <div class="modal-body">
        
        <div class="form-group">
            <label class="control-label col-lg-2 col-md-2 col-sm-2">Articulos:</label>
            <div class="col-lg-6 col-md-6 col-sm-7">
                <input type="text" class="form-control" name="vart_descri" value="<?php echo $detalles[0]['art_descri'];?>" readonly="">
            </div>
        </div> 
        <div class="form-group">
                                                            <label class="control-label col-lg-2 col-sm-3 col-md-2 col-xs-2">Cantidad:</label>
                                                            <div class="col-lg-4 col-sm-4 col-md-4 col-xs-6">
                                                                <input type="number" name="vformula_cant" class="form-control" value="1" step="0.01" required=""/>
                                                            </div>
</div>
        </div>
        <div class="form-group">
        <label class="control-label col-lg-2 col-sm-3 col-md-2 col-xs-2">Precentacion:</label>
            <div class="col-lg-6 col-md-6 col-sm-7">
                <?php $precentacion = consultas::get_datos("SELECT * FROM precentacion WHERE prece_estado = 'ACTIVO' ORDER BY prece_descri");?>
                    <select class="form-control select2" name="vcod_prece">
                <?php if (!empty($precentacion)) { ?>            
                    <option value="">Seleccione una precentacion </option>        
                <?php foreach ($precentacion as $prece) { ?>
                    <option value="<?php echo $prece['cod_prece']?>"><?php echo " Descripcion: " . $prece['prece_descri'] ?></option>            
                <?php
                    }
                    } else {
                ?>
                    <option value="">El articulo no tiene precentacion</option> 
                <?php } ?>        
                    </select>
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



