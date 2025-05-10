<?php
require 'clases/conexion.php';
session_start();
?>
<div class="col-lg-4 col-md-4 col-sm-4">
    <?php
    $presupuestos = consultas::get_datos("SELECT * FROM v_pp WHERE estado = 'PENDIENTE'");
    ?>
    <select class="form-control select2" name="vcod_pp">
        <?php if (!empty($presupuestos)) { ?>            
            <option value="">Seleccione un presupuesto</option>        
            <?php foreach ($presupuestos as $presu) { ?>
                <option value="<?php echo $presu['cod_pp']?>"><?php echo "N°:" . $presu['cod_pp'] . "- Fecha: " . $presu['pp_fecha'] . " Total:" . number_format($presu['monto'], 0, ",", ".")?></option>            
            <?php
            }
        } else {
            ?>
            <option value="">El proveedor no tiene presupuestos</option> 
        <?php } ?>        
    </select>
</div>

