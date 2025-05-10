<?php
require 'clases/conexion.php';
session_start();
?>

<div class="col-lg-4 col-md-4 col-sm-4">

  <?php
  $remision = consultas::get_datos("select * from v_compras where prv_cod = ".$_REQUEST['vprv_cod']." and com_estado = 'CONFIRMADO'");
  ?>

  <select class="form-control select2" name="vcom_cod">

  <?php if (!empty($remision)) { ?>

    <option value="">Seleccione una Factura</option>
    
    <?php foreach ($remision as $remi) { ?>

      <option value="<?php echo $remi['com_cod']?>">
        <?php echo "N°:".$remi['com_cod']."- Fecha: ".$remi['com_fecha']." Total:". number_format($remi['com_total'],0,",",".")?>
      </option>

    <?php }

  } else { ?>

    <option value="">No se realizaron compras del proveedor</option>

  <?php } ?>

  </select>

</div>

