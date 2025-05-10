<?php
require 'clases/conexion.php';
session_start();
?>
<div class="col-lg-4 col-md-4 col-sm-4">
    <?php
    $pedidos = consultas::get_datos("SELECT * FROM v_pedido_cabventa WHERE cli_cod = " . $_REQUEST['vcli_cod'] . " AND estado = 'PENDIENTE'");
    ?>
    <select class="form-control select2" name="vped_cod">
        <?php if (!empty($pedidos)) { ?>            
            <option value="">Seleccione un pedido</option>        
            <?php foreach ($pedidos as $pedido) { ?>
                <option value="<?php echo $pedido['ped_cod']?>"><?php echo "N°:" . $pedido['ped_cod'] . "- Fecha: " . $pedido['ped_fecha'] . " Total:" . number_format($pedido['ped_total'], 0, ",", ".") ?></option>            
            <?php
            }
        } else {
            ?>
            <option value="">El cliente no tiene pedidos</option> 
        <?php } ?>        
    </select>
</div>



