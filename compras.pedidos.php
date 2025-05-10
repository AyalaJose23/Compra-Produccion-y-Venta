<?php
require 'clases/conexion.php';
session_start();
?>

<div class="col-lg-4 col-md-4 col-sm-4">

  <?php
  $pedidos = consultas::get_datos("select * from v_orden_compra where prv_cod = ".$_REQUEST['vprv_cod']." and orden_estado = 'PENDIENTE'");
  ?>

  <select class="form-control select2" name="vorden_cod">

  <?php if (!empty($pedidos)) { ?>

    <option value="">Seleccione una Orden</option>
    
    <?php foreach ($pedidos as $pedido) { ?>

      <option value="<?php echo $pedido['orden_cod']?>">
        <?php echo "N°:".$pedido['orden_cod']."- Fecha: ".$pedido['orden_fecha']." Total:". number_format($pedido['orden_total'],0,",",".")?>
      </option>

    <?php }

  } else { ?>

    <option value="">El proveedor no tiene pedidos</option>

  <?php } ?>

  </select>

</div>

